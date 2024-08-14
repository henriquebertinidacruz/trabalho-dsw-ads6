<?php
header("Content-Type: text/html; charset=utf-8");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/database.php");

$database = new DatabaseConnection();
$pdo = $database->getConnection();
?>

<!DOCTYPE html>
<html>

<head>
    <title>EGP | Encerrar Chamados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/reportarChamados.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #08253F; color: White;">
            <a class="navbar-brand text-white" href="/trabalho-dsw-ads6/index.php">Anúbis - Engenharia de Automação</a>
        </nav>
    </header>
    <div class="container">
        <h1>Registro de Atendimento/Chamado - Eng. Automação</h1>
        <form method="post" action="/trabalho-dsw-ads6/models/EncerrarChamadosModel.php" id="encerrarChamadoForm"
            onsubmit="return validarFormulario()">
            <label for="tecnicoResponsavel">Técnico Responsável:</label>
            <input type="text" id="tecnicoResponsavel" name="tecnicoResponsavel"
                value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly /><br /><br />
            <label for="idDoChamado">ID do Chamado:</label>
            <select id="idDoChamado" name="idDoChamado" class="custom-select" required>
                <?php
                try {
                    $sql = "SELECT id FROM SAP.ANUBIS_chamados WHERE status = 'ACEITO' AND tecnico_responsavel = :tecnico_responsavel";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':tecnico_responsavel', $_SESSION['username'], PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($result && count($result) > 0) {
                        foreach ($result as $row) {
                            echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum chamado pendente</option>";
                    }
                } catch (PDOException $e) {
                    echo "Erro de conexão: " . $e->getMessage();
                }
                ?>
            </select><br /><br />
            <label for="solucaoProblema">Solução do Problema:</label>
            <textarea id="solucaoProblema" name="solucaoProblema" rows="4" required></textarea><br /><br />
            <label for="descricaoProblema">Observação:</label>
            <textarea id="descricaoProblema" name="descricaoProblema" rows="4"></textarea><br /><br />
            <div class="validation-label" id="validationLabel"></div>
            <button type="submit" name="registrarAtendimento" id="registrarAtendimentoButton">Registrar
                Atendimento</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/trabalho-dsw-ads6/public/scripts/EncerrarChamados.js"></script>
</body>

</html>