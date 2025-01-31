<?php
class LoginModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Hem admin hem de staff doğrulaması yapar
    public function authenticate($username, $password)
    {
        // Önce admin tablosunda arama yap
        $admin = $this->getAdminByUsername($username);
        if ($admin && $password === $admin['password']) {
            return ['type' => 'admin', 'data' => $admin];
        }

        // Admin bulunamazsa staff tablosunda arama yap
        $staff = $this->getStaffByEmail($username);
        if ($staff && $password === $staff['password']) {
            return ['type' => 'staff', 'data' => $staff];
        }
        // Giriş başarısız
        return null;
    }

    private function getAdminByUsername($username)
    {
        $sql = "SELECT * FROM admin WHERE userName = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getStaffByEmail($email)
    {
        $sql = "SELECT * FROM staff WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
