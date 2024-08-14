<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");

if (!isset($_SESSION['username'])) {
    header("Location: /trabalho-dsw-ads6/views/Login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EGP | Visualização de Chamados</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="icon" href="/trabalho-dsw-ads6/public/images/trabalho-dsw-ads6-engenharias-grupo-multi.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/header.php"; ?>
    <div class="container-fluid" id="aleatorio">
        <h1 class="mb-4">Chamados - Engenharias</h1>
        <div class="table-responsive">
            <table id="tableChamados" class="table table-sm display table-striped table-bordered text-center"
                cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Solicitante</th>
                        <th>Linha</th>
                        <th>local</th>
                        <th>item</th>
                        <th>Problema</th>
                        <th>Observação</th>
                        <th>Status</th>
                        <th>Aberto em</th>
                        <th>Responsável</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="chamadosContainer">
                </tbody>
            </table>
        </div>
    </div>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/footer.php"; ?>
    <span id="userNivelAcesso" style="display: none;"><?php echo $_SESSION['nivel_acesso']; ?></span>
    <div class="toast-container toast-container-custom">
        <div id="liveToast" class="toast toast-custom" role="alert" aria-live="assertive" aria-atomic="true"
            data-delay="5000">
            <div class="toast-header">
                <strong class="me-auto">Notificação</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body" id="toastBody"></div>
        </div>
    </div>
    <script src="/trabalho-dsw-ads6/public/scripts/VisualizarChamados.js?v=1"></script>
</body>
</html>