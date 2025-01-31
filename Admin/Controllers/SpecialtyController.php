<?php
// Controllers/SpecialtyController.php

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../Models/SpecialtyModel.php';

$specialtyModel = new SpecialtyModel($pdo);

// Uzmanlıkları listeleme
$specialties = $specialtyModel->getAllSpecialties();

// Ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['specialtyName']) && !isset($_POST['specialtyId'])) {
  $specialtyName = trim($_POST['specialtyName']);
  $success = $specialtyModel->createSpecialty($specialtyName);
  $response = [
    'success' => $success,
    'redirectUrl' => '../../Views/Specialty/Index.php'
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['specialtyId']) && isset($_POST['specialtyName'])) {
  $specialtyId = (int)$_POST['specialtyId'];
  $specialtyName = trim($_POST['specialtyName']);
  $success = $specialtyModel->updateSpecialty($specialtyId, $specialtyName);
  $response = [
    'success' => $success,
    'redirectUrl' => '../../Views/Specialty/Index.php'
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
  $specialtyId = $_GET['id'];
  if ($specialtyModel->deleteSpecialty($specialtyId)) {
    echo json_encode(['success' => true, 'message' => 'Kayıt başarıyla silindi.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Kayıt silinemedi.']);
  }
  exit;
}
