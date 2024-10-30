<?php
include "../../Controllers/SessionTypeController.php";
$title = "Seans Türü Ekle";

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Seans Türü Ekle</h4>
                    <p class='card-subtitle mb-4'>Yeni bir Seans Türü ekleyin.</p>
                    <form class='input-sm' data-action-type='create' action='../../Controllers/SessionTypeController.php' method='post'>
                        <div class='form-group mb-4'>
                            <label for='sessionType'>Seans Türü</label>
                            <input type='text' class='form-control' id='sessionType' name='sessionType' placeholder='Seans Türünü Girin...' required>
                        </div>
                        <button type='submit' class='btn btn-primary'>Ekle</button>
                        <a href='Index.php' class='btn btn-secondary'>İptal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
