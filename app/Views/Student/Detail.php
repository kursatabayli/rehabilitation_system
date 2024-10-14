<?php
include "../../Controllers/StudentController.php";
$title = "Öğrenci Detay";

$studentId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$student = $studentModel->getStudentById($studentId);

if (!$student) {
    echo "<div class='alert alert-danger mt-3'>Öğrenci bilgileri alınamadı.</div>";
    exit;
}

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row justify-content-center'>
                <div class='col-xl-12'>

                    <!-- Öğrenci Bilgileri Kartı -->
                    <div class='card mt-4'>
                        <div class='card-body'>
                            <div class='row'>
                                <!-- Öğrenci Resmi - Tıklanabilir -->
                                <div class='col-md-3 text-center'>
                                    <a href='#' id='viewImage' data-name='" . htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') . "' data-surname='" . htmlspecialchars($student['surname'], ENT_QUOTES, 'UTF-8') . "'>
                                        <img src='" . htmlspecialchars($student['studentImage'], ENT_QUOTES, 'UTF-8') . "' alt='Öğrenci Resmi' class='vesikalik-img rounded-circle'>
                                    </a>
                                </div>

                                <!-- Öğrenci Bilgileri -->
                                <div class='col-md-9'>
                                    <h4 class='card-title'>Öğrenci Bilgileri</h4>
                                    <p class='card-text'><i class='fas fa-id-card'></i> <strong>Ad:</strong> " . htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'><i class='fas fa-id-badge'></i> <strong>Soyad:</strong> " . htmlspecialchars($student['surname'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'><i class='fas fa-address-card'></i> <strong>Kimlik Numarası:</strong> " . htmlspecialchars($student['identityNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'><i class='fas fa-calendar'></i> <strong>Doğum Tarihi:</strong> " . date('d/m/Y', strtotime($student['birthDate'])) . "</p>
                                    <p class='card-text'><i class='fas fa-file-medical'></i> <strong>Rapor Numarası:</strong> " . htmlspecialchars($student['aegrotatNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'><i class='fas fa-calendar-check'></i> <strong>Rapor Geçerlilik Tarihi:</strong> " . date('d/m/Y', strtotime($student['aegrotatValidityDate'])) . "</p>
                                    <p class='card-text'><i class='fas fa-calendar-alt'></i> <strong>Aylık Seans Sayısı:</strong> " . htmlspecialchars($student['monthlySessions'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'><i class='fas fa-user-check'></i> <strong>Durum:</strong> " . ($student['isActive'] == 1 ? 'Aktif' : 'Pasif') . "</p>
                                    <p class='card-text'><i class='fas fa-notes-medical'></i> <strong>Detaylı Sağlık Durumu:</strong> <br><span>" . nl2br(htmlspecialchars($student['medicalCondition'], ENT_QUOTES, 'UTF-8')) . "</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Veli Bilgileri Kartı -->
                    <div class='card mt-4'>
                        <div class='card-body'>
                            <h4 class='card-title clickable-header'>
                                Veli Bilgileri
                                <i class='fas fa-chevron-up rotate-animation rotate-down'></i>
                            </h4>
                            <div class='table-container'>
                                <p class='card-text'><i class='fas fa-user'></i> <strong>Veli Adı Soyadı:</strong> " . htmlspecialchars($student['parentNameSurname'], ENT_QUOTES, 'UTF-8') . "</p>
                                <p class='card-text'><i class='fas fa-phone'></i> <strong>Veli Telefon Numarası:</strong> " . htmlspecialchars($student['parentPhoneNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                                <p class='card-text'><i class='fas fa-home'></i> <strong>Veli Adresi:</strong> " . htmlspecialchars($student['parentAddress'], ENT_QUOTES, 'UTF-8') . "</p>
                                <p class='card-text'><i class='fas fa-id-card'></i> <strong>Veli Kimlik Numarası:</strong> " . htmlspecialchars($student['parentIdentificationNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                            </div>
                        </div>
                    </div>

                    <!-- Butonlar -->
                    <div class='text-center mt-4 mb-2'>
                        <a href='Index.php' class='btn btn-secondary'>Geri Dön</a>
                    </div>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
