<?php
header("Content-Type: text/html; charset=utf-8");
require_once(__DIR__ . "/../config/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $local = $_POST["local"];
    $departamento_id = $_POST["departamento_id"];

    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    try {
        $sql = "INSERT INTO adastro_local (local, departamento_id) VALUES (:local, :departamento_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':local', $local, PDO::PARAM_STR);
        $stmt->bindParam(':departamento_id', $departamento_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<script>alert("local cadastrado com sucesso");</script>';
            echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
        } else {
            echo '<script>alert("Erro ao cadastrar o local: ' . implode(", ", $stmt->errorInfo()) . '");</script>';
            echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Erro ao cadastrar o local: ' . $e->getMessage() . '");</script>';
        echo '<script>window.location.href = "../views/PaginaIntermediaria.php";</script>';
    }
}
?>
