<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/trabalho-dsw-ads6/config/database.php");

try {
    $database = new DatabaseConnection();
    $conn = $database->getConnection();

    $sql = "SELECT id, solicitante, linha, local, item, descricao_problema, observacao, status, data_hora_abertura, tecnico_responsavel FROM SAP.ANUBIS_chamados WHERE STATUS = 'PENDENTE' OR STATUS = 'ACEITO' ORDER BY -id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['data' => $chamados]);
} catch (PDOException $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => $e->getMessage()]);
}
