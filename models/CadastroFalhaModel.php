<?php
header("Content-Type: text/html; charset=utf-8");
require_once(__DIR__ . "/../config/database.php");
require_once(__DIR__ . "/../controllers/CadastroFalhaController.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $falha = $_POST["falha"];
    $local_id = $_POST["local_id"];

    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    try {
        $sql = "INSERT INTO ANUBIS_cadastro_falhas (falha, local_id) VALUES (:falha, :local_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':falha', $falha, PDO::PARAM_STR);
        $stmt->bindParam(':local_id', $local_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<script>alert("Falha cadastrada com sucesso");</script>';
            echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
        } else {
            $errorInfo = $stmt->errorInfo();
            echo '<script>alert("Erro ao cadastrar a falha: ' . $errorInfo[2] . '");</script>';
            echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Erro ao cadastrar a falha: ' . $e->getMessage() . '");</script>';
        echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
    }
}
?>
