<?php
// Models/ProfessionModel.php

class ProfessionModel
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  // Tüm meslekleri getir
  public function getAllProfessions()
  {
    $sql = "SELECT * FROM profession";
    try {
      $stmt = $this->pdo->query($sql);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return [];
    }
  }

  // Tek bir mesleği Id'sine göre getir
  public function getProfessionById($professionId)
  {
    $sql = "SELECT * FROM profession WHERE professionId = :professionId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':professionId', $professionId, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return null;
    }
  }

  // Yeni meslek ekle
  public function createProfession($professionName)
  {
    $sql = "INSERT INTO profession (professionName) VALUES (:professionName)";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':professionName', $professionName, PDO::PARAM_STR);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }

  // Meslek güncelle
  public function updateProfession($professionId, $professionName)
  {
    $sql = "UPDATE profession SET professionName = :professionName WHERE professionId = :professionId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':professionName', $professionName, PDO::PARAM_STR);
      $stmt->bindParam(':professionId', $professionId, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }

  // Meslek sil
  public function deleteProfession($professionId)
  {
    $sql = "DELETE FROM profession WHERE professionId = :professionId";
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':professionId', $professionId, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Veritabanı hatası: " . $e->getMessage());
      return false;
    }
  }
}
