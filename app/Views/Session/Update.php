<?php
include "../../Controllers/SessionController.php";
include "../../Controllers/StaffController.php";
include "../../Controllers/StudentController.php";
include "../../Controllers/StudentSessionTypeController.php";

$title = "Seans Güncelle";

// Güncellenmesi gereken seansın ID'sini alıyoruz
$sessionId = isset($_GET['sessionId']) ? (int) $_GET['sessionId'] : null;
$session = $sessionModel->getSessionById($sessionId);

if (!$session) {
    die("Seans bilgisi bulunamadı.");
}

// Staff ve Student verilerini alıyoruz
$staffList = $staffModel->getAllStaff();
$students = $studentModel->getAllStudents();

// Öğrencinin mevcut seans türlerini alıyoruz
$studentId = $session['studentId'];
$studentSessionTypes = $studentSessionTypeModel->getSessionTypesByStudentId($studentId);

ob_start();
?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Seans Güncelle</h4>

                <!-- Güncelleme Formu -->
                <form class="input-sm" action="../../Controllers/SessionController.php" method="POST">
                    <input type="hidden" name="sessionId" value="<?php echo htmlspecialchars($session['sessionId']); ?>">

                    <!-- Personel Seçimi -->
                    <div class="form-group">
                        <label for="staffId">Personel Seç</label>
                        <select name="staffId" id="staffId" class="form-control">
                            <option value="">Personel Seçin</option>
                            <?php foreach ($staffList as $staff): ?>
                                <option value="<?php echo htmlspecialchars($staff['staffId']); ?>" <?php echo ($session['staffId'] == $staff['staffId'] ? "selected" : ""); ?>>
                                    <?php echo htmlspecialchars($staff['name'] . ' ' . $staff['surname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Öğrenci Seçimi -->
                    <div class="form-group">
                        <label for="studentId">Öğrenci Seç</label>
                        <select name="studentId" id="studentId" class="form-control">
                            <option value="">Öğrenci Seçin</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?php echo htmlspecialchars($student['studentId']); ?>" <?php echo ($studentId == $student['studentId'] ? "selected" : ""); ?>>
                                    <?php echo htmlspecialchars($student['name'] . ' ' . $student['surname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Seans Türü Seçimi -->
                    <div class="form-group">
                        <label for="sessionTypeId">Seans Türü Seç</label>
                        <select name="sessionTypeId" id="sessionTypeId" class="form-control">
                            <option value="">Seans Türü Seçin</option>
                            <?php foreach ($studentSessionTypes as $sessionType): ?>
                                <option value="<?php echo htmlspecialchars($sessionType['sessionTypeId']); ?>" <?php echo ($session['sessionTypeId'] == $sessionType['sessionTypeId'] ? "selected" : ""); ?>>
                                    <?php echo htmlspecialchars($sessionType['sessionType']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Başlangıç ve Bitiş Saati -->
                    <div class="form-group">
                        <label for="sessionStartTime">Başlangıç Saati</label>
                        <input type="time" name="sessionStartTime" class="form-control" value="<?php echo htmlspecialchars($session['sessionStartTime']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="sessionEndTime">Bitiş Saati</label>
                        <input type="time" name="sessionEndTime" class="form-control" value="<?php echo htmlspecialchars($session['sessionEndTime']); ?>" required>
                    </div>

                    <!-- Gün Seçimi -->
                    <div class="form-group">
                        <label for="dayId">Gün Seç</label>
                        <select name="dayId" id="dayId" class="form-control">
                            <?php for ($dayId = 1; $dayId <= 7; $dayId++): ?>
                                <option value="<?php echo $dayId; ?>" <?php echo ($session['dayId'] == $dayId ? "selected" : ""); ?>>
                                    <?php echo ["Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar"][$dayId - 1]; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Butonlar Grubu -->
                    <div class="form-group mt-4 d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-primary">Seansı Güncelle</button>
                        </div>
                        <button
                            data-url="../../Controllers/SessionController.php?sessionId=<?php echo htmlspecialchars($session['sessionId'], ENT_QUOTES, 'UTF-8'); ?>"
                            class="btn btn-danger btn-delete">
                            Seansı Kaldır
                        </button>
                        <a href="Index.php?dayId=<?php echo htmlspecialchars($session['dayId']); ?>" class="btn btn-secondary">İptal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>
