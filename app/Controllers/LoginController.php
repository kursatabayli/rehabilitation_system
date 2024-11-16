<?php
session_start();
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../Models/LoginModel.php';

class LoginController
{
    private $adminModel;

    public function __construct($pdo)
    {
        $this->adminModel = new LoginModel($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Admin'i veritabanında doğrulama
            $admin = $this->adminModel->authenticate($username, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['adminId'];
                $_SESSION['username'] = $admin['userName'];
                header('Location: /rehabilitation_system/app/Views/Home/Index.php');
                exit;
            } else {
                return "Kullanıcı Adı Veya Şifre Yanlış!";
            }
        }
        return null;
    }
}
