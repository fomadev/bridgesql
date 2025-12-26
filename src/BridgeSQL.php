<?php
namespace BridgeSQL;

use PDO;
use PDOException;
use BridgeSQL\Exceptions\BridgeSQLException;

/**
 * BridgeSQL
 * 
 * Bibliothèque légère pour simplifier l'utilisation de PDO avec MySQL.
 * Version 1.0.0 - MySQL uniquement
 */
class BridgeSQL
{
    private PDO $connection;

    /**
     * Constructeur
     * 
     * @param array $config [
     *   'driver'   => 'mysql',
     *   'host'     => 'localhost',
     *   'dbname'   => 'database_name',
     *   'username' => 'root',
     *   'password' => '',
     *   'charset'  => 'utf8mb4'
     * ]
     * 
     * @throws BridgeSQLException
     */
    public function __construct(array $config)
    {
        $driver   = $config['driver'] ?? 'mysql';
        $host     = $config['host'] ?? 'localhost';
        $dbname   = $config['dbname'] ?? '';
        $username = $config['username'] ?? 'root';
        $password = $config['password'] ?? '';
        $charset  = $config['charset'] ?? 'utf8mb4';

        if ($driver !== 'mysql') {
            // Version 1.0 : seul MySQL est supporté
            throw new BridgeSQLException("Driver non supporté dans cette version : {$driver}. Utilisez 'mysql'.");
        }

        try {
            $dsn = "$driver:host=$host;dbname=$dbname;charset=$charset";
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new BridgeSQLException("Erreur de connexion : " . $e->getMessage(), (int) $e->getCode());
        }
    }

    /**
     * Retourne l'instance PDO brute (si besoin avancé)
     */
    public function getPdo(): PDO
    {
        return $this->connection;
    }

    /**
     * Exécute une requête préparée et retourne le PDOStatement
     * 
     * @param string $sql La requête SQL à exécuter
     * @param array $params Les paramètres à lier (peuvent être nommés ou positionnels)
     * @return \PDOStatement
     * @throws BridgeSQLException
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        try {
            $stmt = $this->connection->prepare($sql);
            
            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    // Gestion des paramètres nommés et positionnels
                    $paramKey = is_int($key) ? $key + 1 : (str_starts_with($key, ':') ? $key : ':' . $key);
                    
                    // Détermination du type PDO approprié
                    $type = PDO::PARAM_STR;
                    if (is_int($value)) {
                        $type = PDO::PARAM_INT;
                    } elseif (is_bool($value)) {
                        $type = PDO::PARAM_BOOL;
                    } elseif (is_null($value)) {
                        $type = PDO::PARAM_NULL;
                    }
                    
                    $stmt->bindValue($paramKey, $value, $type);
                }
            }
            
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new BridgeSQLException("Erreur SQL : " . $e->getMessage(), (int) $e->getCode());
        }
    }

    /**
     * Récupère une seule ligne
     * 
     * @param string $sql La requête SQL
     * @param array $params Les paramètres à lier
     * @return array|null Retourne un tableau associatif ou null si aucune ligne trouvée
     */
    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /**
     * Récupère toutes les lignes
     * 
     * @param string $sql La requête SQL
     * @param array $params Les paramètres à lier
     * @return array Retourne un tableau de tableaux associatifs
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Exécute une requête d'écriture (INSERT, UPDATE, DELETE)
     * et retourne le nombre de lignes affectées.
     * 
     * @param string $sql La requête SQL
     * @param array $params Les paramètres à lier
     * @return int Le nombre de lignes affectées
     */
    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Démarre une transaction
     * 
     * @return bool True si la transaction a démarré avec succès
     */
    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Valide une transaction
     * 
     * @return bool True si la transaction a été validée avec succès
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * Annule une transaction
     * 
     * @return bool True si la transaction a été annulée avec succès
     */
    public function rollBack(): bool
    {
        return $this->connection->rollBack();
    }

    /**
     * Retourne le dernier ID inséré
     * 
     * @param string|null $name Nom de la séquence (optionnel, pour PostgreSQL)
     * @return string Le dernier ID inséré
     */
    public function lastInsertId(?string $name = null): string
    {
        return $this->connection->lastInsertId($name);
    }
}
