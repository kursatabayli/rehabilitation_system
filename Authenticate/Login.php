<?php
global $pdo;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'LoginController.php';
include_once '../config/database.php';

if (isset($_SESSION['_adminId'])) {
    header('Location: /Admin/Views/Session/Index.php');
    exit;
}
if (isset($_SESSION['_staffId'])) {
    header('Location: /Personel/Views/Session/Index.php');
    exit;
}
$loginController = new LoginController($pdo);

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = $loginController->login();
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Paneli - Giriş Yap</title>
    <link rel="icon" type="image/x-icon" href="/assets/icons/login.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body class="login-page">

    <div class="login-container">
        <h2 class="login-title">Giriş Yap</h2>

        <form action="" method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Kullanıcı Adı/E-Posta</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group password-group">
                <label for="password">Şifre</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary login-btn">Giriş Yap</button>
        </form>
        <?php if (isset($error) && $error): ?>
            <p class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
    </div>

    <script src="/assets/js/script.js"></script>

</body>

</html>