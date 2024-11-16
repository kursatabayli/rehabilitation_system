<?php
include "../../Controllers/StudentController.php";
$title = "Öğrenci Güncelle";

// Öğrencinin ID'sini URL'den al
$studentId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$student = $studentModel->getStudentById($studentId);

if (!$student) {
    echo "<div class='alert alert-danger mt-3'>Öğrenci bilgileri alınamadı.</div>";
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
                        <input type="hidden" name="studentId" value="<?php echo htmlspecialchars($studentId, ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="form-group mb-4">
                            <label for="name">Ad</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="surname">Soyad</label>
                            <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($student['surname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="identityNumber">Kimlik Numarası</label>
                            <input type="text" class="form-control" id="identityNumber" name="identityNumber" value="<?php echo htmlspecialchars($student['identityNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="birthDate">Doğum Tarihi</label>
                            <input type="date" class="form-control" id="birthDate" name="birthDate" value="<?php echo htmlspecialchars($student['birthDate'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="parentNameSurname">Veli Adı Soyadı</label>
                            <input type="text" class="form-control" id="parentNameSurname" name="parentNameSurname" value="<?php echo htmlspecialchars($student['parentNameSurname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="parentPhoneNumber">Veli Telefon Numarası</label>
                            <input type="text" class="form-control" id="parentPhoneNumber" name="parentPhoneNumber" value="<?php echo htmlspecialchars($student['parentPhoneNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="parentAddress">İletişim Adresi</label>
                            <textarea class="form-control" id="parentAddress" name="parentAddress" required><?php echo htmlspecialchars($student['parentAddress'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label for="parentIdentificationNumber">Veli Kimlik Numarası</label>
                            <input type="text" class="form-control" id="parentIdentificationNumber" name="parentIdentificationNumber" value="<?php echo htmlspecialchars($student['parentIdentificationNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="medicalCondition">Sağlık Durumu</label>
                            <textarea class="form-control" id="medicalCondition" name="medicalCondition"><?php echo htmlspecialchars($student['medicalCondition'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label for="aegrotatNumber">Rapor Numarası</label>
                            <input type="number" class="form-control" id="aegrotatNumber" name="aegrotatNumber" value="<?php echo htmlspecialchars($student['aegrotatNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="form-group mb-4">
                            <label for="aegrotatValidityDate">Rapor Geçerlilik Tarihi</label>
                            <input type="date" class="form-control" id="aegrotatValidityDate" name="aegrotatValidityDate" value="<?php echo htmlspecialchars($student['aegrotatValidityDate'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="form-group mb-4">
                            <label for="monthlySessions">Aylık Seans Sayısı</label>
                            <input type="number" class="form-control" id="monthlySessions" name="monthlySessions" value="<?php echo htmlspecialchars($student['monthlySessions'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="form-group mb-4">
                            <label for="isActive">Durum</label>
                            <select class="form-control" id="isActive" name="isActive" required>
                                <option value="1" <?php echo ($student['isActive'] == 1 ? 'selected' : ''); ?>>Aktif</option>
                                <option value="0" <?php echo ($student['isActive'] == 0 ? 'selected' : ''); ?>>Pasif</option>
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