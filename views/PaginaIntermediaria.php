<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /trabalho-dsw-ads6/views/Login.php");
    exit();
}

header("Content-Type: text/html; charset=utf-8");
require_once($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ADS | Lobby</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="icon" href="/trabalho-dsw-ads6/public/images/trabalho-dsw-ads6-engenharias-grupo-multi.png" type="image/x-icon">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/paginaIntermediaria.css">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/styles.css">
</head>
<style>
    .btn-custom {
        width: 320px;
        height: 90px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
        padding: 15px;
        font-size: 28px;
    }

    .text-center {
        text-align: center;
    }
</style>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/header.php"; ?>

    <div class="text-center">
        <button class="btn btn-primary btn-custom my-4" type="button" data-toggle="collapse" data-target="#chamadosCollapse" aria-expanded="false" aria-controls="chamadosCollapse">
            Chamados
        </button>
    </div>
    <div class="collapse" id="chamadosCollapse">
        <div class="card card-body">
            <div class="container mt-5">
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="automacao" role="tabpanel" aria-labelledby="automacao-tab">
                        <div class="row justify-content-center">
                            <?php if (isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] == 'Operacional') : ?>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="AbrirChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Abrir Chamado
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="VisualizarChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Visualizar Chamados
                                        <i class="bi bi-list-ul"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="PerfilUsuario.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Perfil de Usuário
                                        <i class="bi bi-person-fill"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] == 'Administrador') : ?>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="AbrirChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Abrir Chamado
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="VisualizarChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Visualizar Chamados
                                        <i class="bi bi-list-ul"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="EncerrarChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Encerrar Chamado
                                        <i class="bi bi-check-circle-fill"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="PerfilUsuario.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Perfil de Usuário
                                        <i class="bi bi-person-fill"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="CadastroFalhas.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Cadastro Falhas
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="CadastroSolucoes.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Cadastro Soluções
                                        <i class="bi bi-lightbulb-fill"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="Cadastrolocal.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Cadastro local
                                        <i class="bi bi-signpost-split-fill"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        <button class="btn btn-primary btn-custom my-4" type="button" data-toggle="collapse" data-target="#solicitacoesCollapse" aria-expanded="false" aria-controls="solicitacoesCollapse">
            Solicitações
        </button>
        <div class="collapse" id="solicitacoesCollapse">
            <div class="card card-body">
                <div class="container mt-5">
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="automacao" role="tabpanel" aria-labelledby="automacao-tab">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="AbrirChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Solicitação de Desenvolvimento
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="AberturaSetup.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Solicitação de Compra
                                        <i class="bi bi-gear-fill"></i>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <a href="VisualizarChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                        Solicitação de Frete
                                        <i class="bi bi-list-ul"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/footer.php"; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>