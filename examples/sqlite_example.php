<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver' => 'sqlite',
    'path'   => __DIR__ . '/database.sqlite' // Chemin vers le fichier
];

try {
    $db = new BridgeSQL($config);
    $db->execute("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, name TEXT)");
    $db->execute("INSERT INTO users (name) VALUES (?)", ["Molengo"]);
    
    $user = $db->fetch("SELECT * FROM users LIMIT 1");
    print_r($user);
} catch (Exception $e) {
    echo "Erreur SQLite : " . $e->getMessage();
}