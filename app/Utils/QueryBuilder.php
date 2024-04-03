<?php

namespace Utils;

use PDO;

class QueryBuilder
{
    private $tableName;
    private $query;
    private $parameters;
    private $pdo;

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

    public function where(string $column, string $operator, $value): self
    {
        $element = explode(".", $column)[1];

        $this->parameters[$element] = $value;
        if (!empty($this->query)) {
            $this->query .= " WHERE $column $operator :$element";
        } else {
            $this->query .= "SELECT * FROM {$this->tableName} WHERE $column $operator :$element";
        }
        return $this;
    }

    public function min(string $column): self
    {
        $this->query .= "SELECT MIN(`$column`) AS min_value FROM {$this->tableName}";
        return $this;
    }

    public function max(string $column): self
    {
        $this->query .= "SELECT MAX(`$column`) AS max_value FROM {$this->tableName}";
        return $this;
    }

    public function join(string $table, string $foreign_key, string $operator, string $other_key): self
    {
        $this->query .= " INNER JOIN $table ON $foreign_key $operator $other_key";
        return $this;
    }

    public function select(string $columns): self
    {
        $this->query .= "SELECT $columns ";
        return $this;
    }

    public function count(): self
    {
        $this->query .= "SELECT COUNT(*) AS count FROM {$this->tableName}";
        return $this;
    }

    public function create(array $data): self
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $this->query .= "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";

        foreach ($data as $column => $value) {
            $this->parameters[$column] = $value;
        }

        return $this;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function get(): array
    {
        $statement = $this->pdo->prepare($this->getQuery());
        foreach ($this->parameters as $column => $value) {
            $statement->bindValue(":$column", $value);
        }
        // var_dump($statement);
        // die;
        if ($statement->execute()) {
            $this->query = '';
        }
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}