<?php
session_start();
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/LoginModel.php';

class LoginController
{
    private $loginModel;

    public function __construct($pdo)
    {
        $this->loginModel = new LoginModel($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username']; // Admin için username, staff için email
            $password = $_POST['password'];

            $result = $this->loginModel->authenticate($username, $password);

            if ($result) {
                $user = $result['data'];
                $type = $result['type'];

                // Session bilgilerini ayarla
                if ($type === 'admin') {
                    $_SESSION['_adminId'] = $user['adminId'];
                    $_SESSION['username'] = $user['username'];
                    header('Location: /Admin/Views/Session/Index.php');
                } elseif ($type === 'staff') {
                    $_SESSION['_staffId'] = $user['staffId'];
                    $_SESSION['email'] = $user['email'];
                    header('Location: /Personel/Views/Session/Index.php');
                }
                exit;
            } else {
                return "Kullanıcı Adı Veya Şifre Yanlış!";
            }
        }
        return null;
    }
}
