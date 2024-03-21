<?php

namespace Models;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class Model
{
    public function all() : array
    {
        $dotenv = Dotenv::createImmutable("../");
        $dotenv->load();

        try {
            $pdo = new PDO("mysql:host=".$_ENV["DB_HOST"].";dbname=".$_ENV["DB_NAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);

            $query = ("SELECT * FROM reparations");

            $statement = $pdo->prepare($query);
            $statement->execute();
            
            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return array('status' => 404, 'errors' =>$e->getMessage());
        }
    }
}