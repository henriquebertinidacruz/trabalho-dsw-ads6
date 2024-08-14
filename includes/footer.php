<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <style>
        body {
            margin: 0;
            padding-bottom: 50px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>
    <footer class="footer">
        <b>ADS - IFSP-BRA</b><br>
        <small>IFSP-BRA | <?= date("Y"); ?></small>
    </footer>
</body>

</html>