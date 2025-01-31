<?php
// Models/StaffModel.php

class StaffModel
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  // Tek bir personel kaydı getir
  public function getStaffById($staffId)
  {
    $sql = "
        SELECT s.*, p.professionName 
        FROM staff s
        LEFT JOIN profession p ON s.professionId = p.professionId
        WHERE s.staffId = :staffId
    ";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':staffId', $staffId, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return null;
    }
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
}
