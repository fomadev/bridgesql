<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'mariadb', // Le factory utilisera le driver mysql:
    'host'     => 'localhost',
    'dbname'   => 'maria_db',
    'username' => 'root',
    'password' => ''
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to MariaDB !";
} catch (Exception $e) {
    echo "Erreur MariaDB : " . $e->getMessage();
}