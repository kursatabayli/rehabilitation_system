<?php
$title = "Ayarlar";

include '../../Controllers/SettingsController.php';

$controller = new SettingsController($pdo);
$message = $controller->handlePasswordChangeRequest();

ob_start();
?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Şifre Değiştir</h4>
                <p class="card-subtitle mb-4">Mevcut şifrenizi girin ve yeni şifrenizi belirleyin.</p>
                <form action="" method="POST" class="form-settings input-sm">
                    <div class="form-group">
                        <label for="currentPassword">Mevcut Şifre:</label>
                        <div class="password-wrapper">
                            <input type="password" id="currentPassword" name="currentPassword" class="form-control" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('currentPassword')"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="newPassword">Yeni Şifre:</label>
                        <div class="password-wrapper">
                            <input type="password" id="newPassword" name="newPassword" class="form-control" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('newPassword')"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Yeni Şifre (Tekrar):</label>
                        <div class="password-wrapper">
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('confirmPassword')"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Şifreyi Güncelle</button>
                </form>

                <?php if ($message): ?>
                    <p class="mt-3 alert alert-info"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>