<?php
// Models/StaffModel.php

class StaffModel
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  // Tüm personel kayıtlarını profesyon adıyla birlikte getir
  public function getAllStaff()
  {
    $sql = "
      SELECT s.staffId, s.name, s.surname, p.professionName 
      FROM staff s
      JOIN profession p ON s.professionId = p.professionId
    ";
    try {
      $stmt = $this->pdo->query($sql);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return [];
    }
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

  // Yeni bir personel ekle
  public function createStaff($data)
  {
    $sql = "
      INSERT INTO staff (name, surname, personnelNumber, medicalLicenceNumber, professionId, identityNumber, phoneNumber, email, password, gender, dateOfRecruitment) 
      VALUES (:name, :surname, :personnelNumber, :medicalLicenceNumber, :professionId, :identityNumber, :phoneNumber, :email, :password, :gender, :dateOfRecruitment)
    ";
    try {
      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute($data);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }

  // Personel güncelle
  public function updateStaff($staffId, $data)
  {
    $sql = "UPDATE staff SET name = :name, surname = :surname, personnelNumber = :personnelNumber, medicalLicenceNumber = :medicalLicenceNumber, professionId = :professionId, identityNumber = :identityNumber, phoneNumber = :phoneNumber, email = :email, password = :password, gender = :gender, dateOfRecruitment = :dateOfRecruitment WHERE staffId = :staffId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $data['staffId'] = $staffId;
      return $stmt->execute($data);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }

  // Personel kaydını sil
  public function deleteStaff($staffId)
  {
    $sql = "DELETE FROM staff WHERE staffId = :staffId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':staffId', $staffId, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }
}
