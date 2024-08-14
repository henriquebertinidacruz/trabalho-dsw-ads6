<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /trabalho-dsw-ads6/views/Login.php");
    exit();
}
header("Content-Type: text/html; charset=utf-8");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/models/LoginModel.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/database.php");
?>
<!DOCTYPE html>
<html>


<head>
    <title>ADS | Abrir Chamados</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/reportarChamados.css">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/AbrirChamados.css">   
    <link rel="icon" href="/trabalho-dsw-ads6/public/images/trabalho-dsw-ads6-engenharias-grupo-multi.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/header.php"; ?>
    <div class="container">
        <h1>Abertura de Chamado</h1>
        <form method="post" action="/trabalho-dsw-ads6/models/AbrirChamadosModel.php" id="chamadoForm">
            <label for="departamento">Departamento:</label>
            <select id="departamento" name="departamento_solicitado" class="custom-select" required>
                <option value="">Selecione o departamento</option>
                <?php
                $sql = "SELECT id, departamento FROM departamentos";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['departamento']) . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum departamento encontrado</option>";
                }
                ?>
            </select><br /><br />
            <div id="form-fields" style="display: none;">
                <label for="solicitante">Solicitante:</label>
                <input type="text" id="solicitante" name="solicitante"
                    value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly required /><br /><br />
                <label for="linhaAtendimento">Local:</label>
                <select id="linhaAtendimento" name="linhaAtendimento" class="custom-select" required>
                    <option value="">Selecione o local</option>
                    <option value="Escritório">Escritório</option>
                    <option value="RH">RH</option>
                    <option value="Prod1">Prod1</option>
                    <option value="Prod2">Prod2</option>
                    <option value="Prod3">Prod3</option>
                    <option value="Prod4">Prod4</option>
                    <option value="Logistica">Logistica</option>
                </select><br /><br />
                <label for="local">Item:</label>
                <select id="local" name="local" class="custom-select" required>
                    <option value="">Selecione o Item</option>
                    <?php
                    $sql = "SELECT id, local FROM ads_dsw.cadastro_local";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            echo "<option value='" . $row['id'] . "'>" . $row['local'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum local encontrado</option>";
                    }
                    ?>
                </select><br /><br />
                <label for="descricaoProblema">Descrição Problema:</label>
                <select id="descricaoProblema" name="descricaoProblema" class="custom-select" required>
                    <option value="">Selecione um local primeiro</option>
                </select><br /><br />
                <label for="observacao">Observação:</label>
                <textarea id="observacao" name="observacao" rows="4"></textarea><br /><br />
                <button type="submit" name="registrarAtendimento" id="alert-button">Abrir Chamado</button>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/trabalho-dsw-ads6/public/scripts/AbrirChamados.js"></script>
</body>

</html>