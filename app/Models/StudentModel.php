<?php
// Models/StudentModel.php

class StudentModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Tüm öğrencileri getir
    public function getAllStudents()
    {
        $sql = "SELECT * FROM student";
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return [];
        }
    }

    // Tek bir öğrenci kaydı getir
    public function getStudentById($studentId)
    {
        $sql = "SELECT * FROM student WHERE studentId = :studentId";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return null;
        }
    }

    // Yeni bir öğrenci ekle
    public function createStudent($data)
    {
        $sql = "
      INSERT INTO student (name, surname, identityNumber, birthDate, parentNameSurname, parentPhoneNumber, parentAddress, parentIdentificationNumber, medicalCondition, aegrotatNumber, aegrotatValidityDate, monthlySessions, studentImage, isActive)
      VALUES (:name, :surname, :identityNumber, :birthDate, :parentNameSurname, :parentPhoneNumber, :parentAddress, :parentIdentificationNumber, :medicalCondition, :aegrotatNumber, :aegrotatValidityDate, :monthlySessions, :studentImage, :isActive)
    ";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }

    // Öğrenci güncelle
    public function updateStudent($studentId, $data)
    {
        $sql = "
      UPDATE student SET name = :name, surname = :surname, identityNumber = :identityNumber, birthDate = :birthDate,
      parentNameSurname = :parentNameSurname, parentPhoneNumber = :parentPhoneNumber, parentAddress = :parentAddress, parentIdentificationNumber = :parentIdentificationNumber, 
      medicalCondition = :medicalCondition, aegrotatNumber = :aegrotatNumber, aegrotatValidityDate = :aegrotatValidityDate, monthlySessions = :monthlySessions, studentImage = :studentImage, isActive = :isActive
      WHERE studentId = :studentId
    ";
        try {
            $stmt = $this->pdo->prepare($sql);
            $data['studentId'] = $studentId;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }

    // Öğrenci kaydını sil
    public function deleteStudent($studentId)
    {
        $sql = "DELETE FROM student WHERE studentId = :studentId";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }
}
