<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/egp/config/database.php");

class SetupModel
{
    private $pdo;

    public function __construct()
    {
        $database = new DatabaseConnection();
        $this->pdo = $database->getConnection();
    }

    public function getSetupIdsByUser($usuario)
    {
        $query = "SELECT fk_id_setup, departamento, tecnico FROM ANUBIS_setups_aceite WHERE tecnico = :usuario";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSetupsDetails($setupIds)
    {
        $placeholders = implode(',', array_fill(0, count($setupIds), '?'));
        $query = "SELECT id, solicitante, linha, produto, tempo_setup, observacao, departamentos_solicitados, documentos, status_setup
                  FROM ANUBIS_setups
                  WHERE id IN ($placeholders)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($setupIds);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertDowntimeAndUpdateSetup($setupId, $departamento, $tecnico)
    {
        try {
            $this->pdo->beginTransaction();

            $queryUpdate = "UPDATE ANUBIS_setups 
                    SET data_encerramento = DATE_FORMAT(NOW(), '%d/%m/%Y'),
                        data_hora_encerramento = NOW()
                    WHERE id = :setupId";
            $stmtUpdate = $this->pdo->prepare($queryUpdate);
            $stmtUpdate->bindParam(':setupId', $setupId, PDO::PARAM_INT);
            $stmtUpdate->execute();

            $query = "SELECT data_hora_abertura, data_hora_encerramento, data_hora_aceite 
                  FROM ANUBIS_setups 
                  WHERE id = :setupId";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':setupId', $setupId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result || !$result['data_hora_encerramento']) {
                throw new Exception("Dados insuficientes para calcular downtime");
            }

            $downtimeTecnicoDepartamento = $result['data_hora_aceite'] ?
                round((strtotime($result['data_hora_encerramento']) - strtotime($result['data_hora_aceite'])) / 60) : null;

            $downtimeProducao = $result['data_hora_abertura'] ?
                round((strtotime($result['data_hora_encerramento']) - strtotime($result['data_hora_abertura'])) / 60) : null;

            $queryInsert = "INSERT INTO ANUBIS_setups_downtime 
                    (fk_id_setup, departamento, tecnico, downtime_producao, downtime_tecnico_departamento) 
                    VALUES (:setupId, :departamento, :tecnico, :downtimeProducao, :downtimeTecnicoDepartamento)";
            $stmtInsert = $this->pdo->prepare($queryInsert);
            $stmtInsert->bindParam(':setupId', $setupId, PDO::PARAM_INT);
            $stmtInsert->bindParam(':departamento', $departamento, PDO::PARAM_STR);
            $stmtInsert->bindParam(':tecnico', $tecnico, PDO::PARAM_STR);
            $stmtInsert->bindParam(':downtimeProducao', $downtimeProducao, PDO::PARAM_STR);
            $stmtInsert->bindParam(':downtimeTecnicoDepartamento', $downtimeTecnicoDepartamento, PDO::PARAM_STR);
            $stmtInsert->execute();

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erro: " . $e->getMessage());
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    var_dump($_POST);

    $setupId = $_POST['setup_id'] ?? null;
    $departamento = $_POST['departamento'] ?? null;
    $tecnico = $_POST['tecnico'] ?? null;

    if ($setupId && $departamento && $tecnico) {
        $setupModel = new SetupModel();
        $result = $setupModel->insertDowntimeAndUpdateSetup($setupId, $departamento, $tecnico);

        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos']);
    }
}
?>