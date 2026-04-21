<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'pgsql',
    'host'     => 'localhost',
    'port'     => 5432,
    'dbname'   => 'postgres',
    'username' => 'postgres',
    'password' => ''
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to PostgreSQL !\n";
    
} catch (Exception $e) {
    echo "Erreur PostgreSQL : " . $e->getMessage();
}