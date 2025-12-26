<?php
/**
 * 
 * Ce script teste la connexion à la base de données avec BridgeSQL.
 * Modifiez les paramètres de connexion selon votre environnement.
 * 
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BridgeSQL\BridgeSQL;
use BridgeSQL\Exceptions\BridgeSQLException;

// Configuration de test
$config = [
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'dbname'   => 'test_db',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8mb4',
];

echo "=== Test de connexion BridgeSQL ===\n\n";

try {
    echo "Tentative de connexion...\n";
    $db = new BridgeSQL($config);
    
    echo "✓ Connexion réussie !\n\n";
    
    // Test simple : récupérer la version MySQL
    $version = $db->fetch("SELECT VERSION() as version");
    if ($version) {
        echo "✓ Version MySQL : " . $version['version'] . "\n";
    }
    
    // Test de l'instance PDO
    $pdo = $db->getPdo();
    echo "✓ Instance PDO récupérée avec succès\n";
    
    echo "\n=== Tous les tests sont passés ===\n";
    
} catch (BridgeSQLException $e) {
    echo "✗ Erreur BridgeSQL : " . $e->getMessage() . "\n";
    echo "   Code : " . $e->getCode() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "✗ Erreur inattendue : " . $e->getMessage() . "\n";
    exit(1);
}
