<?php
// Controllers/StaffController.php

include_once __DIR__ . '/../Models/StaffModel.php';
include_once __DIR__ . '/../../config/database.php';

$staffModel = new StaffModel($pdo);
$specialtyStaffModel = new StaffModel($pdo);

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
