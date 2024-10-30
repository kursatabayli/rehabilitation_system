<?php
include "../../Controllers/ProfessionController.php";
$title = "Meslek Güncelle";

$professionId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$profession = $professionModel->getProfessionById($professionId);

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Meslek Güncelle</h4>
                    <form class='input-sm' data-action-type='update' action='../../Controllers/ProfessionController.php' method='post'>
                        <input type='hidden' name='professionId' value='{$profession['professionId']}'>
                        <div class='form-group mb-4'>
                            <label for='professionName'>Meslek Adı</label>
                            <input type='text' class='form-control' id='professionName' name='professionName' value='" . htmlspecialchars($profession['professionName'], ENT_QUOTES, 'UTF-8') . "' required>
                        </div>
                        <button type='submit' class='btn btn-primary'>Güncelle</button>
                        <a href='Index.php' class='btn btn-secondary'>İptal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
