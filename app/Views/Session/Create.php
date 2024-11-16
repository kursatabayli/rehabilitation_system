<?php
include "../../Controllers/StaffController.php";
include "../../Controllers/StudentController.php";
include "../../Controllers/StudentSessionTypeController.php";  // Öğrenci Seans Türleri
include "../../Controllers/SessionController.php";

$title = "Seans Ekle";

$staffList = $staffModel->getAllStaff();
$students = $studentModel->getAllStudents();
ob_start();
?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Seans Ekle</h4>

                <!-- Seans Ekleme Formu -->
                <form class="input-sm" data-action-type="create" action="../../Controllers/SessionController.php" method="POST">

                    <!-- Personel Seçimi -->
                    <div class="form-group">
                        <label for="staffId">Personel Seç</label>
                        <select name="staffId" id="staffId" class="form-control">
                            <option value="">Personel Seçin</option>
                            <?php
                            // Tüm personelleri dropdown'a ekliyoruz
                            foreach ($staffList as $staff) {
                                echo '<option value="' . htmlspecialchars($staff["staffId"]) . '">' . htmlspecialchars($staff["name"] . " " . $staff["surname"]) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Öğrenci Seçimi -->
                    <div class="form-group">
                        <label for="studentId">Öğrenci Seç</label>
                        <select name="studentId" id="studentId" class="form-control">
                            <option value="">Öğrenci Seçin</option>
                            <?php
                            // Tüm öğrencileri dropdown'a ekliyoruz
                            foreach ($students as $student) {
                                echo '<option value="' . htmlspecialchars($student["studentId"]) . '">' . htmlspecialchars($student["name"] . " " . $student["surname"]) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Seans Türü Seçimi -->
                    <div class="form-group">
                        <label for="sessionTypeId">Seans Türü Seç</label>
                        <select name="sessionTypeId" id="sessionTypeId" class="form-control">
                            <option value="">Seans Türü Seçin</option>
                            <!-- Buraya, seans türlerini dinamik olarak ekleyebilirsiniz -->
                        </select>
                    </div>

                    <!-- Seans Başlangıç ve Bitiş Saati -->
                    <div class="form-group">
                        <label for="sessionStartTime">Başlangıç Saati</label>
                        <input type="time" name="sessionStartTime" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="sessionEndTime">Bitiş Saati</label>
                        <input type="time" name="sessionEndTime" class="form-control" required>
                    </div>

                    <!-- Gün Seçimi -->
                    <div class="form-group">
                        <label for="dayId">Gün Seç</label>
                        <select name="dayId" id="dayId" class="form-control">
                            <option value="1">Pazartesi</option>
                            <option value="2">Salı</option>
                            <option value="3">Çarşamba</option>
                            <option value="4">Perşembe</option>
                            <option value="5">Cuma</option>
                            <option value="6">Cumartesi</option>
                            <option value="7">Pazar</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Seans Ekle</button>
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
