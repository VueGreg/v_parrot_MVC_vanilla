<?php

namespace Utils;

use PDO;
use PDOException;
use Dotenv\Dotenv;
use Utils\QueryBuilder;
use Utils\TableRelationship;

class Model
{
    private $tableName;
    private $pdo;
    private $queryBuilder;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(dirname(__FILE__, 3));
        $dotenv->load();

        $className = explode('\\', strtolower(get_called_class()));
        $this->tableName = substr($className[1], 0 , -5);

        try {

            $this->pdo = new PDO("mysql:host=".$_ENV["DB_HOST"].";dbname=".$_ENV["DB_NAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
            $this->queryBuilder = new QueryBuilder($this->tableName, $this->pdo);

        } catch (PDOException $e) {
            //throw new Exception("Database connection failed: " . $e->getMessage());
            return $e->getMessage();
        }

    }

    public function relationships(): TableRelationship
    {
        return new TableRelationship($this->pdo, $this->tableName);
    }

    public function query(): QueryBuilder
    {
        return $this->queryBuilder;
    }

    public function all(): array
    {
        $query = "SELECT * FROM {$this->tableName}";
        $statement = $this->pdo->prepare($query);

        if ($statement->execute()) {
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as &$row) {
                foreach ($row as $key => &$value) {
                    if (is_numeric($value)) {
                        $value = (float)$value;
                    }
                }
            }

            return $results;
        } else {
            return [];
        }
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