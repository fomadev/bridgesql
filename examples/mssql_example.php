<?php
require_once '../src/BridgeSQL.php';
require_once '../src/Drivers/DriverFactory.php';
require_once '../src/Exceptions/BridgeSQLException.php';

use BridgeSQL\BridgeSQL;

$config = [
    'driver'   => 'mssql',
    'host'     => '127.0.0.1',
    'port'     => 1433,
    'dbname'   => 'MaBaseSQLServer',
    'username' => 'sa',
    'password' => 'VotreMotDePasseFort'
];

try {
    $db = new BridgeSQL($config);
    echo "Successfully connected to SQL Server !";
} catch (Exception $e) {
    echo "Erreur MSSQL : " . $e->getMessage();
}