<?php
class LoginModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarUsuarioPorNome($username)
    {
        $stmt = $this->pdo->prepare("SELECT nome, senha, filial, nivel_acesso FROM usuarios WHERE nome = :nome");
        $stmt->execute(['nome' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
