<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /egp/views/Login.php");
    exit();
}

header("Content-Type: text/html; charset=utf-8");
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/config/authenticator.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EGP | Lobby</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="icon" href="/egp/public/images/egp-engenharias-grupo-multi.png" type="image/x-icon">
    <link rel="stylesheet" href="/egp/public/styles/paginaIntermediaria.css">
    <link rel="stylesheet" href="/egp/public/styles/styles.css">
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
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/egp/includes/header.php"; ?>

<div class="text-center">
    <button class="btn btn-primary btn-custom my-4" type="button" data-toggle="collapse"
            data-target="#chamadosCollapse" aria-expanded="false" aria-controls="chamadosCollapse">
        Chamados
    </button>
</div>
<div class="collapse" id="chamadosCollapse">
    <div class="card card-body">
        <div class="container mt-5">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="automacao" role="tabpanel"
                     aria-labelledby="automacao-tab">
                    <div class="row justify-content-center">
                        <?php if (isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] == 'Operacional'): ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="AbrirChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Abrir Chamado
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="AberturaSetup.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Iniciar Setup
                                    <i class="bi bi-gear-fill"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="VisualizarSetup.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Visualizar de Setup
                                    <i class="bi bi-eye-fill"></i>
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
                        <?php if (isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] == 'Administrador'): ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="AbrirChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Abrir Chamado
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="AberturaSetup.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Iniciar Setup
                                    <i class="bi bi-gear-fill"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="VisualizarSetup.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Visualizar de Setup
                                    <i class="bi bi-eye-fill"></i>
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
                                <a href="EncerrarSetup.php"
                                   class="btn btn-primary btn-lg btn-block btn-icon d-flex justify-content-between align-items-center">
                                    Concluir Setup
                                    <i class="fas fa-check-circle"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="PerfilUsuario.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Perfil de Usuário
                                    <i class="bi bi-person-fill"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="VisualizarChamadosGlobal.php"
                                   class="btn btn-primary btn-lg btn-block btn-icon">
                                    Visualizar Chamados Global
                                    <i class="bi bi-globe"></i>
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
                                <a href="CadastroPosto.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Cadastro Posto
                                    <i class="bi bi-signpost-split-fill"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="ExportarChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Exportar Chamados
                                    <i class="bi bi-download"></i>
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
    <button class="btn btn-primary btn-custom my-4" type="button" data-toggle="collapse" data-target="#zteCollapse"
            aria-expanded="false" aria-controls="zteCollapse">
        ZTE
    </button>
</div>
<div class="collapse" id="zteCollapse">
    <div class="card card-body">
        <div class="container mt-5">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="automacao" role="tabpanel"
                     aria-labelledby="automacao-tab">
                    <div class="row justify-content-center">
                        <?php if (isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] == 'Operacional'): ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="AbrirChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Status linhas
                                    <i class="bi bi-graph-up"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="VisualizarChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Visualizar peças em postos
                                    <i class="bi bi-visualize"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="ControleProducao.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Controle de Produção
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] == 'Administrador'): ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="VisualizarChamados.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Status Linhas
                                    <i class="bi bi-graph-up"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="ControleProducao.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Controle de Produção
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="VisualizarPeçasEmLinha.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Visualizar peças em postos
                                    <i class="bi bi-visualize"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="rastreioDsnZte.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Rastreio DSN
                                    <i class="bi bi-search"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="CadastroEtiquetaQrcode.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Cadastro Etiqueta QR Code
                                    <i class="bi bi-qr-code"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="CadastroEtiquetaProduto.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Cadastro Etiqueta Produto ZTE
                                    <i class="bi bi-tag"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="CadastroLabelValidation.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Cadastro Label Validation
                                    <i class="bi bi-check-circle"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="VisualizarCadastroEtiquetasQrcode.php"
                                   class="btn btn-primary btn-lg btn-block btn-icon">
                                    Visualizar Cadastros Etiquetas QR Code
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="VisualizarCadastroLabelValidation.php"
                                   class="btn btn-primary btn-lg btn-block btn-icon">
                                    Visualizar Cadastros Label Validation
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="CadastroUsuario.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Cadastro de Usuário
                                    <i class="bi bi-person-plus"></i>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <a href="TempoProcessamentoZTE.php" class="btn btn-primary btn-lg btn-block btn-icon">
                                    Processamento das Estações
                                    <i class="bi bi-clock"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <button class="btn btn-primary btn-custom my-4" type="button" data-toggle="collapse"
            data-target="#wattsCollapse" aria-expanded="false" aria-controls="wattsCollapse">
        Watts
    </button>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/egp/includes/footer.php"; ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>