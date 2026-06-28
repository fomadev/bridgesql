<?php

/* * Copyright (c) 2026 Fordi / FomaDev.
 * Licensed under FomaDev Public License.
 * See LICENSE file in the project root for full license information.
 */

namespace BridgeSQL\Tests;

use BridgeSQL\BridgeSQL;
use BridgeSQL\Exceptions\BridgeSQLException;
use PHPUnit\Framework\TestCase;

class BridgeSQLTest extends TestCase
{
    private array $config;

    protected function setUp(): void
    {
        // Configuration standard utilisant SQLite en mémoire pour les tests unitaires
        $this->config = [
            'driver' => 'sqlite',
            'path'   => ':memory:'
        ];
    }

    /**
     * Teste l'initialisation de la connexion et l'exécution d'une requête de base.
     */
    public function testConnectionAndBasicExecution(): void
    {
        $db = new BridgeSQL($this->config);
        
        // Création d'une table de test
        $db->execute("CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT, role TEXT)");
        
        // Insertion de données
        $rowsAffected = $db->execute(
            "INSERT INTO users (name, role) VALUES (?, ?)", 
            ["Molengo", "Developer"]
        );

        $this->assertSame(1, $rowsAffected);
    }

    /**
     * Teste le système de détection automatique des types (Auto-Typing) et la récupération des données.
     */
    public function testFetchAndAutoTyping(): void
    {
        $db = new BridgeSQL($this->config);
        $db->execute("CREATE TABLE items (id INTEGER PRIMARY KEY, qty INTEGER, active BOOLEAN)");
        $db->execute("INSERT INTO items (qty, active) VALUES (?, ?)", [10, true]);

        $result = $db->fetch("SELECT * FROM items LIMIT 1");

        $this->assertNotNull($result);
        $this->assertEquals(10, $result['qty']);
    }

    /**
     * Teste le bon fonctionnement du système de log et d'interpolation introduit en v2.0.1.
     */
    public function testDebugLoggingAndInterpolation(): void
    {
        $db = new BridgeSQL($this->config);
        $db->execute("CREATE TABLE products (id INTEGER PRIMARY KEY, title TEXT)");
        
        // Exécution d'une requête avec paramètres
        $db->query("SELECT * FROM products WHERE title = :title", ['title' => 'CyberNgambo']);

        // Vérification de la dernière requête reconstruite
        $this->assertSame("SELECT * FROM products WHERE title = 'CyberNgambo'", $db->getLastQuery());

        // Vérification de la structure du log de performance
        $logs = $db->getDebugLog();
        $this->assertCount(2, $logs); // Une entrée pour CREATE, une pour SELECT
        $this->assertArrayHasKey('duration', $logs[1]);
        $this->assertArrayHasKey('timestamp', $logs[1]);
    }

    /**
     * Teste la sécurité et l'isolation des transactions natives introduites en v2.0.2.
     */
    public function testTransactionCommitAndRollback(): void
    {
        $db = new BridgeSQL($this->config);
        $db->execute("CREATE TABLE accounts (id INTEGER PRIMARY KEY, balance REAL)");
        $db->execute("INSERT INTO accounts (balance) VALUES (500.0)");

        // 1. Test du Commit (Validation)
        $db->beginTransaction();
        $this->assertTrue($db->inTransaction());
        
        $db->execute("UPDATE accounts SET balance = balance - 100");
        $db->commit();
        
        $account = $db->fetch("SELECT balance FROM accounts LIMIT 1");
        $this->assertEquals(400.0, $account['balance']);

        // 2. Test du Rollback (Annulation en cas d'erreur)
        $db->beginTransaction();
        $db->execute("UPDATE accounts SET balance = balance - 100");
        $db->rollBack();

        // Le solde doit rester à 400.0 car la soustraction a été annulée
        $accountBeforeRollback = $db->fetch("SELECT balance FROM accounts LIMIT 1");
        $this->assertEquals(400.0, $accountBeforeRollback['balance']);
    }

    /**
     * Teste que la bibliothèque lève bien une exception en cas de conflit d'état de transaction.
     */
    public function testTransactionConflictThrowsException(): void
    {
        $db = new BridgeSQL($this->config);
        
        $db->beginTransaction();
        
        // Attendre une exception si on tente d'ouvrir une double transaction active
        $this->expectException(BridgeSQLException::class);
        $db->beginTransaction();
    }
}