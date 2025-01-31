<?php
include "../../Controllers/StudentController.php";
$title = "Öğrenci Durumu Güncelleme";

// Öğrencinin ID'sini URL'den al
$studentId = isset($_GET['studentId']) ? (int) $_GET['studentId'] : null;
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
                <h4 class="card-title">Durum Bilgileri</h4>
                <p class="card-subtitle mb-4">Öğrencinin durum bilgilerini güncelleyin.</p>
                <form class="input-sm" data-action-type="update" action="../../Controllers/StudentController.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="studentId" value="<?= htmlspecialchars($studentId, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="form-group mb-4">
                        <label for="statusUpdate">Durum Güncellemesi</label>
                        <textarea class="form-control" id="statusUpdate" name="statusUpdate" placeholder="Durum Güncellemesini Giriniz..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Güncelle</button>
                    <a href="Detail.php?studentId=<?= htmlspecialchars($student['studentId'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secondary">İptal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>