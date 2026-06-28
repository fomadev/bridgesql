<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver' => 'sqlite',
    'path'   => ':memory:'
];

try {
    $db = new BridgeSQL($config);
    
    // Configuration de la structure de test
    $db->execute("CREATE TABLE accounts (id INTEGER PRIMARY KEY, name TEXT, balance REAL)");
    $db->execute("INSERT INTO accounts (name, balance) VALUES ('Alice', 500.0), ('Bob', 150.0)");

    // Début du virement sécurisé
    $db->beginTransaction();

    // Étape 1 : Débiter Alice
    $db->execute("UPDATE accounts SET balance = balance - 200 WHERE name = ?", ['Alice']);
    
    // Étape 2 : Créditer Bob
    $db->execute("UPDATE accounts SET balance = balance + 200 WHERE name = ?", ['Bob']);

    // Tout s'est bien passé, on valide définitivement
    $db->commit();
    echo "Transaction committed successfully!\n";

} catch (Exception $e) {
    // Une erreur est survenue (ex: problème réseau, crash SQL), on annule TOUT
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
        echo "Transaction rolled back due to error: " . $e->getMessage() . "\n";
    }
}

// Vérification des logs de debug (Intégration v2.0.1)
print_r($db->getDebugLog());