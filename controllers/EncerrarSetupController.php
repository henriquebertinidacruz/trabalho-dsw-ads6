<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/egp/models/EncerrarSetupModel.php");

class SetupController
{
    private $model;

    public function __construct()
    {
        $this->model = new SetupModel();
    }

    public function showSetups()
    {
        session_start();
        $usuarioLogado = $_SESSION['username'];

        $setupDetails = $this->model->getSetupIdsByUser($usuarioLogado);

        if (empty($setupDetails)) {
            return ['message' => 'Nenhum setup atribuído ao usuário.'];
        }

        $setups = [];

        foreach ($setupDetails as $detail) {
            $setupId = $detail['fk_id_setup'];
            $departamento = $detail['departamento'];
            $tecnico = $detail['tecnico'];

            $setupInfo = $this->model->getSetupsDetails([$setupId]);

            if (!empty($setupInfo)) {
                $setup = $setupInfo[0];
                $setup['departamento'] = $departamento;
                $setup['tecnico'] = $tecnico;
                $setups[] = $setup;
            }
        }

        return ['setups' => $setups];
    }

    public function encerrarSetup($setupId, $departamento, $tecnico)
    {
        $success = $this->model->insertDowntimeAndUpdateSetup($setupId, $departamento, $tecnico);

        if ($success) {
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Erro ao registrar downtime']);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new SetupController();
    $setupId = $_POST['setup_id'] ?? null;
    $departamento = $_POST['departamento'] ?? null;
    $tecnico = $_POST['tecnico'] ?? null;

    if ($setupId && $departamento && $tecnico) {
        echo $controller->encerrarSetup($setupId, $departamento, $tecnico);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos']);
    }
}
?>