<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/trabalho-dsw-ads6/config/authenticator.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #08253F; color: White;">
            <a class="navbar-brand text-white" href="/trabalho-dsw-ads6/index.php">ADS | DSW</a>
            <div class="ml-auto text-white d-flex align-items-center">
                <button onclick="window.history.back();" class="btn text-white mr-3">
                    <i class="bi bi-chevron-double-left" style="color: white;"></i>
                </button>
                <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="../../index.php" class="ml-3 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h5A1.5 1.5 0 0 1 14 3.5v9A1.5 1.5 0 0 1 12.5 14h-5A1.5 1.5 0 0 1 6 12.5v-9zM7.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-5z"/>
                        <path fill-rule="evenodd" d="M11.354 8.354a.5.5 0 0 0 0-.708l-2-2a.5.5 0 0 0-.708.708L10.293 8l-1.647 1.646a.5.5 0 0 0 .708.708l2-2z"/>
                        <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-1 0v1a.5.5 0 0 0 .5.5z"/>
                        <path fill-rule="evenodd" d="M3.646 7.646a.5.5 0 0 0 .708 0L6 5.707V4.5a.5.5 0 0 0-1 0v1.207L4.354 7.354a.5.5 0 0 0 0 .292z"/>
                    </svg>
                    Sair
                </a>
            </div>
        </nav>
    </header>
</body>
</html>
