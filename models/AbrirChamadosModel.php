<?php
header("Content-Type: text/html; charset=utf-8");
include '../config/database.php';
include '../controllers/AbrirChamadosController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrarAtendimento"])) {
    $solicitante = $_POST["solicitante"];
    $linhaAtendimento = $_POST["linhaAtendimento"];
    $local_id = $_POST["local"];
    $item = $_POST["item"];
    $descricaoProblema = $_POST["descricaoProblema"];
    $observacao = $_POST["observacao"];
    $departamento_solicitado = $_POST["departamento_solicitado"];
    $departamento_solicitado_id = $_POST["departamento_solicitado"];

    try {
        $database = new DatabaseConnection();
        $pdo = $database->getConnection();

        $sqlDepartamento = "SELECT departamento FROM departamentos WHERE id = :departamento_solicitado_id";
        $stmtDepartamento = $pdo->prepare($sqlDepartamento);
        $stmtDepartamento->bindParam(':departamento_solicitado_id', $departamento_solicitado_id, PDO::PARAM_INT);
        $stmtDepartamento->execute();
        $departamento_solicitado = $stmtDepartamento->fetchColumn();


        $sqlFilialDepartamento = "SELECT filial, departamento FROM usuarios WHERE nome = :solicitante";
        $stmtFilialDepartamento = $pdo->prepare($sqlFilialDepartamento);
        $stmtFilialDepartamento->bindParam(':solicitante', $solicitante, PDO::PARAM_STR);
        $stmtFilialDepartamento->execute();
        $resultFilialDepartamento = $stmtFilialDepartamento->fetch(PDO::FETCH_ASSOC);

        if (!$resultFilialDepartamento) {
            throw new Exception("Solicitante não encontrado");
        }

        $filial = $resultFilialDepartamento['filial'];
        $departamento = $resultFilialDepartamento['departamento'];

        $sqllocal = "SELECT local FROM cadastro_local WHERE id = :local_id";
        $stmtlocal = $pdo->prepare($sqllocal);
        $stmtlocal->bindParam(':local_id', $local_id, PDO::PARAM_INT);
        $stmtlocal->execute();
        $local = $stmtlocal->fetchColumn();

        $date = date('d/m/Y');

        $sql = "INSERT INTO chamados (filial, solicitante, linha, local, item, descricao_problema, observacao, status, departamento_solicitante, departamento_solicitado, data_abertura, data_hora_abertura)
        VALUES (:filial, :solicitante, :linhaAtendimento, :local, :item, :descricaoProblema, :observacao, 'PENDENTE', :departamento, :departamento_solicitado, :date, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':filial', $filial);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':solicitante', $solicitante);
        $stmt->bindParam(':linhaAtendimento', $linhaAtendimento);
        $stmt->bindParam(':local', $local);
        $stmt->bindParam(':item', $item);
        $stmt->bindParam(':descricaoProblema', $descricaoProblema);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':departamento_solicitado', $departamento_solicitado);

        if ($stmt->execute()) {

            $response = [
                'success' => true,
                'message' => 'Chamado aberto com sucesso!',
                'redirect' => '/trabalho-dsw-ads6/views/PaginaIntermediaria.php'
            ];
            echo json_encode($response);
            exit;
        } else {
            echo '<script>alert("Erro ao registrar o atendimento.");</script>';
            echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Erro ao conectar ao banco de dados: ' . $e->getMessage() . '");</script>';
        echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
    } catch (Exception $e) {
        echo '<script>alert("Erro: ' . $e->getMessage() . '");</script>';
        echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['local'])) {
    $local = $_POST['local'];

    try {
        $database = new DatabaseConnection();
        $pdo = $database->getConnection();

        $sql = "SELECT id, falha FROM cadastro_falhas WHERE local_id = :local_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':local_id', $local, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "falhas" => $result]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro ao conectar ao banco de dados: " . $e->getMessage()]);
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['departamento_id'])) {
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    $departamento_id = $_POST['departamento_id'];
    $sql = "SELECT id, local FROM cadastro_local WHERE departamento_id = :departamento_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':departamento_id', $departamento_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
    exit;
}
echo json_encode(["success" => false, "message" => "Requisição inválida"]);
exit;
?>