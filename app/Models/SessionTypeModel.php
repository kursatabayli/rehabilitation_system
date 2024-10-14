<?php
// Models/SessionTypeModel.php

class SessionTypeModel
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  // Tüm Seans türlerini getir
  public function getAllSessionTypes()
  {
    $sql = "SELECT * FROM sessiontypes";
    try {
      $stmt = $this->pdo->query($sql);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return [];
    }
  }

  // Tek bir seans türünü Id'sine göre getir
  public function getSessionTypeById($sessionTypeId)
  {
    $sql = "SELECT * FROM sessiontypes WHERE sessionTypeId = :sessionTypeId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':sessionTypeId', $sessionTypeId, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return null;
    }
  }

  // Yeni Seans türü ekle
  public function createSessionType($sessionType)
  {
    $sql = "INSERT INTO sessiontypes (sessionType) VALUES (:sessionType)";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':sessionType', $sessionType, PDO::PARAM_STR);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }

  // Seans türünü güncelle
  public function updateSessionType($sessionTypeId, $sessionType)
  {
    $sql = "UPDATE sessiontypes SET sessionType = :sessionType WHERE sessionTypeId = :sessionTypeId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':sessionType', $sessionType, PDO::PARAM_STR);
      $stmt->bindParam(':sessionTypeId', $sessionTypeId, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }

  // Seans türünü sil
  public function deleteSessionType($sessionTypeId)
  {
    $sql = "DELETE FROM sessiontypes WHERE sessionTypeId = :sessionTypeId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':sessionTypeId', $sessionTypeId, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }
}
