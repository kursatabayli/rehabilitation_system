<?php
include "../../Controllers/SpecialtyController.php";
$title = "Uzmanlık Güncelle";

$specialtyId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$specialties = $specialtyModel->getSpecialtyById($specialtyId);
$specialtyName = $specialties['specialtyName'] ?? '';
ob_start();
?>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h4 class="card-title">Uzmanlık Güncelle</h4>
                    <form class="input-sm" data-action-type="update" action="../../Controllers/SpecialtyController.php" method="post">
                        <input type="hidden" name="specialtyId" value="<?= $specialtyId ?>">
                        <div class="form-group mb-4">
                            <label for="specialtyName">Uzmanlık Adı</label>
                            <input type="text" class="form-control" id="specialtyName" name="specialtyName" value="<?= htmlspecialchars($specialtyName, ENT_QUOTES, 'UTF-8') ?>" required>
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