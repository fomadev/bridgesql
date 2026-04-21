<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'oracle',
    'host'     => 'localhost',
    'port'     => 1521,
    'dbname'   => 'XE', // Nom du service SID
    'username' => 'SYSTEM',
    'password' => 'oracle',
    'charset'  => 'AL32UTF8'
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to Oracle !";
} catch (Exception $e) {
    echo "Erreur Oracle : " . $e->getMessage();
}