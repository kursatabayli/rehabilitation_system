<?php
include_once __DIR__ . '/../Models/StaffSpecialtyModel.php';
include_once __DIR__ . '/../Models/SpecialtyModel.php';
include_once __DIR__ . '/../../config/database.php';

// Model sınıfları
$specialtyStaffModel = new StaffSpecialtyModel($pdo);
$specialtyModel = new SpecialtyModel($pdo);


// Uzmanlık ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['staffSpecialtyId'])) {
    $data = [
        ':staffId' => $_POST['staffId'],
        ':specialtyId' => $_POST['specialtyId']
    ];

    // Veritabanına ekleme yap
    $success = $specialtyStaffModel->addSpecialtyToStaff($data);

    $response = ['success' => $success, 'redirectUrl' => ''];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Personelin uzmanlıklarını getirme işlemi (AJAX çağrısı için JSON döndürme)
if (isset($_GET['id'])) {
    $staffId = (int) $_GET['id'];
    $specialties = $specialtyStaffModel->getSpecialtiesByStaffId($staffId);

    // Eğer AJAX isteği ise JSON döndürelim
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($specialties);
        exit;
    }
}

// Tüm uzmanlıkları listeleme işlemi (SpecialtyModel kullanımı)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['listAllSpecialties'])) {
    $allSpecialties = $specialtyModel->getAllSpecialties(); // Tüm uzmanlıkları getir

    // Eğer AJAX isteği ise JSON döndürelim
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($allSpecialties);
        exit;
    } else {
        // Normal GET isteği ise döndür
        return $allSpecialties;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['staffSpecialtyId'])) {
    $staffSpecialtyId = $_GET['staffSpecialtyId'];

    // Veritabanından silme işlemini gerçekleştir
    if ($specialtyStaffModel->deleteStaffSpecialty($staffSpecialtyId)) {
        echo json_encode(['success' => true, 'message' => 'Kayıt başarıyla silindi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Kayıt silinemedi.']);
    }
    exit;
}
