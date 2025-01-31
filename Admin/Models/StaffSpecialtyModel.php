<?php
class StaffSpecialtyModel
{
    private $pdo;

    // PDO nesnesi ile sınıfı başlat
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Personelin uzmanlıklarını getir
    public function getSpecialtiesByStaffId($staffId)
    {
        $sql = "
            SELECT ss.staffSpecialtyId, sp.specialtyId, sp.specialtyName
            FROM staffspecialty ss
            INNER JOIN specialty sp ON ss.specialtyId = sp.specialtyId
            WHERE ss.staffId = :staffId
        ";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':staffId', $staffId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Hata durumunda log yaz ve boş array dön
            error_log("Veritabanı hatası: " . $e->getMessage());
            return [];
        }
    }

    // Uzmanlık ekle
    public function addSpecialtyToStaff($data)
    {
        $sql = "INSERT INTO staffspecialty (staffId, specialtyId) VALUES (:staffId, :specialtyId)";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }

    // staffSpecialtyId kullanarak uzmanlık sil
    public function deleteStaffSpecialty($staffSpecialtyId)
    {
        $sql = "DELETE FROM staffspecialty WHERE staffSpecialtyId = :staffSpecialtyId";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':staffSpecialtyId', $staffSpecialtyId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }

}
