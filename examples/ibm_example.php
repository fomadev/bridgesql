<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'ibm',
    'host'     => 'localhost',
    'port'     => 50000,
    'dbname'   => 'SAMPLE',
    'username' => 'db2inst1',
    'password' => 'db2_password'
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to IBM DB2 !";
} catch (Exception $e) {
    echo "Erreur IBM DB2 : " . $e->getMessage();
}