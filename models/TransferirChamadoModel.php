<?php
session_start();

include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);
$chamadoId = $data['chamadoId'];

if (empty($chamadoId)) {
    echo json_encode(['success' => false, 'message' => 'ID do chamado não fornecido.']);
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE SAP.ANUBIS_chamados SET status = 'ACEITO', tecnico_responsavel = ?, data_hora_aceite = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("si", $tecnico_responsavel, $chamadoId); 
    $tecnico_responsavel = $_SESSION['username'];
    $chamadoId = $data['chamadoId'];
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Chamado aceito com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o chamado.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar a declaração.']);
}

$conn->close();
?>
