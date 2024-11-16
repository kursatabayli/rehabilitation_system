<?php
include "../../Controllers/SpecialtyController.php";
$title = "Uzmanlıklar";
$counter = 1;
ob_start();
?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Uzmanlıklar</h4>
                <p class="card-subtitle mb-4">Uzmanlık oluşturma ve düzenleme alanı.</p>
                <div class="table-responsive">
                    <table id="customTable" class="table mb-4">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Uzmanlık Adı</th>
                            <th>Güncelle</th>
                            <th>Sil</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($specialties as $specialty): ?>
                            <tr>
                                <td><?= $counter ?></td>
                                <td><?= htmlspecialchars($specialty['specialtyName'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><a href="Update.php?id=<?= $specialty['specialtyId'] ?>" class="btn btn-outline-success">Güncelle</a></td>
                                <td><button data-url="../../Controllers/SpecialtyController.php?id=<?= $specialty['specialtyId'] ?>" class="btn btn-outline-danger btn-sm btn-delete">Sil</button></td>
                            </tr>
                            <?php $counter++; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="Create.php" class="btn btn-outline-primary">Uzmanlık Ekle</a>
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>
