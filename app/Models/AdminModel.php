<?php
class AdminModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Düz metin karşılaştırması (şifre hash'lenmemiş)
    public function authenticate($username, $password)
    {
        $sql = "SELECT * FROM admin WHERE userName = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Düz metin karşılaştırması
        if ($admin && $password === $admin['password']) {
            return $admin;
        }
        return null;
    }

    // Şifreyi admin ID'ye göre getir
    public function getPasswordById($adminId)
    {
        $sql = "SELECT password FROM admin WHERE adminId = :adminId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':adminId', $adminId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Şifreyi güncelle (düz metin olarak kaydeder)
    public function updatePassword($adminId, $newPassword)
    {
        $sql = "UPDATE admin SET password = :password WHERE adminId = :adminId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR); // Düz metin
        $stmt->bindParam(':adminId', $adminId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}