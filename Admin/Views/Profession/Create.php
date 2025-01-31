<?php
include "../../Controllers/ProfessionController.php";
$title = "Meslek Ekle";
ob_start();
?>
<div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h4 class="card-title">Meslek Ekle</h4>
                    <p class="card-subtitle mb-4">Yeni bir meslek ekleyin.</p>
                    <form class="input-sm" data-action-type="create" action="../../Controllers/ProfessionController.php" method="post">
                        <div class="form-group mb-4">
                            <label for="professionName">Meslek Adı</label>
                            <input type="text" class="form-control" id="professionName" name="professionName" placeholder="Meslek adını girin..." required>
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