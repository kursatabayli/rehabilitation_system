<?php

class StudentSessionTypeModel
{
    private $pdo;

    // PDO nesnesi ile sınıfı başlat
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
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


    // Öğrenciye seans türü ekle
    public function addSessionTypeToStudent($data)
    {
        $sql = "INSERT INTO studentsessiontype (studentId, sessionTypeId, monthlySessionNumber) VALUES (:studentId, :sessionTypeId, :monthlySessionNumber)";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }

    // studentSessionTypeId kullanarak seans türünü sil
    public function deleteStudentSessionType($studentSessionTypeId)
    {
        $sql = "DELETE FROM studentsessiontype WHERE studentSessionTypeId = :studentSessionTypeId";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':studentSessionTypeId', $studentSessionTypeId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }

}
