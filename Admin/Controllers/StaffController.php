<?php
// Controllers/StaffController.php

include_once __DIR__ . '/../Models/StaffModel.php';
include_once __DIR__ . '/../Models/ProfessionModel.php';
include_once __DIR__ . '/../../config/database.php';

$staffModel = new StaffModel($pdo);
$professionModel = new ProfessionModel($pdo);


$staffList = $staffModel->getAllStaff();
$professions = $professionModel->getAllProfessions();

// Ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['staffId'])) {
  $data = [
    ':name' => $_POST['name'],
    ':surname' => $_POST['surname'],
    ':personnelNumber' => $_POST['personnelNumber'],
    ':medicalLicenceNumber' => $_POST['medicalLicenceNumber'],
    ':professionId' => $_POST['professionId'],
    ':identityNumber' => $_POST['identityNumber'],
    ':phoneNumber' => $_POST['phoneNumber'],
    ':email' => $_POST['email'],
    ':password' => $_POST['identityNumber'],
    ':gender' => $_POST['gender'],
    'dateOfRecruitment' => $_POST['dateOfRecruitment'],
  ];
  $success = $staffModel->createStaff($data);
  $response = ['success' => $success, 'redirectUrl' => '../../Views/Staff/Index.php'];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staffId'])) {
  $staffId = (int) $_POST['staffId'];
  $data = [
    ':name' => $_POST['name'],
    ':surname' => $_POST['surname'],
    ':personnelNumber' => $_POST['personnelNumber'],
    ':medicalLicenceNumber' => $_POST['medicalLicenceNumber'],
    ':professionId' => $_POST['professionId'],
    ':identityNumber' => $_POST['identityNumber'],
    ':phoneNumber' => $_POST['phoneNumber'],
    ':email' => $_POST['email'],
    ':password' => $_POST['password'],
    ':gender' => $_POST['gender'],
    'dateOfRecruitment' => $_POST['dateOfRecruitment'],
  ];
  $success = $staffModel->updateStaff($staffId, $data);
  $response = ['success' => $success, 'redirectUrl' => '../../Views/Staff/Index.php'];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
  $staffId = $_GET['id'];
  if ($staffModel->deleteStaff($staffId)) {
    echo json_encode(['success' => true, 'message' => 'Kayıt başarıyla silindi.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Kayıt silinemedi.']);
  }
  exit;
}
