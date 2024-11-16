<?php
include "../../Controllers/StudentController.php";
$title = "Öğrenci Ekle";
ob_start();
?>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h4 class="card-title">Öğrenci Ekle</h4>
                    <p class="card-subtitle mb-4">Yeni bir öğrenci ekleyin.</p>
                    <form class="input-sm" data-action-type="create" action="../../Controllers/StudentController.php" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-4">
                            <label for="name">Ad</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Öğrencinin adını girin..." required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="surname">Soyad</label>
                            <input type="text" class="form-control" id="surname" name="surname" placeholder="Öğrencinin soyadını girin..." required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="identityNumber">Kimlik Numarası</label>
                            <input type="text" class="form-control" id="identityNumber" name="identityNumber" placeholder="Kimlik numarasını girin..." required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="birthDate">Doğum Tarihi</label>
                            <input type="date" class="form-control" id="birthDate" name="birthDate" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="parentNameSurname">Veli Adı Soyadı</label>
                            <input type="text" class="form-control" id="parentNameSurname" name="parentNameSurname" placeholder="Velinin adını ve soyadını girin..." required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="parentPhoneNumber">Veli Telefon Numarası</label>
                            <input type="text" class="form-control" id="parentPhoneNumber" name="parentPhoneNumber" placeholder="Velinin telefon numarasını girin..." required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="parentAddress">İletişim Adresi</label>
                            <textarea class="form-control" id="parentAddress" name="parentAddress" placeholder="Öğrencinin iletişim adresini girin..." required></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="parentIdentificationNumber">Veli Kimlik Numarası</label>
                            <input type="text" class="form-control" id="parentIdentificationNumber" name="parentIdentificationNumber" placeholder="Velinin kimlik numarasını girin..." required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="medicalCondition">Sağlık Durumu</label>
                            <textarea class="form-control" id="medicalCondition" name="medicalCondition" placeholder="Öğrencinin sağlık durumunu girin..."></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="aegrotatNumber">Rapor Numarası</label>
                            <input type="number" class="form-control" id="aegrotatNumber" name="aegrotatNumber" placeholder="Rapor numarasını girin...">
                        </div>
                        <div class="form-group mb-4">
                            <label for="aegrotatValidityDate">Rapor Geçerlilik Tarihi</label>
                            <input type="date" class="form-control" id="aegrotatValidityDate" name="aegrotatValidityDate">
                        </div>
                        <div class="form-group mb-4">
                            <label for="monthlySessions">Aylık Seans Sayısı</label>
                            <input type="number" class="form-control" id="monthlySessions" name="monthlySessions" placeholder="Aylık seans sayısını girin...">
                        </div>
                        <div class="form-group mb-4">
                            <label for="isActive">Durum</label>
                            <select class="form-control" id="isActive" name="isActive" required>
                                <option value="1">Aktif</option>
                                <option value="0">Pasif</option>
                            </select>
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