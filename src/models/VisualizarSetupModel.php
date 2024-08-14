<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/egp/config/database.php");

class VisualizarSetupModel
{
    private $pdo;

    public function __construct()
    {
        $database = new DatabaseConnection();
        $this->pdo = $database->getConnection();
        session_start();
    }

    public function buscarDados()
    {
        try {
            $sql = "SELECT id, solicitante, linha, produto, tempo_setup, observacao, 
                           departamentos_solicitados, documentos, status_setup, data_hora_abertura
                    FROM SAP.ANUBIS_setups";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados as &$dado) {
                $documentos = explode(';', $dado['documentos']);
                $documentos_completos = array_map(function ($doc) {
                    return '/egp/uploads/documentos/' . trim($doc);
                }, $documentos);
                $dado['documentos'] = $documentos_completos;
            }

            $response = [
                'data' => $dados
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (PDOException $e) {
            echo "Erro ao buscar dados: " . $e->getMessage();
        }
    }

    public function inserirAceite($setupId, $departamento)
    {
        try {
            $tecnico = isset($_SESSION['username']) ? $_SESSION['username'] : 'Desconhecido';

            $sql = "INSERT INTO ANUBIS_setups_aceite (fk_id_setup, departamento, tecnico, status, data_hora_aceite) 
                VALUES (:setupId, :departamento, :tecnico, 'ACEITO', NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':setupId', $setupId, PDO::PARAM_INT);
            $stmt->bindParam(':departamento', $departamento, PDO::PARAM_STR);
            $stmt->bindParam(':tecnico', $tecnico, PDO::PARAM_STR);
            $stmt->execute();

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => "Erro ao inserir aceite: " . $e->getMessage()]);
        }
    }

    public function buscarDadosAceite($setupId)
    {
        try {
            error_log("setupId recebido: " . $setupId);

            $sql = "SELECT fk_id_setup, departamento, tecnico, status FROM ANUBIS_setups_aceite WHERE fk_id_setup = :setupId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':setupId', $setupId, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            $response = ['success' => true, 'data' => $dados];
            error_log("Resposta JSON: " . json_encode($response));
            echo json_encode($response);
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => "Erro ao buscar dados do aceite: " . $e->getMessage()]);
        }
    }

}

$model = new VisualizarSetupModel();
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'aceitarDepartamento') {
    $setupId = isset($_POST['setupId']) ? intval($_POST['setupId']) : 0;
    $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
    $model->inserirAceite($setupId, $departamento);
} elseif ($action === 'buscarDadosAceite') {
    $setupId = isset($_POST['setupId']) ? intval($_POST['setupId']) : 0;
    $model->buscarDadosAceite($setupId);
} else {
    $model->buscarDados();
}
?>