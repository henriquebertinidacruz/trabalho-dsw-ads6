<?php
include '/trabalho-dsw-ads6/config/database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT id, status FROM ANUBIS_chamados WHERE status = 'PENDENTE'";
$result = $conn->query($sql);

if ($result === false) {
    die("Erro na consulta: " . $conn->error);
}

ob_start();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['id'] . '</option>';
    }
} else {
    echo '<option value="">Nenhum chamado pendente encontrado</option>';
}

echo ob_get_clean();

$conn->close();
?>
