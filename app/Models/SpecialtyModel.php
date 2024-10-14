<?php
// Models/SpecialtyModel.php

class SpecialtyModel
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  // Tüm uzmanlıkları getir
  public function getAllSpecialties()
  {
    $sql = "SELECT * FROM specialty";
    try {
      $stmt = $this->pdo->query($sql);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return [];
    }
  }

  // Tek bir uzmanlık kaydını Id'ye göre getir
  public function getSpecialtyById($specialtyId)
  {
    $sql = "SELECT * FROM specialty WHERE specialtyId = :specialtyId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':specialtyId', $specialtyId, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return null;
    }
  }

  // Uzmanlık ekle
  public function createSpecialty($specialtyName)
  {
    $sql = "INSERT INTO specialty (specialtyName) VALUES (:specialtyName)";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':specialtyName', $specialtyName, PDO::PARAM_STR);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }

  // Uzmanlık güncelle
  public function updateSpecialty($specialtyId, $specialtyName)
  {
    $sql = "UPDATE specialty SET specialtyName = :specialtyName WHERE specialtyId = :specialtyId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':specialtyName', $specialtyName, PDO::PARAM_STR);
      $stmt->bindParam(':specialtyId', $specialtyId, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }

  // Uzmanlık sil
  public function deleteSpecialty($specialtyId)
  {
    $sql = "DELETE FROM specialty WHERE specialtyId = :specialtyId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':specialtyId', $specialtyId, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }
}
