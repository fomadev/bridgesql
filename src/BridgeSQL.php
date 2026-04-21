<?php
namespace BridgeSQL;

use BridgeSQL\Drivers\DriverFactory;
use BridgeSQL\Exceptions\BridgeSQLException;
use PDO;

class BridgeSQL {
    private PDO $connection;

    public function __construct(array $config) {
        $this->connection = DriverFactory::create($config);
    }

    /**
     * Exécute une requête SQL préparée avec gestion automatique des types.
     */
    public function query(string $sql, array $params = []): \PDOStatement {
        try {
            $stmt = $this->connection->prepare($sql);
            
            foreach ($params as $key => $value) {
                // Gestion des clés (indexées ou nommées)
                $paramKey = is_int($key) ? $key + 1 : (str_starts_with($key, ':') ? $key : ':' . $key);
                
                // Détection automatique du type PDO
                $type = match (true) {
                    is_int($value)  => PDO::PARAM_INT,
                    is_bool($value) => PDO::PARAM_BOOL,
                    is_null($value) => PDO::PARAM_NULL,
                    default         => PDO::PARAM_STR,
                };

                $stmt->bindValue($paramKey, $value, $type);
            }
            
            $stmt->execute();
            return $stmt;
        } catch (\PDOException $e) {
            throw new BridgeSQLException("Erreur SQL : " . $e->getMessage());
        }
    }

    public function fetch(string $sql, array $params = []): ?array {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch() ?: null;
    }

    public function fetchAll(string $sql, array $params = []): array {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function execute(string $sql, array $params = []): int {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    // --- Méthodes de transaction et utilitaires ---

    public function beginTransaction(): bool { 
        return $this->connection->beginTransaction(); 
    }

    public function commit(): bool { 
        return $this->connection->commit(); 
    }

    public function rollBack(): bool { 
        return $this->connection->rollBack(); 
    }

    public function lastInsertId(?string $name = null): string|false { 
        return $this->connection->lastInsertId($name); 
    }

    public function getPdo(): PDO { 
        return $this->connection; 
    }
}