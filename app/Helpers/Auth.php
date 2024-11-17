<?php
function checkAuth()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['admin_id'])) {
        header('Location: /app/Views/Authenticate/Login.php');
        exit;
    }
}
