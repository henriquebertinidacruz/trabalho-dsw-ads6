<?php
require_once 'config/database.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    case 'login':
        require_once 'controllers/LoginController.php';
        $loginController = new LoginController();
        $loginController->index();
        break;
    case 'logout':
        require_once 'views/logout.php';
        break;
    default:
        header("Location: views/layouts/login.php");
        exit();
}
?>
