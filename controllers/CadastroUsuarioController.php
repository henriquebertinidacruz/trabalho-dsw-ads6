<?php
include '../config/database.php';
include '../models/cadastroUsuarioModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $departamento = $_POST["departamento"];
    $nivel = $_POST["nivel"];
    $senha = $_POST["senha"];

    $BancoSAP = new mysqli($servername, $username, $password, $dbname);

    if ($BancoSAP->connect_error) {
        die("Conexão falhou: " . $BancoSAP->connect_error);
    }

    $sql = "INSERT INTO ANUBIS_usuarios (nome, departamento, nivel_acesso, senha, data_hora_insercao)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $BancoSAP->prepare($sql);

    if ($stmt === false) {
        echo '<script>alert("Erro ao preparar a consulta: ' . $BancoSAP->error . '");</script>';
    } else {
        $stmt->bind_param("ssss", $nome, $departamento, $nivel, $senha);

        if ($stmt->execute()) {
            $last_id = $BancoSAP->insert_id;
            echo '<script>alert("Usuário cadastrado com sucesso!");</script>';
            echo '<script>window.location.href = "../views/paginaIntermediariaHub.php";</script>';
        } else {
            echo '<script>alert("Erro ao cadastrar usuário: ' . $stmt->error . '");</script>';
            echo '<script>window.location.href = "../views/paginaIntermediariaHub.php";</script>';
        }

        $stmt->close();
    }
    $BancoSAP->close();
}
?>
