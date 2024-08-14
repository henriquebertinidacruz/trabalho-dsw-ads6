<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/controllers/EncerrarSetupController.php");

$controller = new SetupController();
$data = $controller->showSetups();
?>

<!DOCTYPE html>
<html>

<head>
    <title>EGP | Encerrar Setup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/egp/public/styles/EncerrarSetup.css">
    <link rel="icon" href="/egp/public/images/egp-engenharias-grupo-multi.ico" type="image/x-icon">
</head>

<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/egp/includes/header.php"; ?>

<h1 class="mt-4">Setups Atribuídos</h1>

<?php if (isset($data['message'])): ?>
    <p><?php echo htmlspecialchars($data['message']); ?></p>
<?php elseif (isset($data['setups'])): ?>
    <div class="container mt-4">
        <?php foreach ($data['setups'] as $setup): ?>
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Setup
                    ID: <?php echo isset($setup['id']) ? htmlspecialchars($setup['id']) : 'ID não disponível'; ?>
                    -
                    Produto: <?php echo htmlspecialchars($setup['produto']); ?>
                </div>
                <div class="card-body">
                    <p><strong>Solicitante:</strong> <?php echo htmlspecialchars($setup['solicitante']); ?></p>
                    <p><strong>Linha:</strong> <?php echo htmlspecialchars($setup['linha']); ?></p>
                    <p><strong>Tempo Setup:</strong> <?php echo htmlspecialchars($setup['tempo_setup']); ?></p>
                    <p><strong>Observação:</strong> <?php echo htmlspecialchars($setup['observacao']); ?></p>
                    <p><strong>Departamentos Solicitados:</strong>
                        <?php echo htmlspecialchars($setup['departamentos_solicitados']); ?></p>
                    <p><strong>Documentos:</strong> <?php echo htmlspecialchars($setup['documentos']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($setup['status_setup']); ?></p>
                    <a href="javascript:void(0);" class="btn btn-custom"
                       onclick="concluirSetup(
                       <?php echo isset($setup['id']) ? htmlspecialchars($setup['id']) : 'null'; ?>,
                               '<?php echo isset($setup['departamento']) ? htmlspecialchars($setup['departamento']) : ''; ?>',
                               '<?php echo isset($setup['tecnico']) ? htmlspecialchars($setup['tecnico']) : ''; ?>'
                               )">Concluir Setup</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<script src="/egp/public/scripts/EncerrarSetup.js"></script>
</body>
</html>