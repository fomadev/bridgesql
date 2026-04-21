<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'test_db',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8mb4'
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to MySQL !\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}