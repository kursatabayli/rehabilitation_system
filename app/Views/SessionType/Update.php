<?php
include "../../Controllers/SessionTypeController.php";
$title = "Seans Türü Güncelle";

$sessionTypeId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$sessionType = $sessionTypeModel->getSessionTypeById($sessionTypeId);
$sessionTypeName = $sessionType['sessionType'] ?? '';

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Seans Türü Güncelle</h4>
                    <form data-action-type='update' action='../../Controllers/SessionTypeController.php' method='post'>
                        <input type='hidden' name='sessionTypeId' value='{$sessionTypeId}'>
                        <div class='form-group mb-4'>
                            <label for='sessionType'>Seans Türü</label>
                            <input type='text' class='form-control' id='sessionType' name='sessionType' value='" . htmlspecialchars($sessionTypeName, ENT_QUOTES, 'UTF-8') . "' required>
                        </div>
                        <button type='submit' class='btn btn-primary'>Güncelle</button>
                        <a href='Index.php' class='btn btn-secondary'>İptal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
