<?php

if (!isset($_SESSION)) {
    session_start();

    if (!isset($_SESSION['username'])) header("location:" . '/trabalho-dsw-ads6/views/Login.php');
}
