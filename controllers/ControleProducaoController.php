<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/config/authenticator.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/models/ControleProducaoModel.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$model = new ControleProducaoModel();

switch ($_GET['action']) {
    case 'getData':
        $ordens = $model->getOrdens();
        echo json_encode($ordens);
        exit;
    case 'createApontamento':
        try {
            $data = [
                'responsavel' => $_SESSION['username'],
                'linha' => $_POST['linha'],
                'produto' => $_POST['produto'],
                'ordem_producao' => $_POST['ordem_producao'],
                'numero_serie' => $_POST['numero_serie'],
                'data_hora' => date('Y-m-d H:i:s'),
            ];
            $result = $model->insertApontamento($data);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    case 'createOrdem':
        try {
            $data = [
                'responsavel' => $_SESSION['username'],
                'linha' => $_POST['linha'],
                'produto' => $_POST['produto'],
                'ordem_producao' => $_POST['ordemProducao'],
                'quantidade_alocada' => $_POST['quantidadeAlocada']
            ];
            print_r($data);
            $result = $model->insertOrdem($data);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    default:
        echo json_encode(['success' => false, 'message' => 'Método não suportado.']);
        exit;
}
?>
