<?php
session_start();
include "../../Controllers/StaffController.php";
$title = "Kişisel Bilgiler";

// staffId'yi SESSION isteği ile alıyoruz.
$staffId = $_SESSION['_staffId'];

// Staff bilgilerini alıyoruz.
$staff = $staffModel->getStaffById($staffId);

// Staff uzmanlıklarını alıyoruz (JSON döndürecek bir kontrol olmadığından, PHP'de işliyoruz).
$staffSpecialties = $staffModel->getSpecialtiesByStaffId($staffId);

ob_start();
?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12">

                <div class="card-body">
                    <div class="row">
                        <!-- Sol Kolon: Kişisel Bilgiler ve Resim -->
                        <div class="col-md-6">
                            <h5 class="card-title"><i class="fas fa-user"></i> Kişisel Bilgiler</h5>
                            <p class="card-text"><i class="fas fa-id-card"></i> <strong>Adı:</strong> <?= htmlspecialchars($staff['name'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><i class="fas fa-id-badge"></i> <strong>Soyadı:</strong> <?= htmlspecialchars($staff['surname'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><i class="fa-solid fa-venus-mars"></i> <strong>Cinsiyet:</strong> <?= htmlspecialchars($staff['gender'] == 1 ? 'Erkek' : 'Kız', ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><i class="fas fa-address-card"></i> <strong>Kimlik Numarası:</strong> <?= htmlspecialchars($staff['identityNumber'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><i class="fas fa-phone"></i> <strong>Telefon Numarası:</strong> <?= htmlspecialchars($staff['phoneNumber'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><i class="fas fa-envelope"></i> <strong>E-posta:</strong> <?= htmlspecialchars($staff['email'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>

                        <!-- Sağ Kolon: Mesleki Bilgiler -->
                        <div class="col-md-6">
                            <h5 class="card-title"><i class="fas fa-briefcase"></i> Mesleki Bilgiler</h5>
                            <p class="card-text"><i class="fas fa-user-md"></i> <strong>Meslek:</strong> <?= htmlspecialchars($staff['professionName'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><i class="fas fa-calendar-alt"></i> <strong>İşe Giriş Tarihi:</strong> <?= date('d.m.Y', strtotime($staff['dateOfRecruitment'])) ?></p>
                            <p class="card-text"><i class="fas fa-id-badge"></i> <strong>Personel Numarası:</strong> <?= htmlspecialchars($staff['personnelNumber'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><i class="fas fa-file-medical"></i> <strong>Tıbbi Lisans Numarası:</strong> <?= htmlspecialchars($staff['medicalLicenceNumber'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><i class="fas fa-file-medical"></i> <strong>Uzmanlıklar:</strong>
                            <ul>
                                <?php if (!empty($staffSpecialties)): ?>
                                    <?php foreach ($staffSpecialties as $specialty): ?>
                                        <li><?= htmlspecialchars($specialty['specialtyName'], ENT_QUOTES, 'UTF-8') ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li>Uzmanlık bilgisi bulunamadı.</li>
                                <?php endif; ?>
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>