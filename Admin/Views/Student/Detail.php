<?php
include "../../Controllers/StudentController.php";
include "../../Controllers/StudentSessionTypeController.php";  // Controller include ediliyor
$title = "Öğrenci Detay";

// studentId'yi GET isteği ile alıyoruz.
$studentId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$student = $studentModel->getStudentById($studentId);

// Öğrenciye ait seans türlerini alıyoruz.
$studentSessionTypes = $studentSessionTypeModel->getSessionTypesByStudentId($studentId);

if (!$student) {
    echo "<div class='alert alert-danger mt-3'>Öğrenci bilgileri alınamadı.</div>";
    exit;
}
ob_start();
?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12">

                <!-- Öğrenci Bilgileri Kartı -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <!-- Sol Kolon: Kişisel Bilgiler ve Resim -->
                            <div class="col-md-6">
                                <h5 class="card-title"><i class="fas fa-user"></i> Öğrenci Bilgileri</h5>
                                <p class="card-text"><i class="fas fa-id-card"></i> <strong>Ad:</strong> <?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="card-text"><i class="fas fa-id-badge"></i> <strong>Soyad:</strong> <?= htmlspecialchars($student['surname'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="card-text"><i class="fa-solid fa-venus-mars"></i> <strong>Cinsiyet:</strong> <?= htmlspecialchars($student['gender'] == 1 ? 'Erkek' : 'Kız', ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="card-text"><i class="fas fa-address-card"></i> <strong>Kimlik Numarası:</strong> <?= htmlspecialchars($student['identityNumber'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="card-text"><i class="fas fa-calendar"></i> <strong>Doğum Tarihi:</strong> <?= date('d.m.Y', strtotime($student['birthDate'])); ?></p>
                            </div>

                            <!-- Sağ Kolon: Medikal Bilgiler -->
                            <div class="col-md-6">
                                <h5 class="card-title"><i class="fas fa-file-medical"></i> Medikal Bilgiler</h5>
                                <p class="card-text"><i class="fas fa-file-medical"></i> <strong>Rapor Numarası:</strong> <?= htmlspecialchars($student['aegrotatNumber'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="card-text"><i class="fas fa-calendar-check"></i> <strong>Rapor Geçerlilik Tarihi:</strong> <?= date('d.m.Y', strtotime($student['aegrotatValidityDate'])); ?></p>
                                <p class="card-text"><i class="fas fa-notes-medical"></i> <strong>Detaylı Sağlık Durumu:</strong> <br><span><?= nl2br(htmlspecialchars($student['medicalCondition'], ENT_QUOTES, 'UTF-8')); ?></span></p>
                                <p class="card-text"><i class="fas fa-calendar-check"></i> <strong>Kayıt Tarihi:</strong> <?= date('d.m.Y', strtotime($student['dateOfRecord'])); ?></p>
                                <p class="card-text"><i class="fas fa-user-check"></i> <strong>Durum:</strong> <?= $student['isActive'] == 1 ? 'Aktif' : 'Pasif'; ?></p>
                                <?php if ($student['isActive'] == 0): ?>
                                    <p class="card-text"><i class="fas fa-calendar-check"></i> <strong>Pasife Çekilme Tarihi:</strong> <?= date('d.m.Y', strtotime($student['dateOfInactivity'])); ?></p>
                                <?php endif; ?>
                                <!-- Seans Türleri Listeleme -->
                                <p class="card-text"><i class="fas fa-clock"></i> <strong>Seans Türleri:</strong>
                                <ul>
                                    <?php
                                    if (!empty($studentSessionTypes)) {
                                        foreach ($studentSessionTypes as $studentSessionType) {
                                    ?>
                                            <li><?= htmlspecialchars($studentSessionType['sessionType'], ENT_QUOTES, 'UTF-8'); ?> - Aylık Seans Sayısı: <?= htmlspecialchars($studentSessionType['monthlySessionNumber'], ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <li>Öğrencinin şu anda seans türü bulunmuyor.</li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Veli Bilgileri Kartı -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-user-friends"></i> Veli Bilgileri</h5>
                        <p class="card-text"><i class="fas fa-user"></i> <strong>Veli Adı Soyadı:</strong> <?= htmlspecialchars($student['parentNameSurname'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="card-text"><i class="fas fa-phone"></i> <strong>Veli Telefon Numarası:</strong> <?= htmlspecialchars($student['parentPhoneNumber'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="card-text"><i class="fas fa-home"></i> <strong>Veli Adresi:</strong> <?= htmlspecialchars($student['parentAddress'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="card-text"><i class="fas fa-id-card"></i> <strong>Veli Kimlik Numarası:</strong> <?= htmlspecialchars($student['parentIdentificationNumber'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>

                <?php if (!is_null($student['statusUpdate'])): ?>
                    <!-- Durum Güncellemeleri Kartı -->
                    <div class="card mt-4 toggle-card">
                        <div class="card-body">
                            <h5 class="card-title toggle-title">
                                <span>Durum Güncellemeleri</span><i class="fas fa-chevron-down"></i>
                            </h5>
                            <div class="toggle-content">
                                <p class="card-text">
                                    <?php
                                    // Durum güncellemelerini ayır
                                    $statusUpdate = $student['statusUpdate'];
                                    $updates = explode("\n\n", $statusUpdate); // İki boşlukla ayır

                                    // Her bir güncellemeyi döngü ile yazdır
                                    foreach ($updates as $update) {
                                        $colonCount = 0;
                                        // Satırları ayır
                                        $lines = explode("\n", $update);
                                        foreach ($lines as $line) {
                                            // : işaretine kadar olan kısmı kalın yap
                                            $colonPosition = strpos($line, ":");
                                            if ($colonPosition !== false && $colonCount < 3) { // Sadece ilk 3 ":" için geçerli
                                                $colonCount++;
                                                $firstPart = substr($line, 0, $colonPosition + 1);  // ":" dahil
                                                $remainingPart = substr($line, $colonPosition + 1); // ":" sonrası
                                                echo '<span><strong>' . htmlspecialchars($firstPart, ENT_QUOTES, 'UTF-8') . '</strong>' . htmlspecialchars($remainingPart, ENT_QUOTES, 'UTF-8') . '</span><br>';
                                            } else {
                                                // Eğer ":" işareti bulunmazsa veya 3'ten fazla ":" işareti varsa, tüm satırı olduğu gibi yaz
                                                echo '<span>' . htmlspecialchars($line, ENT_QUOTES, 'UTF-8') . '</span><br>';
                                            }
                                        }
                                        // Her güncellemeden sonra boş bir satır ekleyelim
                                        echo '<br>';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
                <!-- Butonlar -->
                <div class="text-center mt-4 mb-2">
                    <a href="studentSessions.php?id=<?= htmlspecialchars($student['studentId'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Seans Türü Ekle</a>
                    <a href="Index.php" class="btn btn-secondary">Geri Dön</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>