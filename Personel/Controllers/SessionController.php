<?php
// Controllers/SessionController.php

include_once __DIR__ . '/../Models/SessionModel.php';
include_once __DIR__ . '/../../config/database.php';

$sessionModel = new SessionModel($pdo);

// Gün seans saatlerini alıyoruz
if (isset($_GET['dayId'])) {
    $dayId = (int) $_GET['dayId'];

    // Seans saatlerini alıyoruz
    $sessionTimes = $sessionModel->getSessionTimesByDay($dayId);

    // Seansları zaman dilimlerine göre alıyoruz
    $sessionsByTime = [];
    foreach ($sessionTimes as $time) {
        $sessionsByTime[] = [
            'time' => $time,
            'sessions' => $sessionModel->getSessionsByDayAndTime($dayId, $time['sessionStartTime'], $time['sessionEndTime'])
        ];
    }

    // JSON formatında dönüyoruz
    header('Content-Type: application/json');
    echo json_encode($sessionsByTime);
    exit;
}
