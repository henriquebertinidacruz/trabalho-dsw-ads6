<?php
require_once 'models/LoginModel.php';
require_once 'config/database.php';

class LoginController
{
    private $model;

    public function __construct()
    {
        global $pdo;
        $this->model = new LoginModel($pdo);
    }

    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $usuario = $this->model->buscarUsuarioPorNome($username);

            if ($usuario && $password === $usuario['senha']) {
                session_start();
                $_SESSION['username'] = $usuario['nome'];
                $_SESSION['filial'] = $usuario['filial'];
                $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];

                header("Location: /trabalho-dsw-ads6/views/PaginaIntermediaria.php"); 
                exit;
            } else {
                echo "<script>alert('Senha incorreta. Tente novamente.');</script>";
                header("Location: /trabalho-dsw-ads6/index.php");
                exit;
            }
        } else {
            require_once $_SERVER["DOCUMENT_ROOT"] . '/trabalho-dsw-ads6/views/Login.php';
        }
    }
}
?>
