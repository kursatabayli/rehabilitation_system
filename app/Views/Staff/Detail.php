<?php
// Controllers/StaffController ve StaffSpecialtyController'ı include ediyoruz.
include "../../Controllers/StaffController.php";
include "../../Controllers/StaffSpecialtyController.php";
$title = "Personel Detay";

// staffId'yi GET isteği ile alıyoruz.
$staffId = isset($_GET['id']) ? (int) $_GET['id'] : null;

// Staff bilgilerini alıyoruz.
$staff = $staffModel->getStaffById($staffId);

// Staff uzmanlıklarını alıyoruz (JSON döndürecek bir kontrol olmadığından, PHP'de işliyoruz).
$staffSpecialties = $specialtyStaffModel->getSpecialtiesByStaffId($staffId);

// Staff ve uzmanlık bilgileri tanımlanmış mı diye kontrol ediyoruz.
if (!isset($staff) || !$staff) {
  echo "<div class='alert alert-danger mt-3'>Personel bilgileri alınamadı.</div>";
  exit;
}

// Sayfanın içeriğini oluşturuyoruz.
$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row justify-content-center'>
                <div class='col-xl-12'>
                    <div class='card mb-3'>
                        <div class='card-body'>
                            <div class='row'>
                                <!-- Sol Kolon: Kişisel Bilgiler ve Resim -->
                                <div class='col-md-6'>
                            <h5 class='card-title'><i class='fas fa-user'></i> Kişisel Bilgiler</h5>
                            <p class='card-text'><i class='fas fa-id-card'></i> <strong>Ad:</strong> " . htmlspecialchars($staff['name'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-id-badge'></i> <strong>Soyad:</strong> " . htmlspecialchars($staff['surname'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-address-card'></i> <strong>Kimlik Numarası:</strong> " . htmlspecialchars($staff['identityNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-phone'></i> <strong>Telefon Numarası:</strong> " . htmlspecialchars($staff['phoneNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-envelope'></i> <strong>E-posta:</strong> " . htmlspecialchars($staff['email'], ENT_QUOTES, 'UTF-8') . "</p>

                                    <!-- Personel Görüntüsü - Tıklanabilir -->
                                    <p class='card-text'>
                                        <i class='fas fa-image'></i> <strong>Personel Görüntüsü:</strong><br>
                                        <a href='#' id='viewImage' data-name='" . htmlspecialchars($staff['name'], ENT_QUOTES, 'UTF-8') . "' data-surname='" . htmlspecialchars($staff['surname'], ENT_QUOTES, 'UTF-8') . "'>
                                            <img src='" . htmlspecialchars($staff['staffImage'], ENT_QUOTES, 'UTF-8') . "' alt='Personel Resmi' class='vesikalik-img rounded-circle'>
                                        </a>
                                    </p>
                        </div>

                                <!-- Sağ Kolon: Mesleki Bilgiler -->
                                <div class='col-md-6'>
                            <h5 class='card-title'><i class='fas fa-briefcase'></i> Mesleki Bilgiler</h5>
                                    <p class='card-text'><i class='fas fa-user-md'></i> <strong>Meslek:</strong> " . htmlspecialchars($staff['professionName'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-id-badge'></i> <strong>Personel Numarası:</strong> " . htmlspecialchars($staff['personnelNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><i class='fas fa-file-medical'></i> <strong>Tıbbi Lisans Numarası:</strong> " . htmlspecialchars($staff['medicalLicenceNumber'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'><i class='fas fa-file-medical'></i> <strong>Uzmanlıklar:</strong>
                                        <ul>";

// Uzmanlıkları HTML içinde liste olarak dökelim.
if (!empty($staffSpecialties)) {
    foreach ($staffSpecialties as $specialty) {
        $content .= "<li>" . htmlspecialchars($specialty['specialtyName'], ENT_QUOTES, 'UTF-8') . "</li>";
    }
} else {
    $content .= "<li>Uzmanlık bilgisi bulunamadı.</li>";
}

$content .= "
                                        </ul>
                            </p>
                        </div>
                    </div>
                        </div>
                    </div>

                    <!-- Butonlar -->
                    <div class='text-center mt-4'>
                        <a href='Update.php?id=" . htmlspecialchars($staff['staffId'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-success'>Güncelle</a>
                        <a href='Index.php' class='btn btn-secondary'>Geri Dön</a>
                    </div>
                </div>
            </div>
        </div>
    </div>";

// Layout dosyasını include et.
include "../Shared/_Layout.php";
