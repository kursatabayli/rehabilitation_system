<?php
// Controllers/StudentController.php
session_start();
include_once __DIR__ . '/../Models/StudentModel.php';
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../Models/StaffModel.php';  // StaffModel'ı dahil et

$studentModel = new StudentModel($pdo);
$staffModel = new StaffModel($pdo);

// Öğrencinin seans türlerini getirme işlemi (AJAX çağrısı için JSON döndürme)
if (isset($_GET['id'])) {
  $studentId = (int) $_GET['id'];
  $sessionTypes = $studentModel->getSessionTypesByStudentId($studentId);

  // Eğer AJAX isteği ise JSON döndürelim
  if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($sessionTypes);
    exit;
  }
}

// Durum Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['studentId'])) {
  $studentId = (int) $_POST['studentId'];

  // Mevcut tarihi al
  $currentDate = date('d.m.Y'); // Tarih formatı: Gün/Ay/Yıl

  // Mevcut statusUpdate'yi veritabanından al
  $currentStatus = $studentModel->getStudentById($studentId)['statusUpdate'] ?? '';

  // Oturumdan staffId'yi al
  $staffId = $_SESSION['_staffId'];

  // StaffModel ile staff bilgilerini al
  $staff = $staffModel->getStaffById($staffId);

  // Güncellemeyi yapan kişinin adı ve soyadı
  $staffName = htmlspecialchars($staff['name'], ENT_QUOTES, 'UTF-8');
  $staffSurname = htmlspecialchars($staff['surname'], ENT_QUOTES, 'UTF-8');

  // Eğer $currentStatus NULL veya boş değilse, mevcut durumu tarih ile birleştir
  if (!empty($currentStatus)) {
    // Mevcut durumu ve tarihi ekleyip birleştir
    $statusUpdate = trim($currentStatus) . "\n\n";
    $statusUpdate .= "Güncelleme Tarihi: $currentDate\n";
    $statusUpdate .= "Güncellemeyi Yapan Kişi: $staffName $staffSurname\n";
    $statusUpdate .= "Güncelleme: " . $_POST['statusUpdate'];
  } else {
    // Eğer mevcut durum NULL veya boş ise, sadece tarih ve yeni durumu ekle
    $statusUpdate = "Güncelleme Tarihi: $currentDate\n";
    $statusUpdate .= "Güncellemeyi Yapan Kişi: $staffName $staffSurname\n";
    $statusUpdate .= "Güncelleme: " . $_POST['statusUpdate'];
  }

  // Öğrenci güncelleme işlemi
  $success = $studentModel->updateStudentStatus($studentId, [
    ':statusUpdate' => $statusUpdate
  ]);

  // Cevap oluştur
  $response = [
    'success' => $success,
    'redirectUrl' => '../../Views/Session/Detail.php?studentId=' . $studentId
  ];

  // JSON formatında cevap gönder
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}
