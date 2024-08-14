<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>EGP | Abertura de Setup</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/reportarChamados.css">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/AberturaSetup.css">
    <link rel="icon" href="/trabalho-dsw-ads6/public/images/trabalho-dsw-ads6-engenharias-grupo-multi.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/header.php"; ?>
    <div class="container mt-5">
        <h2>Abertura de Setup - Linha de Produção</h2>
        <form id="setupForm" method="POST" action="/trabalho-dsw-ads6/models/AberturaSetupModel.php"
            enctype="multipart/form-data">
            <div class="form-group">
                <label for="solicitante">Solicitante:</label>
                <input type="text" id="solicitante" name="solicitante"
                    value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly required />
            </div>
            <div class="form-group">
                <label for="item">item:</label>
                <select id="item" name="item" class="custom-select" required></select>
            </div>
            <div class="form-group">
                <label for="linha">Linha:</label>
                <select class="form-control" id="linha" name="linha" required>
                    <option value="">Selecione a linha</option>
                    <option value="MB01">MB01</option>
                    <option value="MB02">MB02</option>
                    <option value="MB03">MB03</option>
                    <option value="MB04">MB04</option>
                    <option value="MB05">MB05</option>
                    <option value="MB06">MB06</option>
                    <option value="MB07">MB07</option>
                    <option value="MB08">MB08</option>
                    <option value="MB09">MB09</option>
                    <option value="MB10">MB10</option>
                    <option value="MB11">MB11</option>
                    <option value="PC01">PC01</option>
                    <option value="PC02">PC02</option>
                    <option value="PC03">PC03</option>
                    <option value="PC04">PC04</option>
                    <option value="LO01">LO01</option>
                    <option value="LO02">LO02</option>
                    <option value="LO03">LO03</option>
                    <option value="LO04">LO04</option>
                    <option value="LO05">LO05</option>
                    <option value="LO06">LO06</option>
                    <option value="LO07">LO07</option>
                    <option value="LO08">LO08</option>
                    <option value="LO09">LO09</option>
                    <option value="LO10">LO10</option>
                    <option value="ZA01">ZA01</option>
                    <option value="ZA02">ZA02</option>
                    <option value="ZA03">ZA03</option>
                    <option value="ZA04">ZA04</option>
                    <option value="ZB01">ZB01</option>
                    <option value="ZB02">ZB02</option>
                    <option value="ZB03">ZB03</option>
                    <option value="ZB04">ZB04</option>
                    <option value="ZB05">ZB05</option>
                    <option value="ZB06">ZB06</option>
                    <option value="SA01">SA01</option>
                    <option value="SA02">SA02</option>
                    <option value="SA03">SA03</option>
                    <option value="SA04">SA04</option>
                    <option value="SA05">SA05</option>
                    <option value="OPPO">OPPO</option>
                    <option value="PD01">PD01</option>
                    <option value="PD02">PD02</option>
                    <option value="PD03">PD03</option>
                    <option value="LAB">LAB</option>
                    <option value="SMD">SMD</option>
                    <option value="TL01">TL01</option>
                    <option value="TL02">TL02</option>
                    <option value="EL01">EL01</option>
                    <option value="EL02">EL02</option>
                    <option value="ZP01">ZP01</option>
                    <option value="LO1A">LO1A</option>
                    <option value="LO2A">LO2A</option>
                    <option value="LO3A">LO3A</option>
                    <option value="LO4A">LO4A</option>
                    <option value="LO5A">LO5A</option>
                    <option value="LO6A">LO6A</option>
                    <option value="LO8A">LO8A</option>
                    <option value="LO8B">LO8B</option>
                    <option value="LO8C">LO8C</option>
                    <option value="LO8D">LO8D</option>
                    <option value="RD">RD</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tempo_setup">Tempo de Setup (em minutos):</label>
                <input type="number" class="form-control" id="tempo_setup" name="tempo_setup" placeholder="Tempo"
                    required>
            </div>
            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <div id="departamentosAdicionais">
                    <div class="d-flex mb-2">
                        <select class="form-control" name="departamento[]">
                            <option value="Eng. Automação">Eng. Automação</option>
                            <option value="Eng. Teste">Eng. Teste</option>
                            <option value="Eng. Processos">Eng. Processos</option>
                            <option value="Eng. Industrial">Eng. Industrial</option>
                            <option value="Producao">Produção</option>
                            <option value="Qualidade">Qualidade</option>
                            <option value="Manutencao">Manutenção</option>
                        </select>
                        <button type="button" class="btn btn-remove ml-2" onclick="removerDepartamento(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button type="button" style="background-color: #041D29;" class="btn btn-secondary mb-3"
                    onclick="adicionarDepartamento()">+</button>
            </div>
            <div class="form-group">
                <label for="documentos">Documentos para anexo:</label>
                <input type="file" class="form-control-file" id="documentos" name="documentos[]" multiple>
            </div>
            <div class="form-group">
                <div id="documentosAdicionais">
                    <div class="d-flex mb-2">
                        <input type="file" class="form-control-file" name="documentos_adicionais[]">
                        <button type="button" class="btn btn-remove ml-2" onclick="removerDocumento(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button type="button" style="background-color: #041D29;" class="btn btn-secondary"
                    onclick="adicionarDocumento()">+</button>
            </div>
            <div class="form-group">
                <label for="observacao">Observação:</label>
                <textarea class="form-control" id="observacao" name="observacao" rows="3"></textarea>
            </div>
            <button type="submit" name="registrarAtendimento" style="background-color: #041D29;" class="btn btn-primary">Iniciar
                Setup</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/trabalho-dsw-ads6/public/scripts/AberturaSetup.js"></script>
</body>
</html>