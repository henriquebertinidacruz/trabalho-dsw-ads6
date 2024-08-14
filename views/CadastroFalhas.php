<?php
header("Content-Type: text/html; charset=utf-8");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");
$database = new DatabaseConnection();
$pdo = $database->getConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>EGP | Cadastro Falhas</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="/trabalho-dsw-ads6/public/images/trabalho-dsw-ads6-engenharias-grupo-multi.ico" type="image/x-icon">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/visualizarChamados.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/header.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="login-container">
                    <h2 class="text-center">Anúbis - Engenharias | Cadastro de falhas</h2>
                    <form method="post" action="/trabalho-dsw-ads6/models/CadastroFalhaModel.php" accept-charset="UTF-8">
                        <div class="form-group">
                            <label for="local_id">local:</label>
                            <select class="form-control" id="local_id" name="local_id" required>
                                <?php
                                $sql = "SELECT id, local FROM ANUBIS_cadastro_local";
                                foreach ($pdo->query($sql) as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['local'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="falha">Falha:</label>
                            <input type="text" class="form-control" id="falha" name="falha" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"
                            style="background-color: #08253F; color: White;"
                            style="font-size: 20px; padding: 15px 30px;">Cadastrar Falha</button>
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