<?php
include "../../Controllers/StaffController.php";
$title = "Personel Ekle";

// Tüm meslekleri dropdown için alma
$professions = $professionModel->getAllProfessions();
ob_start();
?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Personel Ekle</h4>
                <p class="card-subtitle mb-4">Yeni bir personel ekleyin.</p>
                <form class="input-sm" data-action-type="create" action="../../Controllers/StaffController.php" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-4">
                        <label for="name">Ad</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Adını girin..." required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="surname">Soyad</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyadını girin..." required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="professionId">Meslek</label>
                        <select class="form-control" id="professionId" name="professionId" required>
                            <option value="">Seçin...</option>
                            <?php foreach ($professions as $profession): ?>
                                <option value="<?= $profession['professionId'] ?>"><?= htmlspecialchars($profession['professionName'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="personnelNumber">Personel Numarası</label>
                        <input type="text" class="form-control" id="personnelNumber" name="personnelNumber" placeholder="Personel numarasını girin..." required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="medicalLicenceNumber">Tıbbi Lisans Numarası</label>
                        <input type="text" class="form-control" id="medicalLicenceNumber" name="medicalLicenceNumber" placeholder="Tıbbi lisans numarasını girin...">
                    </div>
                    <div class="form-group mb-4">
                        <label for="identityNumber">Kimlik Numarası</label>
                        <input type="text" class="form-control" id="identityNumber" name="identityNumber" placeholder="Kimlik numarasını girin..." required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="phoneNumber">Telefon Numarası</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Telefon numarasını girin...">
                    </div>
                    <div class="form-group mb-4">
                        <label for="email">E-posta</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-posta adresini girin...">
                    </div>
                    <button type="submit" class="btn btn-primary">Ekle</button>
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
