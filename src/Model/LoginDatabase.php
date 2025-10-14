<?php

namespace App\Model;

abstract class LoginDatabase
{

    protected string $dbName;
    protected string $user;
    protected string $pass;
    protected ?\PDO $pdo = null;

    public function __construct(string $dbName = "footclub", string $user = "root", string $pass = "")
    {
        $this->dbName = $dbName;
        $this->user = $user;
        $this->pass = $pass;
        $this->connexionDatabase();
    }



    public function connexionDatabase(): void
    {
        try {
            $this->pdo = new \PDO("mysql:host=127.0.0.1;dbname={$this->dbName};charset=utf8", $this->user, $this->pass);
        } catch (\Exception $exception) {
            echo 'Erreur lors de la connexion à la base de données.<br>';
            echo $exception->getMessage();
            exit;
        }
    }


    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
