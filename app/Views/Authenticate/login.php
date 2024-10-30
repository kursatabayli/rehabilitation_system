<?php
// Hata gösterimini açma (Geliştirme aşamasında hataları görmek için)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Gerekli dosyaları dahil etme
include_once '../../Controllers/LoginController.php';
include_once '../../../config/database.php';

// LoginController'ı başlatıyoruz
$loginController = new LoginController($pdo);

// POST isteği olup olmadığını kontrol ediyoruz ve giriş işlemini başlatıyoruz
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = $loginController->login(); // Başarısız olursa hata mesajı döner
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Giriş Yap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body class="login-page">

    <div class="login-container">
        <h2 class="login-title">Giriş Yap</h2>
        
        <form action="" method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="form-group password-group">
                <label for="password">Şifre</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i> <!-- Göz simgesi -->
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary login-btn">Giriş Yap</button>
        </form>

        <?php if (isset($error) && $error): ?>
            <p class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
    </div>

    <script>
    function togglePassword() {
        const passwordField = document.getElementById("password");
        const toggleIcon = document.querySelector(".toggle-password");
        
        // Şifreyi göster/gizle
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
    </script>

</body>
</html>
