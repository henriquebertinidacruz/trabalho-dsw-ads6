<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/database.php");

$database = new DatabaseConnection();
$db = $database->getConnection();

$chamados = [];
$user = [];

if (isset($_SESSION['username'])) {
    $query = "SELECT id, linha, local, item, descricao_problema AS descricao, solucao, status, data_hora_abertura AS abertura, data_hora_encerramento AS fechamento
              FROM chamados
              WHERE solicitante = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $chamados[] = $row;
    }

    $queryUser = "SELECT nome, filial, departamento
                  FROM usuarios
                  WHERE nome = :username";
    $stmtUser = $db->prepare($queryUser);
    $stmtUser->bindParam(':username', $_SESSION['username']);
    $stmtUser->execute();

    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Usuário não autenticado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EGP | Perfil de Usuário</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="/trabalho-dsw-ads6/public/images/trabalho-dsw-ads6-engenharias-grupo-multi.png" type="image/x-icon">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/styles.css">
    <link rel="stylesheet" href="/trabalho-dsw-ads6/public/styles/paginaIntermediariaHub.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/header.php"; ?>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Informações do Perfil</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <?php if (isset($user['foto_url']) && !empty($user['foto_url'])): ?>
                                <img src="<?php echo htmlspecialchars($user['foto_url']); ?>" alt="Foto do Usuário"
                                    class="img-fluid rounded-circle" style="width: 120px; height: 120px;">
                            <?php else: ?>
                                <i class="fas fa-user-circle fa-5x"></i>
                            <?php endif; ?>
                        </div>
                        <form>
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" class="form-control" id="name"
                                    value="<?php echo isset($user['nome']) ? htmlspecialchars($user['nome']) : 'N/A'; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="filial">Filial</label>
                                <input type="text" class="form-control" id="filial"
                                    value="<?php echo isset($user['filial']) ? htmlspecialchars($user['filial']) : 'N/A'; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="departmento">Departamento</label>
                                <input type="text" class="form-control" id="departmento"
                                    value="<?php echo isset($user['departamento']) ? htmlspecialchars($user['departamento']) : 'N/A'; ?>"
                                    readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Histórico de Chamados</h4>
                    </div>
                    <div class="card-body">
                        <table id="chamadosTable" class="display">
                            <thead>
                                <tr>
                                    <th>Linha</th>
                                    <th>local</th>
                                    <th>item</th>
                                    <th>Descrição</th>
                                    <th>Solução</th>
                                    <th>Status</th>
                                    <th>Abertura</th>
                                    <th>Fechamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($chamados as $chamado): ?>
                                    <tr>
                                        <td><?php echo !empty($chamado['linha']) ? htmlspecialchars($chamado['linha']) : ''; ?>
                                        </td>
                                        <td><?php echo !empty($chamado['local']) ? htmlspecialchars($chamado['local']) : ''; ?>
                                        </td>
                                        <td><?php echo !empty($chamado['item']) ? htmlspecialchars($chamado['item']) : ''; ?>
                                        </td>
                                        <td><?php echo !empty($chamado['descricao']) ? htmlspecialchars($chamado['descricao']) : ''; ?>
                                        </td>
                                        <td><?php echo !empty($chamado['solucao']) ? htmlspecialchars($chamado['solucao']) : ''; ?>
                                        </td>
                                        <td><?php echo !empty($chamado['status']) ? htmlspecialchars($chamado['status']) : ''; ?>
                                        </td>
                                        <td><?php echo !empty($chamado['abertura']) ? htmlspecialchars($chamado['abertura']) : ''; ?>
                                        </td>
                                        <td><?php echo !empty($chamado['fechamento']) ? htmlspecialchars($chamado['fechamento']) : ''; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/includes/footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#chamadosTable').DataTable();
        });
    </script>
</body>

</html>