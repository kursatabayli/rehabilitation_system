<?php
session_start();
include_once __DIR__ . '/../../config/database.php'; // Absolute path kullanarak dahil etme
include_once __DIR__ . '/../Models/AdminModel.php'; // Absolute path kullanarak dahil etme

class LoginController
{
    private $adminModel;

    public function __construct($pdo)
    {
        $this->adminModel = new AdminModel($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Admin'i veritabanında doğrulama
            $admin = $this->adminModel->authenticate($username, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['adminId']; // Oturuma admin ID'si eklenir
                $_SESSION['username'] = $admin['userName'];
                header('Location: /app/Views/Home/Index.php'); // Başarılı giriş sonrası yönlendirme
                exit;
            } else {
                return "Geçersiz kullanıcı adı veya şifre.";
            }
        }
        return null;
    }
}
