<?php
include_once __DIR__ . '/../Models/StudentSessionTypeModel.php';
include_once __DIR__ . '/../Models/SessionTypeModel.php';
include_once __DIR__ . '/../../config/database.php';

// Model sınıfları
$studentSessionTypeModel = new StudentSessionTypeModel($pdo);
$sessionTypeModel = new SessionTypeModel($pdo);

// Seans türü ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['studentSessionTypeId'])) {
    $data = [
        ':studentId' => $_POST['studentId'],
        ':sessionTypeId' => $_POST['sessionTypeId'],
        ':monthlySessionNumber' => $_POST['monthlySessionNumber']
    ];

    // Veritabanına ekleme yap
    $success = $studentSessionTypeModel->addSessionTypeToStudent($data);

    $response = ['success' => $success, 'redirectUrl' => ''];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Öğrencinin seans türlerini getirme işlemi (AJAX çağrısı için JSON döndürme)
if (isset($_GET['id'])) {
    $studentId = (int) $_GET['id'];
    $sessionTypes = $studentSessionTypeModel->getSessionTypesByStudentId($studentId);

    // Eğer AJAX isteği ise JSON döndürelim
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($sessionTypes);
        exit;
    }
}

// Tüm seans türlerini listeleme işlemi (SessionTypeModel kullanımı)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['listAllSessionTypes'])) {
    $allSessionTypes = $sessionTypeModel->getAllSessionTypes(); // Tüm seans türlerini getir

    // Eğer AJAX isteği ise JSON döndürelim
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($allSessionTypes);
        exit;
    } else {
        // Normal GET isteği ise döndür
        return $allSessionTypes;
    }
}

// Seans türü silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['studentSessionTypeId'])) {
    $studentSessionTypeId = $_GET['studentSessionTypeId'];

    // Veritabanından silme işlemini gerçekleştir
    if ($studentSessionTypeModel->deleteStudentSessionType($studentSessionTypeId)) {
        echo json_encode(['success' => true, 'message' => 'Kayıt başarıyla silindi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Kayıt silinemedi.']);
    }
    exit;
}
