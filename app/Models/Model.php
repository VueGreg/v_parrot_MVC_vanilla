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
    private $minColumn; 
    private $maxColumn;
    private $whereClause;

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

        if (!empty($this->whereClause)) {
            $query .= " WHERE {$this->whereClause}";
        }

        if($statement->execute()) {
            $this->resultChain = $statement->fetchAll(PDO::FETCH_ASSOC);
        } else return [];

    }

    public function get(): array
    {
        if (!empty($this->minColumn)) {
            $query = "SELECT MIN({$this->minColumn}) AS min_value FROM {$this->tableName}";
        } elseif (!empty($this->maxColumn)) {
            $query = "SELECT MAX({$this->maxColumn}) AS max_value FROM {$this->tableName}";
        } else {
            $query = "SELECT * FROM {$this->tableName}";
        }
    
        if (!empty($this->whereClause)) {
            $query .= " WHERE {$this->whereClause}";
        }

        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function distinct(string $column): array
    {
        $query = "SELECT DISTINCT {$column} FROM {$this->tableName}";

        if (!empty($this->whereClause)) {
            $query .= " WHERE {$this->whereClause}";
        }

        $statement = $this->pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function where(string $clause): self
    {
        $this->whereClause = $clause;
        return $this;
    }

    public function has(array $tables = [], bool $chain = false): array|self
    {
        $select = '';
    
        if (!empty($tables)) {
            $query = '';
    
            foreach ($tables as $table) {
                $queryColumns = "SHOW COLUMNS FROM $table";
                $statementColumns = $this->pdo->prepare($queryColumns);
                $statementColumns->execute();

                $columns = array_filter($statementColumns->fetchAll(PDO::FETCH_COLUMN), function($column) {
                    return $column !== 'id';
                });
    
                foreach ($columns as $column) {
                    $select .= "{$table}.{$column} AS {$table}_{$column}, ";
                }
    
                $query .= " INNER JOIN $table ON {$this->tableName}.id_$table = $table.id";
            }
        } else {
            $query = "SELECT * FROM {$this->tableName}";
        }

        $queryOrigin = "SHOW COLUMNS FROM {$this->tableName}";
        $statementOrigin = $this->pdo->prepare($queryOrigin);
        $statementOrigin->execute();
        
        $origins = $statementOrigin->fetchAll(PDO::FETCH_COLUMN);

        foreach ($origins as $origin) {
            $select .= "{$this->tableName}." . $origin . ", ";
        }

        $select = rtrim($select, ", ");
        $query = "SELECT $select FROM {$this->tableName} $query";
    
        $statement = $this->pdo->prepare($query);
        if ($statement->execute()) {
            $this->resultChain = $statement->fetchAll(PDO::FETCH_ASSOC);
    
            if ($chain) {
                return $this;
            } else {
                return $this->resultChain;
            }
        }
    
        return [];
    }

    public function hasMany(string $tableMany, string $galleryTable, bool $chain = false, int $limit = null): array|self
    {
        if (empty($this->resultChain)) {
            $this->has();
        }

        $results = $this->resultChain;

        foreach ($results as $key => $value) {
            $id = $results[$key]['id'];
            
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

    public function min(string $column): self
    {
        $this->minColumn = $column;
        $this->maxColumn = null;
        return $this;
    }

    public function max(string $column): self
    {
        $this->maxColumn = $column;
        $this->minColumn = null;
        return $this;
    }

    public function belongsTo(string $belongsTable, string $belongsColumn): array
    {
        $query =    "SELECT DISTINCT {$this->tableName}.$belongsColumn AS $belongsColumn 
                    FROM $belongsTable
                    INNER JOIN {$this->tableName} ON $belongsTable .id_{$this->tableName} = {$this->tableName}.id";
        
        $statement = $this->pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE id = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }
}