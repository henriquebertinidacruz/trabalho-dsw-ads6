<?php
include '../config/database.php';
include '../controllers/EncerrarChamadosController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrarAtendimento"])) {
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    $idDoChamado = $_POST["idDoChamado"];
    $solucaoProblema = $_POST["solucaoProblema"];
    $descricaoProblema = $_POST["descricaoProblema"];
    $tecnicoResponsavel = $_POST["tecnicoResponsavel"];

    try {
        $sqlFilialDepartamento = "SELECT filial, departamento FROM SAP.ANUBIS_usuarios WHERE nome = :tecnico";
        $stmtFilialDepartamento = $pdo->prepare($sqlFilialDepartamento);
        $stmtFilialDepartamento->bindParam(':tecnico', $tecnicoResponsavel, PDO::PARAM_STR);
        $stmtFilialDepartamento->execute();
        $resultFilialDepartamento = $stmtFilialDepartamento->fetch(PDO::FETCH_ASSOC);

        if (!$resultFilialDepartamento) {
            throw new Exception("Técnico não encontrado");
        }

        $filial = $resultFilialDepartamento['filial'];
        $departamento = $resultFilialDepartamento['departamento'];

        $sql = "UPDATE ANUBIS_chamados SET 
                solucao = :solucao,
                tecnico_responsavel = :tecnico_responsavel,
                departamento_tecnico_responsavel = :departamento,
                status = 'CONCLUIDO',
                data_encerramento = DATE_FORMAT(NOW(), '%d/%m/%Y'),
                data_hora_encerramento = NOW(),
                downtime_producao = ROUND(TIMESTAMPDIFF(SECOND, data_hora_abertura, NOW()) / 60),
                downtime_tecnico = ROUND(TIMESTAMPDIFF(SECOND, data_hora_aceite, NOW()) / 60)
                WHERE id = :idDoChamado";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':solucao', $solucaoProblema, PDO::PARAM_STR);
        $stmt->bindParam(':tecnico_responsavel', $tecnicoResponsavel, PDO::PARAM_STR);
        $stmt->bindParam(':departamento', $departamento, PDO::PARAM_STR);
        $stmt->bindParam(':idDoChamado', $idDoChamado, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => 'Chamado Finalizado com sucesso!',
                'redirect' => '/trabalho-dsw-ads6/views/PaginaIntermediaria.php'
            ];
            echo json_encode($response);
            exit;
        } else {
            echo '<script>
                    alert("Erro ao registrar o atendimento: ' . $stmt->errorInfo() . '");
                    window.location.href = "../views/PaginaIntermediaria.php";
                  </script>';
        }
        $stmt->closeCursor();
    } catch (PDOException $e) {
        echo "Erro ao executar a consulta SQL: " . $e->getMessage();
    } catch (Exception $ex) {
        echo "Erro: " . $ex->getMessage();
    }
}
?>