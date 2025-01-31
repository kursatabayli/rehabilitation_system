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


// Seans ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['sessionId'])) {

    $sessionTypeId = isset($_POST['sessionTypeId']) && !empty($_POST['sessionTypeId']) ? $_POST['sessionTypeId'] : null;

    $data = [
        ':staffId' => $_POST['staffId'],
        ':studentId' => $_POST['studentId'],
        ':sessionTypeId' => $sessionTypeId,
        ':sessionStartTime' => $_POST['sessionStartTime'],
        ':sessionEndTime' => $_POST['sessionEndTime'],
        ':dayId' => $_POST['dayId']
    ];

    $success = $sessionModel->createSession($data);

    // dayId'yi redirect URL'ye ekliyoruz
    $redirectUrl = '../../Views/Session/Index.php?dayId=' . $_POST['dayId'];
    $response = ['success' => $success, 'redirectUrl' => $redirectUrl];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sessionId'])) {
    $sessionId = (int) $_POST['sessionId'];

    $sessionTypeId = isset($_POST['sessionTypeId']) && !empty($_POST['sessionTypeId']) ? $_POST['sessionTypeId'] : null;

    $data = [
        ':staffId' => $_POST['staffId'],
        ':studentId' => $_POST['studentId'],
        ':sessionTypeId' => $sessionTypeId,
        ':sessionStartTime' => $_POST['sessionStartTime'],
        ':sessionEndTime' => $_POST['sessionEndTime'],
        ':dayId' => $_POST['dayId'],
        ':sessionId' => $sessionId
    ];

    $success = $sessionModel->updateSession($data);

    // dayId'yi redirect URL'ye ekliyoruz
    $redirectUrl = '../../Views/Session/Index.php?dayId=' . $_POST['dayId'];
    $response = ['success' => $success, 'redirectUrl' => $redirectUrl];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


// Seans silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['sessionId'])) {
    $sessionId = intval($_GET['sessionId']); // sessionId'yi güvenli bir şekilde tamsayıya çevirme

    // Silmeden önce dayId bilgisini alıyoruz
    $session = $sessionModel->getSessionById($sessionId);
    $dayId = $session ? $session['dayId'] : 1; // dayId bulunamazsa varsayılan olarak Pazartesi (1) atanır

    // Seansı silme işlemini gerçekleştir
    $success = $sessionModel->deleteSession($sessionId);

    // Silme işlemi başarılıysa yönlendirme yapacağız
    $response = [
        'success' => $success,
        'redirectUrl' => '../../Views/Session/Index.php?dayId=' . $dayId
    ];

    // JSON yanıtını döndür
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
