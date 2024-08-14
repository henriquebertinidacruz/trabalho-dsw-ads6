<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/models/LoginModel.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/config/authenticator.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/config/database.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>EGP | Controle de Produção</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="/egp/public/images/egp-engenharias-grupo-multi.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/egp/public/styles/ControleProducao.css">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/egp/includes/header.php"; ?>
<style>
    .header-box {
        background-color: #f0f0f0;
        color: #000000;
        padding: 10px;
        border-radius: 5px;
        margin-left: -73px;
        margin-bottom: 20px;
    }

    .header-item {
        font-size: 18px;
    }
</style>
<div class="container-fluid mt-5">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="apontamento-tab" data-toggle="tab" href="#apontamento" role="tab"
               aria-controls="apontamento" aria-selected="true">Apontamento</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="cadastros-tab" data-toggle="tab" href="#cadastros" role="tab"
               aria-controls="cadastros" aria-selected="false">Cadastros</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="novoCadastro-tab" data-toggle="tab" href="#novoCadastro" role="tab"
               aria-controls="novoCadastro" aria-selected="false">Novo Cadastro</a>
        </li>
    </ul>

    <div class="tab-content mt-4" id="myTabContent">
        <div class="tab-pane fade show active" id="apontamento" role="tabpanel" aria-labelledby="apontamento-tab">
            <div id="selectorsContainer" class="mt-4">
                <div>
                    <label for="linhaSelect">Selecione a linha:</label>
                    <select class="form-control select2" id="linhaSelect" style="width: 100%; height: 70px">
                        <option value="" disabled selected>Selecione uma linha</option>
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
                    </select>
                </div>
                <div class="mt-4">
                    <label for="opSelect">Selecione a OP:</label>
                    <select class="form-control select2" id="opSelect" style="width: 100%; height: 70px">
                        <option value="">Selecione uma OP</option>
                        <?php
                        $sql = "SELECT id, ordem_producao FROM ZTE.controle_producao_cadastro";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($result) > 0) {
                            foreach ($result as $row) {
                                echo "<option value='" . $row['ordem_producao'] . "'>" . $row['ordem_producao'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Nenhum posto encontrado</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mt-4">
                    <label for="produtoSelect">Selecione o produto:</label>
                    <select class="form-control select2" id="produtoSelect" style="width: 100%; height: 70px;">
                        <option value="">Selecione um produto</option>
                        <?php
                        $sql = "SELECT id, produto FROM ZTE.controle_producao_cadastro";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($result) > 0) {
                            foreach ($result as $row) {
                                echo "<option value='" . $row['produto'] . "'>" . $row['produto'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Nenhum posto encontrado</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div id="serialNumberContainer" class="mt-4" style="display: none;">
                <div class="container mt-4">
                    <div class="row header-box">
                        <div class="col-6 col-md-4">
                            <div class="header-item">
                                <strong>Responsável:</strong> nome do responsável
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="header-item">
                                <strong>Linha:</strong> linha
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="header-item">
                                <strong>OP:</strong> ordem produção
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mt-3 mt-md-0">
                            <div class="header-item">
                                <strong>Produto:</strong> produto
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mt-3 mt-md-0">
                            <div class="header-item">
                                <strong>Status:</strong> status produção
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mt-3 mt-md-0">
                            <div class="header-item">
                                <strong>Alocado:</strong> quantidade alocada
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mt-3 mt-md-0">
                            <div class="header-item">
                                <strong>Atual:</strong> quantidade atual
                            </div>
                        </div>
                    </div>
                </div>

                <label for="serialNumber">Bipe o Número de Série:</label>
                <input type="text" class="form-control" id="serialNumber" placeholder="Digite o número de série"
                       style="height: 80px; line-height: 80px; font-size: 28px">
            </div>
        </div>


        <div class="tab-pane fade" id="cadastros" role="tabpanel" aria-labelledby="cadastros-tab">
            <div class="mt-4">
                <table id="ordensTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Responsável</th>
                        <th>Linha</th>
                        <th>Produto</th>
                        <th>Ordem de Produção</th>
                        <th>QTD Alocada</th>
                        <th>QTD Atual</th>
                        <th>Status Ordem</th>
                        <th>Data/Hora</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="novoCadastro" role="tabpanel" aria-labelledby="novoCadastro-tab">
            <div class="mt-4">
                <h5>Cadastro de Nova Ordem</h5>
                <form id="novoCadastroForm">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="responsavel">Responsável</label>
                            <input type="text" class="form-control" id="responsavel" name="responsavel"
                                   value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="linha">Linha</label>
                            <select class="form-control" id="linha" name="linha" required>
                                <option value="" disabled selected>Selecione uma linha</option>
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
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="produto">Produto</label>
                            <select class="form-control" id="produto" name="produto" required>
                                <option value="" disabled selected>Selecione um produto</option>
                                <?php
                                try {
                                    $sql = "SELECT ID, PRODUTO FROM SAP.ANUBIS_cadastro_zte";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($result) > 0) {
                                        foreach ($result as $row) {
                                            echo "<option value='" . htmlspecialchars($row['PRODUTO']) . "'>" . htmlspecialchars($row['PRODUTO']) . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Nenhum produto encontrado</option>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<option value=''>Erro ao carregar produtos</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="ordemProducao">Ordem de Produção</label>
                            <input type="text" class="form-control" id="ordemProducao" name="ordemProducao" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="quantidadeAlocada">Quantidade Alocada</label>
                            <input type="number" class="form-control" id="quantidadeAlocada" name="quantidadeAlocada"
                                   required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="quantidadeAtual">Quantidade Atual</label>
                            <input type="number" class="form-control" id="quantidadeAtual" name="quantidadeAtual"
                                   value="0" disabled>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color: #08253F; width: 200px">
                        Cadastrar nova ordem
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="atualizarModal" tabindex="-1" role="dialog" aria-labelledby="atualizarModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="atualizarModalLabel">Atualizar Quantidade Alocada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="atualizarForm">
                        <div class="form-group">
                            <label for="quantidadeAlocada">Quantidade Alocada</label>
                            <input type="number" class="form-control" id="quantidadeAlocada" name="quantidadeAlocada">
                        </div>
                        <input type="hidden" id="id" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="salvarBtn">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/egp/public/scripts/ControleProducao.js"></script>
</body>
</html>
