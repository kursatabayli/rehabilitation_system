<?php
include "../../Controllers/StaffController.php";
include "../../Controllers/StaffSpecialtyController.php";  // Controller include ediliyor

$title = "Personel Uzmanlıkları";

// Veritabanı modelini başlat
$staffModel = new StaffModel($pdo);
$specialtyModel = new SpecialtyModel($pdo);
$staffSpecialtyModel = new StaffSpecialtyModel($pdo);

// Staff ID kontrolü
$staffId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$staff = $staffModel->getStaffById($staffId);

if (!$staff) {
    die("Personel bulunamadı.");
}

// Tüm uzmanlıkları getir
$allSpecialties = $specialtyModel->getAllSpecialties();

// Personelin mevcut uzmanlıklarını getir
$staffSpecialties = $staffSpecialtyModel->getSpecialtiesByStaffId($staffId);

// Mevcut uzmanlıkların ID'lerini bir diziye alıyoruz
$existingSpecialtyIds = array_column($staffSpecialties, 'specialtyId');

// Sayfa içeriği oluşturuluyor
$content = "
<div class='page-content'>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xl-12'>
                <h4 class='card-title'>Personel Uzmanlıkları - " . htmlspecialchars($staff['name'] . ' ' . $staff['surname'], ENT_QUOTES, 'UTF-8') . "</h4>
                <p class='card-subtitle mb-4'>Personelin mevcut uzmanlıklarını ve yeni uzmanlık ekleme seçeneklerini görüntüleyin.</p>

                <!-- Seçilen Uzmanlıklar (Mevcut Uzmanlıklar) -->
                <div class='form-group'>
                    <label>Mevcut Uzmanlıklar</label>
                    <ul class='list-group list-group-flush'>";

// Mevcut uzmanlıkları listede göster
if (!empty($staffSpecialties)) {
    foreach ($staffSpecialties as $staffSpecialty) {
        $content .= "
        <li class='list-group-item d-flex justify-content-between align-items-center'>
            " . htmlspecialchars($staffSpecialty['specialtyName'], ENT_QUOTES, 'UTF-8') . "
            <button data-url='../../Controllers/StaffSpecialtyController.php?staffSpecialtyId=" . htmlspecialchars($staffSpecialty['staffSpecialtyId'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-danger btn-sm btn-delete'>
                <i class='fas fa-trash-alt'></i> Sil
            </button>
        </li>";
    }
} else {
    $content .= "
        <li class='list-group-item'>
            Personelin şu anda uzmanlığı bulunmuyor.
        </li>";
}

$content .= "
                    </ul>
                </div>

                <!-- Uzmanlık Ekleme Formu (Dropdown seçim) -->
                <div class='form-group mt-4'>
                    <form id='specialtyForm' action='../../Controllers/StaffSpecialtyController.php' method='post'>
                        <input type='hidden' name='staffId' value='" . htmlspecialchars($staffId, ENT_QUOTES, 'UTF-8') . "'>";

// Uzmanlık eklenebilecek uzmanlıklar var mı kontrol ediyoruz
$hasSpecialtiesToAdd = false;
foreach ($allSpecialties as $specialty) {
    if (!in_array($specialty['specialtyId'], $existingSpecialtyIds)) {
        $hasSpecialtiesToAdd = true;
        break; // Eğer eklenebilecek en az bir uzmanlık varsa kontrolü durduruyoruz.
    }
}

// Eğer eklenebilecek uzmanlık yoksa sadece "Geri Dön" butonunu gösteriyoruz
if ($hasSpecialtiesToAdd) {
    $content .= "
                        <!-- Uzmanlık Dropdown -->
                        <label for='specialtyDropdown'>Eklenebilecek Uzmanlıklar</label>
                        <select id='specialtyDropdown' class='form-control' name='specialtyId'>
                            <option value=''>Bir uzmanlık seçin</option>";

    // Sadece personelin halihazırda sahip olmadığı uzmanlıkları listele ve dropdown yapısına çevir
    foreach ($allSpecialties as $specialty) {
        if (!in_array($specialty['specialtyId'], $existingSpecialtyIds)) {
            $content .= "<option value='" . htmlspecialchars($specialty['specialtyId'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($specialty['specialtyName'], ENT_QUOTES, 'UTF-8') . "</option>";
        }
    }

    $content .= "
                        </select>
                        <button type='submit' class='btn btn-primary mt-3'>Uzmanlık Ekle</button>";
}

// Her durumda "Geri Dön" butonu gösterilecek
$content .= "
                        <a href='Index.php' class='btn btn-secondary mt-3'>Geri Dön</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>";

include "../Shared/_Layout.php";