<?php
include "../../Controllers/StaffController.php";
$title = "Personel Güncelle";

$staffId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$staff = $staffModel->getStaffById($staffId);
$professions = $professionModel->getAllProfessions();
ob_start();
?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Personel Güncelle</h4>
                <p class="card-subtitle mb-4">Personel bilgilerini güncelleyin.</p>
                <form class="input-sm" data-action-type="update" action="../../Controllers/StaffController.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="staffId" value="<?= htmlspecialchars($staff['staffId'], ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="form-group mb-4">
                        <label for="name">Ad</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($staff['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="surname">Soyad</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="<?= htmlspecialchars($staff['surname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="gender">Cinsiyet</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="1" <?= ($staff['gender'] == 1 ? 'selected' : ''); ?>>Erkek</option>
                            <option value="0" <?= ($staff['gender'] == 0 ? 'selected' : ''); ?>>Kız</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="professionId">Meslek</label>
                        <select class="form-control" id="professionId" name="professionId" required>
                            <?php foreach ($professions as $profession): ?>
                                <?php $selected = $staff['professionId'] == $profession['professionId'] ? "selected" : ""; ?>
                                <option value="<?= htmlspecialchars($profession['professionId'], ENT_QUOTES, 'UTF-8'); ?>" <?= $selected; ?>>
                                    <?= htmlspecialchars($profession['professionName'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="personnelNumber">Personel Numarası</label>
                        <input type="text" class="form-control" id="personnelNumber" name="personnelNumber" value="<?= htmlspecialchars($staff['personnelNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="medicalLicenceNumber">Tıbbi Lisans Numarası</label>
                        <input type="text" class="form-control" id="medicalLicenceNumber" name="medicalLicenceNumber" value="<?= htmlspecialchars($staff['medicalLicenceNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="form-group mb-4">
                        <label for="identityNumber">Kimlik Numarası</label>
                        <input type="text" class="form-control" id="identityNumber" name="identityNumber" value="<?= htmlspecialchars($staff['identityNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="phoneNumber">Telefon Numarası</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?= htmlspecialchars($staff['phoneNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="form-group mb-4">
                        <label for="email">E-posta</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($staff['email'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="form-group mb-4 password-group">
                        <label for="password">Şifre</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" id="password" name="password" value="<?= htmlspecialchars($staff['password'], ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="dateOfRecruitment">İşe Giriş Tarihi</label>
                        <input type="date" class="form-control" id="dateOfRecruitment" name="dateOfRecruitment"
                            value="<?= date('Y-m-d', strtotime($staff['dateOfRecruitment'])) ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Güncelle</button>
                    <a href="Index.php" class="btn btn-secondary">İptal</a>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>