<?php

namespace Utils;

use PDO;
use stdClass;
use PDOException;
use Dotenv\Dotenv;
use LDAP\Result;
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
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
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

    public function all(): Array
    {
        $query = "SELECT * FROM {$this->tableName}";
        $statement = $this->pdo->prepare($query);
        $className = 'Models\\' .$this->tableName . 'Model';
        $statement->setFetchMode(PDO::FETCH_CLASS, $className);

        if ($statement->execute()) {
           $results = $statement->fetchAll();

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

    public function find(int $id): Model
    {
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $className = 'Models\\' .$this->tableName . 'Model';
        $statement->setFetchMode(PDO::FETCH_CLASS, $className);
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        if($statement->execute()){
            $result = $statement->fetch();
        } else return null;
    
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function findByToken(string $token): Model
    {
        $query = "SELECT * FROM {$this->tableName} WHERE token = :token";
        $statement = $this->pdo->prepare($query);
        $className = 'Models\\' .$this->tableName . 'Model';
        $statement->setFetchMode(PDO::FETCH_CLASS, $className);
        $statement->bindValue(':token', $token, PDO::PARAM_STR);
        if($statement->execute()){
            $result = $statement->fetch();
        } else return null;
    
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }
}