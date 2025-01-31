<?php
// Models/StudentModel.php

class StudentModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
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


    // Öğrenci durumu güncelleme
    public function updateStudentStatus($studentId, $data)
    {
        $sql = "UPDATE student SET statusUpdate = :statusUpdate WHERE studentId = :studentId";
        try {
            $stmt = $this->pdo->prepare($sql);
            $data[':studentId'] = $studentId; // Bind parametre ekleniyor
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }


    // Öğrencinin seans türlerini getir
    public function getSessionTypesByStudentId($studentId)
    {
        $sql = "
            SELECT sst.studentSessionTypeId, st.sessionTypeId, st.sessionType, sst.monthlySessionNumber
            FROM studentsessiontype sst
            INNER JOIN sessiontypes st ON sst.sessionTypeId = st.sessionTypeId
            WHERE sst.studentId = :studentId
        ";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return [];
        }
    }
}
