<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'informix',
    'host'     => 'localhost',
    'port'     => 1526,
    'dbname'   => 'test_db',
    'username' => 'informix',
    'password' => 'informix_pwd'
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to Informix !";
} catch (Exception $e) {
    echo "Erreur Informix : " . $e->getMessage();
}