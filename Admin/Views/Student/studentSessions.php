<?php
include "../../Controllers/StudentController.php";
include "../../Controllers/StudentSessionTypeController.php";  // Controller include ediliyor

$title = "Öğrenci Seans Türleri";

// Veritabanı modelini başlat
$studentModel = new StudentModel($pdo);
$sessionTypeModel = new SessionTypeModel($pdo);
$studentSessionTypeModel = new StudentSessionTypeModel($pdo);

// Student ID kontrolü
$studentId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$student = $studentModel->getStudentById($studentId);

if (!$student) {
    die("Öğrenci bulunamadı.");
}

// Tüm seans türlerini getir
$allSessionTypes = $sessionTypeModel->getAllSessionTypes();

// Öğrencinin mevcut seans türlerini getir
$studentSessionTypes = $studentSessionTypeModel->getSessionTypesByStudentId($studentId);

// Mevcut seans türlerinin ID'lerini bir diziye alıyoruz
$existingSessionTypeIds = array_column($studentSessionTypes, 'sessionTypeId');

ob_start();
?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Öğrenci Seans Türleri - <?= htmlspecialchars($student['name'] . ' ' . $student['surname'], ENT_QUOTES, 'UTF-8'); ?></h4>
                <p class="card-subtitle mb-4">Öğrencinin mevcut seans türlerini ve yeni seans türü ekleme seçeneklerini görüntüleyin.</p>

                <!-- Seçilen Seans Türleri (Mevcut Seans Türleri) -->
                <div class="form-group">
                    <label>Mevcut Seans Türleri</label>
                    <ul class="list-group list-group-flush">
                        <?php
                        // Mevcut seans türlerini listede göster
                        if (!empty($studentSessionTypes)) {
                            foreach ($studentSessionTypes as $studentSessionType) {
                        ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($studentSessionType['sessionType'], ENT_QUOTES, 'UTF-8'); ?> - Aylık Seans Sayısı: <?= htmlspecialchars($studentSessionType['monthlySessionNumber'], ENT_QUOTES, 'UTF-8'); ?>
                                    <button data-url="../../Controllers/StudentSessionTypeController.php?studentSessionTypeId=<?= htmlspecialchars($studentSessionType['studentSessionTypeId'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash-alt"></i> Sil
                                    </button>
                                </li>
                            <?php
                            }
                        } else {
                            ?>
                            <li class="list-group-item">
                                Öğrencinin şu anda seans türü bulunmuyor.
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>

                <!-- Seans Türü Ekleme Formu (Dropdown seçim) -->
                <div class="form-group mt-4">
                    <form id="sessionTypeForm" action="../../Controllers/StudentSessionTypeController.php" method="post">
                        <input type="hidden" name="studentId" value="<?= htmlspecialchars($studentId, ENT_QUOTES, 'UTF-8'); ?>">

                        <?php
                        // Eklenebilecek seans türleri var mı kontrol ediyoruz
                        $hasSessionTypesToAdd = false;
                        foreach ($allSessionTypes as $sessionType) {
                            if (!in_array($sessionType['sessionTypeId'], $existingSessionTypeIds)) {
                                $hasSessionTypesToAdd = true;
                                break; // Eğer eklenebilecek en az bir seans türü varsa kontrolü durduruyoruz.
                            }
                        }

                        // Eğer eklenebilecek seans türü yoksa sadece "Geri Dön" butonunu gösteriyoruz
                        if ($hasSessionTypesToAdd) {
                        ?>
                            <!-- Seans Türü Dropdown -->
                            <label for="sessionTypeDropdown">Eklenebilecek Seans Türleri</label>
                            <select id="sessionTypeDropdown" class="form-control" name="sessionTypeId">
                                <option value="">Bir seans türü seçin</option>
                                <?php
                                // Sadece öğrencinin halihazırda sahip olmadığı seans türlerini listele ve dropdown yapısına çevir
                                foreach ($allSessionTypes as $sessionType) {
                                    if (!in_array($sessionType['sessionTypeId'], $existingSessionTypeIds)) {
                                ?>
                                        <option value="<?= htmlspecialchars($sessionType['sessionTypeId'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($sessionType['sessionType'], ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <br>
                            <label for="monthlySessionNumber">Aylık Seans Sayısı</label>
                            <input type="number" id="monthlySessionNumber" class="form-control" name="monthlySessionNumber" min="1" value="1">
                            <button type="submit" class="btn btn-primary mt-3">Seans Türü Ekle</button>
                        <?php
                        }
                        ?>

                        <!-- Her durumda "Geri Dön" butonu gösterilecek -->
                        <a href="Detail.php?id=<?= htmlspecialchars($student['studentId'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secondary mt-3">Geri Dön</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>