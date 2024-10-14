<?php
// Controllers/ProfessionController.php

include_once __DIR__ . '/../Models/ProfessionModel.php';
include_once __DIR__ . '/../../config/database.php';

$professionModel = new ProfessionModel($pdo);

// Meslekleri listeleme
$professions = $professionModel->getAllProfessions();

// Ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['professionName']) && !isset($_POST['professionId'])) {
  $professionName = trim($_POST['professionName']);
  $success = $professionModel->createProfession($professionName);
  $response = [
    'success' => $success,
    'redirectUrl' => '../../Views/Profession/Index.php'
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['professionId']) && isset($_POST['professionName'])) {
  $professionId = (int)$_POST['professionId'];
  $professionName = trim($_POST['professionName']);
  $success = $professionModel->updateProfession($professionId, $professionName);
  $response = [
    'success' => $success,
    'redirectUrl' => '../../Views/Profession/Index.php'
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
  $professionId = $_GET['id'];
  if ($professionModel->deleteProfession($professionId)) {
    echo json_encode(['success' => true, 'message' => 'Kayıt başarıyla silindi.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Kayıt silinemedi.']);
  }
  exit;
}
