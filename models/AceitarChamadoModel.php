<?php
session_start();

include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);
$chamadoId = $data['chamadoId'];

if (empty($chamadoId)) {
    echo json_encode(['success' => false, 'message' => 'ID do chamado não fornecido.']);
    exit;
}

try {
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    $sql = "UPDATE SAP.ANUBIS_chamados SET status = 'ACEITO', tecnico_responsavel = :tecnico_responsavel, data_hora_aceite = NOW() WHERE id = :chamadoId";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':tecnico_responsavel', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->bindParam(':chamadoId', $chamadoId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Chamado aceito com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o chamado.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro na conexão com o banco de dados: ' . $e->getMessage()]);
}

?>
