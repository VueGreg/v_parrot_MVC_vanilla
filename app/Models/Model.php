<?php

namespace Models;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class Model
{
    private $tableName;
    private $pdo;
    private $resultChain;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(dirname(__FILE__, 3));
        $dotenv->load();

        $className = explode('\\', strtolower(get_called_class()));
        $this->tableName = substr($className[1], 0 , -5);

        try {
            $this->pdo = new PDO("mysql:host=".$_ENV["DB_HOST"].";dbname=".$_ENV["DB_NAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Gérer l'exception de manière appropriée, par exemple, en la journalisant
            //throw new Exception("Database connection failed: " . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function all(): array
    {
        $query = "SELECT * FROM {$this->tableName}";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function distinct(string $column): array
    {
        $query = "SELECT DISTINCT {$column} FROM {$this->tableName}";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function where(string $clause): array
    {
        $query = "SELECT * FROM {$this->tableName} WHERE {$clause}";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function has(array $tables = [], bool $chain = false): array|self
    {
        $query = "SELECT * FROM {$this->tableName}";

        if (!empty($tables)) {
            foreach ($tables as $table) {
                $query .= " INNER JOIN {$table} ON {$this->tableName}.id_{$table} = {$table}.id";
            }
        }

        $statement = $this->pdo->prepare($query);
        if ($statement->execute()) {
            $this->resultChain = $statement->fetchAll(PDO::FETCH_ASSOC);

            if ($chain) {
                return $this;
            } else return $this->resultChain;
        }

        return [];

    }

    public function hasMany(string $tableMany, string $galleryTable, string $idName, bool $chain = false, int $limit = null): array|self
    {
        if (empty($this->resultChain)) {
            $this->has();
        }

        $results = $this->resultChain;

        foreach ($results as $key => $value) {
            $id = $results[$key][$idName];
            
            $query_many = "SELECT * FROM {$galleryTable}
                            INNER JOIN {$tableMany} ON {$galleryTable}.id_{$tableMany} = {$tableMany}.id
                            WHERE id_{$this->tableName} = ?";
                            
            if (!is_null($limit)) {
                $query_many .= " LIMIT {$limit}";
            }
                            
            $statement_many = $this->pdo->prepare($query_many);
            $statement_many->execute([$id]);

            $results[$key][$tableMany] = $statement_many->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($chain) {
            return $this;
        } else  {
            $this->resultChain = $results;
            return $this->resultChain;
        }
    }
}