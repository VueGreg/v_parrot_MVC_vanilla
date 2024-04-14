<?php

namespace Utils;

use Exceptions\CreateException;
use PDO;

class QueryBuilder
{
    private $tableName;
    private $query;
    private $parameters;
    private $pdo;
    private $whereClause;
    private $oneValue = false;
    private $limit;

    public function __construct(string $tableName, PDO $pdo)
    {
        $this->tableName = $tableName;
        $this->query = '';
        $this->parameters = [];
        $this->pdo = $pdo;
    }

    public function distinct(string $column): self
    {
        $this->query .= "SELECT DISTINCT $column FROM {$this->tableName}";
        return $this;
    }

    public function where(string $column, string $operator, string|int $value): self
    {
        if (strpos($column, '.') !== false) {
            $expColumn = explode(".", $column)[1];
        } else $expColumn = $column;

        // $element = str_replace('.', '_', $column);
        $placeholder = ":$expColumn";

        $this->whereClause[] = "$column $operator $placeholder";
        $this->parameters[$expColumn] = $value;

        return $this;
    }

    public function min(string $column): self
    {
        $this->query .= "SELECT MIN(`$column`) AS min_value FROM {$this->tableName}";
        $this->oneValue = true;
        return $this;
    }

    public function max(string $column): self
    {
        $this->query .= "SELECT MAX(`$column`) AS max_value FROM {$this->tableName}";
        $this->oneValue = true;
        return $this;
    }

    public function join(string $table, string $foreign_key, string $operator, string $other_key): self
    {
        $this->query .= " INNER JOIN $table ON $foreign_key $operator $other_key";
        return $this;
    }

    public function limit(int $number_limit): self
    {
        $this->limit = " LIMIT {$number_limit}";
        return $this;
    }

    public function select(string $columns = null): self
    {
        if (!$columns) {
            $this->query .= "SELECT * FROM {$this->tableName}";
            return $this;
        }
        
        $this->query .= "SELECT $columns FROM {$this->tableName}";
        return $this;
    }

    public function count(): self
    {
        $this->query .= "SELECT COUNT(*) AS count FROM {$this->tableName}";
        $this->oneValue = true;
        return $this;
    }

    public function create(array $data): bool
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $this->query .= "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";

        foreach ($data as $column => $value) {
            $this->parameters[$column] = $value;
        }

        $statement = $this->pdo->prepare($this->getQuery());
        foreach ($this->parameters as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        if ($statement->execute()) {
            $this->query = '';
            return true;
        }

        throw new CreateException("La création a échoué en raison d'une erreur de validation.");
    }

    public function update(Array $set, int $id): bool
    {
        $this->query .= "UPDATE {$this->tableName} SET ";

        if (is_array($set)) {
            foreach ($set as $column => $value) {
                $this->parameters[$column] = $value;
                $this->query .= "{$column} = :{$column},";
            }
        }

        $this->query = rtrim($this->query, ', ');

        if (isset($id)) {
            $this->parameters['id'] = $id;
            $this->query .= " WHERE id = :id";
        }

        $statement = $this->pdo->prepare($this->getQuery());
        foreach ($this->parameters as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        if ($statement->execute()) {
            $this->query = '';
            return true;
        }

        throw new CreateException("La modification à échoué en raison d'une erreur de validation.");
    }

    public function delete(int $id): bool
    {
        $this->query = "DELETE FROM {$this->tableName} WHERE id = :id";

        $statement = $this->pdo->prepare($this->getQuery());
        $statement->bindValue(":id", $id);

        if ($statement->execute()) {
            $this->query = '';
            return true;
        }

        throw new CreateException("La suppression à échoué en raison d'une erreur de validation.");
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function queryManual(string $query): self
    {
        $this->query = $query;
        return $this;
    }

    public function get(): mixed
    {
        if (!empty($this->whereClause) && is_array($this->whereClause)) {
            $whereConditions = implode(" AND ", $this->whereClause);
            $this->query .= " WHERE $whereConditions";
        }

        if ($this->limit) {
            $this->query .= $this->limit;
        }
        
        $statement = $this->pdo->prepare($this->getQuery());
        foreach ($this->parameters as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        if ($statement->execute()) {
            $this->query = '';
            $this->whereClause = null;
            $this->limit = '';
            $this->parameters = [];
        }

        if ($this->oneValue) {
            $this->oneValue = false;
            return $statement->fetch(PDO::FETCH_COLUMN);
        }else return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}