<?php
class SettingsModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Şifreyi staff ID'ye göre getir
    public function getPasswordById($staffId)
    {
        $sql = "SELECT password FROM staff WHERE staffId = :staffId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':staffId', $staffId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Şifreyi güncelle (düz metin olarak kaydeder)
    public function updatePassword($staffId, $newPassword)
    {
        $sql = "UPDATE staff SET password = :password WHERE staffId = :staffId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR); // Düz metin
        $stmt->bindParam(':staffId', $staffId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
