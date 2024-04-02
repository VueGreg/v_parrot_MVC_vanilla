<?php

namespace Models;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class Model
{
    private static $tableName;
    private static $pdo;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(dirname(__FILE__, 3));
        $dotenv->load();

        $className = explode('\\', strtolower(get_called_class()));
        self::$tableName = substr($className[1], 0 , -5);

        try {
            self::$pdo = new PDO("mysql:host=".$_ENV["DB_HOST"].";dbname=".$_ENV["DB_NAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function all(): array
    {
        $query = ("SELECT * FROM " . self::$tableName);
        $statement = self::$pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function distinct(string $column): array
    {
        $query = ("SELECT DISTINCT " . $column . " FROM " . self::$tableName);
        $statement = self::$pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function where(string $clause): array
    {
        $query = ("SELECT * FROM " . self::$tableName . " WHERE " . $clause);
        $statement = self::$pdo->prepare($query);
        $statement->execute();
            
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function has(array $tables): array
    {
        $query = "SELECT * FROM " . self::$tableName;

        if (is_array($tables)) {
            foreach ($tables as $table) {
                $query .= " INNER JOIN " . $table . " ON " . self::$tableName . "." . "id_" . $table . " = " . $table . ".id";
            }
        }

        $statement = self::$pdo->prepare($query);
        $statement->execute();
                
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}