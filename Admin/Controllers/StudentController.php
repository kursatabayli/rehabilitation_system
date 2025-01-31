<?php
// Controllers/StudentController.php

include_once __DIR__ . '/../Models/StudentModel.php';
include_once __DIR__ . '/../../config/database.php';

$studentModel = new StudentModel($pdo);

// Tüm öğrencileri listeleme
$students = $studentModel->getAllStudents();

// Ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['studentId'])) {
    $data = [
        ':name' => $_POST['name'],
        ':surname' => $_POST['surname'],
        ':identityNumber' => $_POST['identityNumber'],
        ':birthDate' => $_POST['birthDate'],
        ':parentNameSurname' => $_POST['parentNameSurname'],
        ':parentPhoneNumber' => $_POST['parentPhoneNumber'],
        ':parentAddress' => $_POST['parentAddress'],
        ':parentIdentificationNumber' => $_POST['parentIdentificationNumber'],
        ':medicalCondition' => $_POST['medicalCondition'],
        ':aegrotatNumber' => $_POST['aegrotatNumber'],
        ':aegrotatValidityDate' => $_POST['aegrotatValidityDate'],
        ':monthlySessions' => $_POST['monthlySessions'],
        ':isActive' => $_POST['isActive'],
        ':gender' => $_POST['gender'],
        'dateOfRecord' => $_POST['dateOfRecord']
    ];
    $success = $studentModel->createStudent($data);
    $response = ['success' => $success, 'redirectUrl' => '../../Views/Student/Index.php'];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['studentId'])) {
    $studentId = (int) $_POST['studentId'];

    // Öğrencinin mevcut bilgilerini al
    $currentStudent = $studentModel->getStudentById($studentId);

    // dateOfInactivity yalnızca aktiflik durumu değişiyorsa güncellenir
    $dateOfInactivity = null;
    if ($_POST['isActive'] == 0 && $currentStudent['isActive'] == 1) {
        $dateOfInactivity = date('Y-m-d');
    } elseif ($_POST['isActive'] == 1) {
        $dateOfInactivity = null; // Aktif yapıldığında inaktiflik tarihi sıfırlanır
    } else {
        $dateOfInactivity = $currentStudent['dateOfInactivity']; // Durum değişmezse eski değer korunur
    }

    // Güncellenen verileri hazırlayın
    $data = [
        ':name' => $_POST['name'],
        ':surname' => $_POST['surname'],
        ':identityNumber' => $_POST['identityNumber'],
        ':birthDate' => $_POST['birthDate'],
        ':parentNameSurname' => $_POST['parentNameSurname'],
        ':parentPhoneNumber' => $_POST['parentPhoneNumber'],
        ':parentAddress' => $_POST['parentAddress'],
        ':parentIdentificationNumber' => $_POST['parentIdentificationNumber'],
        ':medicalCondition' => $_POST['medicalCondition'],
        ':aegrotatNumber' => $_POST['aegrotatNumber'],
        ':aegrotatValidityDate' => $_POST['aegrotatValidityDate'],
        ':monthlySessions' => $_POST['monthlySessions'],
        ':isActive' => $_POST['isActive'],
        ':gender' => $_POST['gender'],
        ':dateOfInactivity' => $dateOfInactivity,
        'dateOfRecord' => $_POST['dateOfRecord']
    ];

    // Güncelleme işlemi
    $success = $studentModel->updateStudent($studentId, $data);
    $response = ['success' => $success, 'redirectUrl' => '../../Views/Student/Index.php'];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $studentId = $_GET['id'];
    $success = $studentModel->deleteStudent($studentId);
    $response = ['success' => $success, 'redirectUrl' => '../../Views/Student/Index.php'];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
