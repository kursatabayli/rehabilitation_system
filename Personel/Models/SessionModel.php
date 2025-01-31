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
        SELECT s.sessionId, stf.staffId, stf.name AS staffName, stf.surname AS staffSurname, 
        std.studentId,std.name AS studentName, std.surname AS studentSurname, st.sessionType 
        FROM sessions s
        JOIN staff stf ON s.staffId = stf.staffId
        JOIN student std ON s.studentId = std.studentId
        LEFT JOIN sessiontypes st ON s.sessionTypeId = st.sessionTypeId
        WHERE s.dayId = :dayId 
        AND s.sessionStartTime = :startTime 
        AND s.sessionEndTime = :endTime";

        $sql .= " ORDER BY s.sessionStartTime ASC";

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
}
