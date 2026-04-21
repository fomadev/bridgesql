<?php
namespace BridgeSQL\Drivers;

use PDO;
use BridgeSQL\Exceptions\BridgeSQLException;

class DriverFactory {
    /**
     * Crée une instance PDO basée sur la configuration fournie.
     * Supporte la personnalisation des options PDO.
     */
    public static function create(array $config): PDO {
        $driver   = strtolower($config['driver'] ?? 'mysql');
        $host     = $config['host'] ?? 'localhost';
        $dbname   = $config['dbname'] ?? '';
        $port     = $config['port'] ?? null;
        $charset  = $config['charset'] ?? 'utf8mb4';
        $username = $config['username'] ?? 'root';
        $password = $config['password'] ?? '';

        // Construction du DSN selon le driver
        switch ($driver) {
            case 'mysql':
            case 'mariadb':
                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
                break;
            case 'postgresql':
            case 'pgsql':
                $dsn = "pgsql:host=$host;port=" . ($port ?? 5432) . ";dbname=$dbname";
                break;
            case 'sqlite':
                $dsn = "sqlite:" . ($config['path'] ?? $dbname);
                break;
            case 'sqlserver':
            case 'mssql':
                $dsn = "sqlsrv:Server=$host," . ($port ?? 1433) . ";Database=$dbname";
                break;
            case 'oracle':
            case 'oci':
                $dsn = "oci:dbname=//$host:" . ($port ?? 1521) . "/$dbname;charset=$charset";
                break;
            case 'ibm':
            case 'db2':
                $dsn = "ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=$dbname;HOSTNAME=$host;PORT=" . ($port ?? 50000) . ";PROTOCOL=TCPIP;";
                break;
            case 'firebird':
                $dsn = "firebird:dbname=$host/" . ($port ?? 3050) . ":$dbname";
                break;
            case 'informix':
                $dsn = "informix:host=$host;service=" . ($port ?? 1526) . ";database=$dbname;server=ol_informix1210;";
                break;
            case 'sybase':
                $dsn = "dblib:host=$host;dbname=$dbname";
                break;
            default:
                throw new BridgeSQLException("Driver inconnu ou non supporté : $driver");
        }

        // Préparation des options PDO
        // On définit les options par défaut, puis on les fusionne avec celles fournies par l'utilisateur
        $defaultOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false, // Recommandé pour la sécurité et le typage réel
        ];

        $userOptions = $config['options'] ?? [];
        $options = array_replace($defaultOptions, $userOptions);

        try {
            return new PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            throw new BridgeSQLException("Erreur de connexion ($driver): " . $e->getMessage());
        }
    }
}