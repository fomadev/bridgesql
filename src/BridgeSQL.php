<?php

/* * Copyright (c) 2026 Fordi / FomaDev.
 * Licensed under FomaDev Public License.
 * See LICENSE file in the project root for full license information.
 */

namespace BridgeSQL;

use BridgeSQL\Drivers\DriverFactory;
use BridgeSQL\Exceptions\BridgeSQLException;
use PDO;

class BridgeSQL
{
    private PDO $connection;
    private ?string $lastQuery = null;
    private array $logs = [];

    public function __construct(array $config)
    {
        $this->connection = DriverFactory::create($config);
    }

    /**
     * Exécute une requête SQL préparée avec gestion automatique des types,
     * logs de performance et interpolation pour le debug.
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        try {
            // Sauvegarde de la requête interpolée pour le debug
            $this->lastQuery = $this->interpolateQuery($sql, $params);
            $startTime = microtime(true);

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

            // Calcul de la durée et ajout au log
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            $this->logs[] = [
                'sql'       => $this->lastQuery,
                'duration'  => $duration . 'ms',
                'timestamp' => date('Y-m-d H:i:s')
            ];

            return $stmt;
        } catch (\PDOException $e) {
            throw new BridgeSQLException("Erreur SQL : " . $e->getMessage());
        }
    }

    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch() ?: null;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Retourne la dernière requête exécutée (avec paramètres injectés).
     */
    public function getLastQuery(): ?string
    {
        return $this->lastQuery;
    }

    /**
     * Retourne l'historique des requêtes et performances.
     */
    public function getDebugLog(): array
    {
        return $this->logs;
    }

    /**
     * Simule l'injection des paramètres dans le SQL pour faciliter le debug.
     */
    private function interpolateQuery(string $sql, array $params): string
    {
        $keys = [];
        $values = [];

        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/' . (str_starts_with($key, ':') ? '' : ':') . preg_quote($key, '/') . '/';
            } else {
                $keys[] = '/[?]/';
            }

            if (is_string($value)) {
                $values[] = "'" . addslashes($value) . "'";
            } elseif (is_null($value)) {
                $values[] = 'NULL';
            } elseif (is_bool($value)) {
                $values[] = $value ? '1' : '0';
            } else {
                $values[] = $value;
            }
        }

        // On remplace chaque occurrence une par une pour les "?"
        return preg_replace($keys, $values, $sql, 1);
    }

    // --- Méthodes de transaction sécurisées (v2.0.2) ---

    /**
     * Begins a database transaction.
     *
     * @return bool True on success, false on failure.
     * @throws BridgeSQLException If a transaction is already active.
     */
    public function beginTransaction(): bool
    {
        try {
            if ($this->connection->inTransaction()) {
                throw new BridgeSQLException("A transaction is already active.");
            }

            $this->logs[] = [
                'sql'       => '-- BEGIN TRANSACTION --',
                'duration'  => '0ms',
                'timestamp' => date('Y-m-d H:i:s')
            ];

            return $this->connection->beginTransaction();
        } catch (\PDOException $e) {
            throw new BridgeSQLException("Failed to begin transaction: " . $e->getMessage());
        }
    }

    /**
     * Commits the current transaction.
     *
     * @return bool True on success, false on failure.
     * @throws BridgeSQLException If no transaction is active.
     */
    public function commit(): bool
    {
        try {
            if (!$this->connection->inTransaction()) {
                throw new BridgeSQLException("No active transaction to commit.");
            }

            $this->logs[] = [
                'sql'       => '-- COMMIT --',
                'duration'  => '0ms',
                'timestamp' => date('Y-m-d H:i:s')
            ];

            return $this->connection->commit();
        } catch (\PDOException $e) {
            throw new BridgeSQLException("Failed to commit transaction: " . $e->getMessage());
        }
    }

    /**
     * Rolls back the current transaction.
     *
     * @return bool True on success, false on failure.
     * @throws BridgeSQLException If no transaction is active.
     */
    public function rollBack(): bool
    {
        try {
            if (!$this->connection->inTransaction()) {
                throw new BridgeSQLException("No active transaction to roll back.");
            }

            $this->logs[] = [
                'sql'       => '-- ROLLBACK --',
                'duration'  => '0ms',
                'timestamp' => date('Y-m-d H:i:s')
            ];

            return $this->connection->rollBack();
        } catch (\PDOException $e) {
            throw new BridgeSQLException("Failed to roll back transaction: " . $e->getMessage());
        }
    }

    /**
     * Checks if inside a transaction.
     *
     * @return bool
     */
    public function inTransaction(): bool
    {
        return $this->connection->inTransaction();
    }

    public function lastInsertId(?string $name = null): string|false
    {
        return $this->connection->lastInsertId($name);
    }

    public function getPdo(): PDO
    {
        return $this->connection;
    }
}
