<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/config/authenticator.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/egp/config/database.php");

class ControleProducaoModel
{
    private $pdo;

    public function __construct()
    {
        $database = new DatabaseConnection();
        $this->pdo = $database->getConnection();

        if (!$this->pdo) {
            die("Erro ao conectar ao banco de dados.");
        }
    }

    public function getOrdens()
    {
        $sql = "SELECT id, responsavel, linha, produto, ordem_producao, quantidade_alocada, quantidade_atual, status_producao, data_hora
                FROM ZTE.controle_producao_cadastro";
        $stmt = $this->pdo->query($sql);

        $ordens = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ordens[] = [
                'id' => $row['id'],
                'responsavel' => $row['responsavel'],
                'linha' => $row['linha'],
                'produto' => $row['produto'],
                'ordem_producao' => $row['ordem_producao'],
                'quantidade_alocada' => $row['quantidade_alocada'],
                'quantidade_atual' => $row['quantidade_atual'],
                'status_producao' => $row['status_producao'],
                'data_hora' => $row['data_hora']
            ];
        }
        return $ordens;
    }

    public function insertOrdem($data)
    {
        $status_producao = 'ATIVO';
        $quantidade_atual = 0;

        $sql = "INSERT INTO ZTE.controle_producao_cadastro 
        (responsavel, linha, produto, ordem_producao, quantidade_alocada, quantidade_atual, status_producao, data_hora)
        VALUES (:responsavel, :linha, :produto, :ordem_producao, :quantidade_alocada, :quantidade_atual, :status_producao, NOW())";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':responsavel', $data['responsavel']);
        $stmt->bindParam(':linha', $data['linha']);
        $stmt->bindParam(':produto', $data['produto']);
        $stmt->bindParam(':ordem_producao', $data['ordem_producao']);
        $stmt->bindParam(':quantidade_alocada', $data['quantidade_alocada']);
        $stmt->bindValue(':quantidade_atual', $quantidade_atual);
        $stmt->bindValue(':status_producao', $status_producao);

        $success = $stmt->execute();

        if ($success) {
            return ['success' => true, 'message' => 'Ordem cadastrada com sucesso.'];
        } else {
            $errorInfo = $stmt->errorInfo();
            return ['success' => false, 'message' => 'Erro ao cadastrar ordem: ' . $errorInfo[2]];
        }
    }

    public function insertApontamento($data)
    {
        $checkSql = "SELECT quantidade_alocada, quantidade_atual, status_producao
                 FROM ZTE.controle_producao_cadastro
                 WHERE ordem_producao = :ordem_producao";

        $response = ['success' => false, 'id' => null, 'status' => 'ERRO', 'message' => 'Erro ao processar o apontamento'];

        try {
            $stmt = $this->pdo->prepare($checkSql);
            $stmt->bindParam(':ordem_producao', $data['ordem_producao']);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $quantidadeAlocada = $result['quantidade_alocada'];
                $quantidadeAtual = $result['quantidade_atual'];

                if ($quantidadeAtual < $quantidadeAlocada) {
                    $insertSql = "INSERT INTO ZTE.controle_producao_apontamento (responsavel, linha, produto, ordem_producao, numero_serie, data_hora)
                VALUES (:responsavel, :linha, :produto, :ordem_producao, :numero_serie, :data_hora)";

                    $stmt = $this->pdo->prepare($insertSql);
                    $stmt->bindParam(':responsavel', $data['responsavel']);
                    $stmt->bindParam(':linha', $data['linha']);
                    $stmt->bindParam(':produto', $data['produto']);
                    $stmt->bindParam(':ordem_producao', $data['ordem_producao']);
                    $stmt->bindParam(':numero_serie', $data['numero_serie']);
                    $stmt->bindParam(':data_hora', $data['data_hora']);

                    $stmt->execute();
                    $insertId = $this->pdo->lastInsertId();

                    $updateQuantidadeSql = "UPDATE ZTE.controle_producao_cadastro
                                        SET quantidade_atual = quantidade_atual + 1
                                        WHERE ordem_producao = :ordem_producao";

                    $stmt = $this->pdo->prepare($updateQuantidadeSql);
                    $stmt->bindParam(':ordem_producao', $data['ordem_producao']);
                    $stmt->execute();

                    $stmt = $this->pdo->prepare($checkSql);
                    $stmt->bindParam(':ordem_producao', $data['ordem_producao']);
                    $stmt->execute();

                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        $quantidadeAtual = $result['quantidade_atual'];

                        if ($quantidadeAtual >= $quantidadeAlocada) {
                            $updateStatusSql = "UPDATE ZTE.controle_producao_cadastro
                                            SET status_producao = 'DESATIVADO'
                                            WHERE ordem_producao = :ordem_producao";

                            $stmt = $this->pdo->prepare($updateStatusSql);
                            $stmt->bindParam(':ordem_producao', $data['ordem_producao']);
                            $stmt->execute();
                        }
                    }
                    $response = ['success' => true, 'id' => $insertId];
                } else {
                    $response = ['success' => false, 'status' => 'ERRO', 'message' => 'Já foi apontado o total da ordem de produção! Acione o monitor de produção'];
                }
            } else {
                $response = ['success' => false, 'status' => 'ERRO', 'message' => 'Ordem de produção não encontrada'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'id' => null, 'status' => 'ERRO', 'message' => $e->getMessage()];
        }
        return $response;
    }
}

//echo json_encode($ordens);
?>