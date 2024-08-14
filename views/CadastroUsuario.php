<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /trabalho-dsw-ads6/views/Login.php");
    exit();
}

header("Content-Type: text/html; charset=utf-8");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EGP | Cadastro Usuário</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="/public/images/trabalho-dsw-ads6-engenharias-grupo-multi.png" type="image/x-icon">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/visualizarChamados.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/header.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="login-container">
                    <h2 class="text-center">Sistema Anúbis - Cadastro</h2>
                    <form method="post" action="/trabalho-dsw-ads6/controllers/CadastroUsuarioController.php">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="departamento">Escolha uma opção para departamento:</label>
                            <select class="form-control" id="departamento" name="departamento" required>
                                <option value="Engenharia">Engenharia</option>
                                <option value="Qualidade">Qualidade</option>
                                <option value="Aplicacoes">Aplicações</option>
                                <option value="Producao">Produção</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nivel">Escolha uma opção para nível:</label>
                            <select class="form-control" id="nivel" name="nivel" required>
                                <option value="Administrador">Administrador</option>
                                <option value="Operacional">Operacional</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"
                            style="font-size: 20px; padding: 15px 30px; background-color: #041D29;">Cadastrar usuário</button>
                    </form>
                    <hr>
                </div>
                <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>
            </div>
        </div>
    </div>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function limparCampos() {
            $("#cadastroForm")[0].reset();
        }
    </script>
</body>

</html>