<?php
class SettingsModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
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
