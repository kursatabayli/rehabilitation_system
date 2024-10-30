<?php
// Models/SessionModel.php

class SessionModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Seans saatlerini günlere göre alıyoruz
    public function getSessionTimesByDay($dayId)
    {
        $sql = "
            SELECT DISTINCT sessionStartTime, sessionEndTime 
            FROM sessions 
            WHERE dayId = :dayId 
            ORDER BY sessionStartTime ASC";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':dayId', $dayId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return [];
        }
    }

    // Personel ve öğrenci seanslarını saatlere göre alıyoruz
    public function getSessionsByDayAndTime($dayId, $startTime, $endTime)
    {
        $sql = "
            SELECT s.sessionId, stf.name AS staffName, stf.surname AS staffSurname, 
                   std.name AS studentName, std.surname AS studentSurname, 
                   st.sessionType 
            FROM sessions s
            JOIN staff stf ON s.staffId = stf.staffId
            JOIN student std ON s.studentId = std.studentId
            LEFT JOIN sessiontypes st ON s.sessionTypeId = st.sessionTypeId
            WHERE s.dayId = :dayId 
            AND s.sessionStartTime = :startTime 
            AND s.sessionEndTime = :endTime
            ORDER BY s.sessionStartTime ASC";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':dayId', $dayId, PDO::PARAM_INT);
            $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
            $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return [];
        }
    }

    // Yeni bir seans ekle
    public function createSession($data)
    {
        $sql = "
            INSERT INTO sessions (staffId, studentId, sessionTypeId, sessionStartTime, sessionEndTime, dayId) 
            VALUES (:staffId, :studentId, :sessionTypeId, :sessionStartTime, :sessionEndTime, :dayId)
        ";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }


    // Seansı sil
    public function deleteSession($sessionId)
    {
        $sql = "DELETE FROM sessions WHERE sessionId = :sessionId";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }

    // Belirli bir seansı ID ile al
    public function getSessionById($sessionId)
    {
        $sql = "SELECT * FROM sessions WHERE sessionId = :sessionId";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return null;
        }
    }

    // Seansı güncelle
    public function updateSession($data)
    {
        $sql = "
            UPDATE sessions 
            SET staffId = :staffId, studentId = :studentId, sessionTypeId = :sessionTypeId, 
                sessionStartTime = :sessionStartTime, sessionEndTime = :sessionEndTime, dayId = :dayId
            WHERE sessionId = :sessionId
        ";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Veritabanı hatası: " . $e->getMessage());
            return false;
        }
    }
}