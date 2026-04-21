<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'sybase',
    'host'     => '127.0.0.1',
    'dbname'   => 'financial_db',
    'username' => 'sa',
    'password' => ''
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to Sybase via dblib !";
} catch (Exception $e) {
    echo "Erreur Sybase : " . $e->getMessage();
}