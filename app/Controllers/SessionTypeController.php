<?php
// Controllers/SessionTypeController.php

include_once __DIR__ . '/../Models/SessionTypeModel.php';
include_once __DIR__ . '/../../config/database.php';

$sessionTypeModel = new SessionTypeModel($pdo);

// Oturum türlerini listeleme
$sessionTypes = $sessionTypeModel->getAllSessionTypes();

// Ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sessionType']) && !isset($_POST['sessionTypeId'])) {
  $sessionType = trim($_POST['sessionType']);
  $success = $sessionTypeModel->createSessionType($sessionType);
  $response = [
    'success' => $success,
    'redirectUrl' => '../../Views/SessionType/Index.php'
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sessionTypeId']) && isset($_POST['sessionType'])) {
  $sessionTypeId = (int)$_POST['sessionTypeId'];
  $sessionType = trim($_POST['sessionType']);
  $success = $sessionTypeModel->updateSessionType($sessionTypeId, $sessionType);
  $response = [
    'success' => $success,
    'redirectUrl' => '../../Views/SessionType/Index.php'
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
  $sessionTypeId = $_GET['id'];
  if ($sessionTypeModel->deleteSessionType($sessionTypeId)) {
    echo json_encode(['success' => true, 'message' => 'Kayıt başarıyla silindi.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Kayıt silinemedi.']);
  }
  exit;
}
