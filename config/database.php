<?php

class DatabaseConnection
{
    private $pdo;
    private $dsn;
    private $username;
    private $password;

    public function __construct()
    {
        $this->setDatabaseCredentials();
        $this->connect();
    }

    private function setDatabaseCredentials()
    {
        $ip_address = $_SERVER['SERVER_ADDR'];

        $this->dsn = 'mysql:host=127.0.0.1;dbname=ads_dsw';
        $this->username = 'root';
        $this->password = '';
    }

    private function connect()
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            die("Conexão falhou: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

$database = new DatabaseConnection();
$pdo = $database->getConnection();
