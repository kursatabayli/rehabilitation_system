<?php
function checkAuth()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['_adminId'])) {
        header('Location: /Authenticate/Login.php');
        exit;
    }
}
