<?php
include "../../Controllers/StaffController.php";
$title = "Personel Güncelle";

$staffId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$staff = $staffModel->getStaffById($staffId);
$professions = $professionModel->getAllProfessions();

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Personel Güncelle</h4>
                    <p class='card-subtitle mb-4'>Personel bilgilerini güncelleyin.</p>
                    <form class='input-sm' data-action-type='update' action='../../Controllers/StaffController.php' method='post' enctype='multipart/form-data'>
                        <input type='hidden' name='staffId' value='{$staff['staffId']}'>
                        <div class='form-group mb-4'>
                            <label for='name'>Ad</label>
                            <input type='text' class='form-control' id='name' name='name' value='" . htmlspecialchars($staff['name'], ENT_QUOTES, 'UTF-8') . "' required>
                        </div>
                        <div class='form-group mb-4'>
                            <label for='surname'>Soyad</label>
                            <input type='text' class='form-control' id='surname' name='surname' value='" . htmlspecialchars($staff['surname'], ENT_QUOTES, 'UTF-8') . "' required>
                        </div>
                        <div class='form-group mb-4'>
                            <label for='professionId'>Meslek</label>
                            <select class='form-control' id='professionId' name='professionId' required>";
                            foreach ($professions as $profession) {
                                $selected = $staff['professionId'] == $profession['professionId'] ? "selected" : "";
                                $content .= "<option value='{$profession['professionId']}' {$selected}>" . htmlspecialchars($profession['professionName']) . "</option>";
                            }
$content .= "
                            </select>
                        </div>
                        <div class='form-group mb-4'>
                            <label for='personnelNumber'>Personel Numarası</label>
                            <input type='text' class='form-control' id='personnelNumber' name='personnelNumber' value='" . htmlspecialchars($staff['personnelNumber'], ENT_QUOTES, 'UTF-8') . "' required>
                        </div>
                        <div class='form-group mb-4'>
                            <label for='medicalLicenceNumber'>Tıbbi Lisans Numarası</label>
                            <input type='text' class='form-control' id='medicalLicenceNumber' name='medicalLicenceNumber' value='" . htmlspecialchars($staff['medicalLicenceNumber'], ENT_QUOTES, 'UTF-8') . "'>
                        </div>
                        <div class='form-group mb-4'>
                            <label for='identityNumber'>Kimlik Numarası</label>
                            <input type='text' class='form-control' id='identityNumber' name='identityNumber' value='" . htmlspecialchars($staff['identityNumber'], ENT_QUOTES, 'UTF-8') . "' required>
                        </div>
                        <div class='form-group mb-4'>
                            <label for='phoneNumber'>Telefon Numarası</label>
                            <input type='text' class='form-control' id='phoneNumber' name='phoneNumber' value='" . htmlspecialchars($staff['phoneNumber'], ENT_QUOTES, 'UTF-8') . "'>
                        </div>
                        <div class='form-group mb-4'>
                            <label for='email'>E-posta</label>
                            <input type='email' class='form-control' id='email' name='email' value='" . htmlspecialchars($staff['email'], ENT_QUOTES, 'UTF-8') . "'>
                        </div>
                        <div class='form-group mb-4'>
                            <label for='staffImage'>Personel Görüntüsü</label>
                            <div class='custom-file'>
                                <input type='file' class='custom-file-input' id='staffImage' name='staffImage' accept='image/*'>
                                <label class='custom-file-label' for='staffImage'>Dosya seç...</label>
                            </div>
                            <img class='vesikalik-img' src='" . htmlspecialchars($staff['staffImage'], ENT_QUOTES, 'UTF-8') . "' alt='Mevcut Personel Görüntüsü' >
                        </div>
                        <button type='submit' class='btn btn-primary'>Güncelle</button>
                        <a href='Index.php' class='btn btn-secondary'>İptal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
