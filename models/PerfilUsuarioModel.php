<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/trabalho-dsw-ads6/config/database.php');

class PerfilUsuarioModel
{
    private $pdo;

    public function __construct()
    {
        $database = new DatabaseConnection();
        $this->pdo = $database->getConnection();
    }

    public function returnUsersDatas($username)
    {
        $query = 'SELECT * FROM usuarios WHERE nome = :nome';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nome', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
