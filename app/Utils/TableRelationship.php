<?php

namespace Utils;

use PDO;

class TableRelationship
{

    private $tableName;
    private $pdo;
    private $resultChain;

    public function __construct(PDO $pdo, string $tablename)
    {
        $this->pdo = $pdo;
        $this->tableName = $tablename;
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

            foreach ($this->resultChain as &$row) {
                foreach ($row as $key => &$value) {
                    if (is_numeric($value)) {
                        $value = (float)$value;
                    }
                }
            }
    
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

    public function belongsTo(string $belongsTable, string|array $belongsColumn): array
    {
        if (is_array($belongsColumn)) {
            $columnsList = implode(', ', array_map(function($column) use ($belongsTable) {
                return "{$this->tableName}.{$column} AS {$column}";
            }, $belongsColumn));

            $query =    "SELECT DISTINCT $columnsList 
                        FROM $belongsTable
                        INNER JOIN {$this->tableName} ON {$belongsTable}.id_{$this->tableName} = {$this->tableName}.id";
        } else {
            $query =    "SELECT DISTINCT {$this->tableName}.$belongsColumn AS $belongsColumn 
                        FROM $belongsTable
                        INNER JOIN {$this->tableName} ON {$belongsTable}.id_{$this->tableName} = {$this->tableName}.id";
        }
        
        $statement = $this->pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}