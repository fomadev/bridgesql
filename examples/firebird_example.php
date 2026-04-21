<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'firebird',
    'host'     => 'localhost',
    'dbname'   => 'C:/databases/test.fdb', // Chemin vers la base
    'username' => 'SYSDBA',
    'password' => 'masterkey'
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to Firebird !";
} catch (Exception $e) {
    echo "Erreur Firebird : " . $e->getMessage();
}