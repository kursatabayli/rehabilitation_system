<?php
include "../../Controllers/StudentController.php";
$title = "Öğrenci Güncelle";

// Öğrencinin ID'sini URL'den al
$studentId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$student = $studentModel->getStudentById($studentId);

if (!$student) {
    echo '<div class="alert alert-danger mt-3">Öğrenci bilgileri alınamadı.</div>';
    exit;
}
ob_start();
?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Öğrenci Güncelle</h4>
                <p class="card-subtitle mb-4">Öğrenci bilgilerini güncelleyin.</p>
                <form class="input-sm" data-action-type="update" action="../../Controllers/StudentController.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="studentId" value="<?= htmlspecialchars($studentId, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="form-group mb-4">
                        <label for="name">Ad</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="surname">Soyad</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="<?= htmlspecialchars($student['surname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="gender">Cinsiyet</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="1" <?= ($student['gender'] == 1 ? 'selected' : ''); ?>>Erkek</option>
                            <option value="0" <?= ($student['gender'] == 0 ? 'selected' : ''); ?>>Kız</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="identityNumber">Kimlik Numarası</label>
                        <input type="text" class="form-control" id="identityNumber" name="identityNumber" value="<?= htmlspecialchars($student['identityNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="birthDate">Doğum Tarihi</label>
                        <input type="date" class="form-control" id="birthDate" name="birthDate" value="<?= htmlspecialchars($student['birthDate'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="parentNameSurname">Veli Adı Soyadı</label>
                        <input type="text" class="form-control" id="parentNameSurname" name="parentNameSurname" value="<?= htmlspecialchars($student['parentNameSurname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="parentPhoneNumber">Veli Telefon Numarası</label>
                        <input type="text" class="form-control" id="parentPhoneNumber" name="parentPhoneNumber" value="<?= htmlspecialchars($student['parentPhoneNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="parentAddress">İletişim Adresi</label>
                        <textarea class="form-control" id="parentAddress" name="parentAddress" required><?= htmlspecialchars($student['parentAddress'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="parentIdentificationNumber">Veli Kimlik Numarası</label>
                        <input type="text" class="form-control" id="parentIdentificationNumber" name="parentIdentificationNumber" value="<?= htmlspecialchars($student['parentIdentificationNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="medicalCondition">Sağlık Durumu</label>
                        <textarea class="form-control" id="medicalCondition" name="medicalCondition"><?= htmlspecialchars($student['medicalCondition'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="aegrotatNumber">Rapor Numarası</label>
                        <input type="number" class="form-control" id="aegrotatNumber" name="aegrotatNumber" value="<?= htmlspecialchars($student['aegrotatNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group mb-4">
                        <label for="aegrotatValidityDate">Rapor Geçerlilik Tarihi</label>
                        <input type="date" class="form-control" id="aegrotatValidityDate" name="aegrotatValidityDate" value="<?= htmlspecialchars($student['aegrotatValidityDate'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group mb-4">
                        <label for="monthlySessions">Aylık Seans Sayısı</label>
                        <input type="number" class="form-control" id="monthlySessions" name="monthlySessions" value="<?= htmlspecialchars($student['monthlySessions'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group mb-4">
                        <label for="dateOfRecord">Kayıt Tarihi</label>
                        <input type="date" class="form-control" id="dateOfRecord" name="dateOfRecord"
                            value="<?= date('Y-m-d', strtotime($student['dateOfRecord'])) ?>">
                    </div>

                    <div class="form-group mb-4">
                        <label for="isActive">Durum</label>
                        <select class="form-control" id="isActive" name="isActive" required>
                            <option value="1" <?= ($student['isActive'] == 1 ? 'selected' : ''); ?>>Aktif</option>
                            <option value="0" <?= ($student['isActive'] == 0 ? 'selected' : ''); ?>>Pasif</option>
                        </select>
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