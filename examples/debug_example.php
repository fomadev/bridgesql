<?php

/* * Copyright (c) 2026 Fordi / FomaDev.
 * Licensed under FomaDev Public License.
 * See LICENSE file in the project root for full license information.
 */

require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver' => 'sqlite',
    'path'   => ':memory:' // Test en mémoire vive
];

$db = new BridgeSQL($config);

// On fait quelques requêtes
$db->execute("CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT)");
$db->execute("INSERT INTO users (name) VALUES (?)", ["Malanda"]);
$db->fetch("SELECT * FROM users WHERE name = :name", ['name' => 'Malanda']);

// On affiche le debug
echo "LAST QUERY EXECUTED:<br>" . $db->getLastQuery() . "<br><br>";
echo "FULL DEBUG LOG:<br>";
print_r($db->getDebugLog());
