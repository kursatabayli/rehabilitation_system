<?php
include "../../Controllers/StaffController.php";
$title = "Personel Detay";

$staffId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$staff = $staffModel->getStaffById($staffId);

if (!$staff) {
  echo "<div class='alert alert-danger mt-3'>Personel bilgileri alınamadı.</div>";
  exit;
}

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row justify-content-center'>
                <div class='col-md-8'>
                    <div class='card mb-3'>
                        <div class='card-body'>
                            <h5 class='card-title'><i class='fas fa-user'></i> Kişisel Bilgiler</h5>
                            <p class='card-text'><i class='fas fa-id-card'></i> <strong>Ad:</strong> " . htmlspecialchars($staff['name'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-id-badge'></i> <strong>Soyad:</strong> " . htmlspecialchars($staff['surname'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-address-card'></i> <strong>Kimlik Numarası:</strong> " . htmlspecialchars($staff['identityNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-phone'></i> <strong>Telefon Numarası:</strong> " . htmlspecialchars($staff['phoneNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-envelope'></i> <strong>E-posta:</strong> " . htmlspecialchars($staff['email'], ENT_QUOTES, 'UTF-8') . "</p>
                        </div>
                    </div>
                    <div class='card mb-3'>
                        <div class='card-body'>
                            <h5 class='card-title'><i class='fas fa-briefcase'></i> Mesleki Bilgiler</h5>
                            <p class='card-text'><i class='fas fa-user-md'></i> <strong>Meslek:</strong> " . htmlspecialchars($professionName, ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-id-badge'></i> <strong>Personel Numarası:</strong> " . htmlspecialchars($staff['personnelNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-file-medical'></i> <strong>Tıbbi Lisans Numarası:</strong> " . htmlspecialchars($staff['medicalLicenceNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'>
                                <i class='fas fa-image'></i> <strong>Personel Görüntüsü:</strong><br>
                                <img  class='vesikalik-img' src='" . htmlspecialchars($staff['staffImage'], ENT_QUOTES, 'UTF-8') . "' alt='Personel Görüntüsü'>
                            </p>
                        </div>
                    </div>
                    <div class='text-center'>
                        <a href='Update.php?id={$staff['staffId']}' class='btn btn-success'>Güncelle</a>
                        <a href='Index.php' class='btn btn-secondary'>Geri Dön</a>
                    </div>
                </div>
            </div>
        </div>
    </div>";


include "../Shared/_Layout.php";
