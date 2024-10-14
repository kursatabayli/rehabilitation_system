<?php
include "../../Controllers/SpecialtyController.php";
$title = "Uzmanlık Ekle";

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Uzmanlık Ekle</h4>
                    <p class='card-subtitle mb-4'>Yeni bir uzmanlık ekleyin.</p>
                    <form data-action-type='create' action='../../Controllers/SpecialtyController.php' method='post'>
                        <div class='form-group mb-4'>
                            <label for='specialtyName'>Uzmanlık Adı</label>
                            <input type='text' class='form-control' id='specialtyName' name='specialtyName' placeholder='Uzmanlık adını girin...' required>
                        </div>
                        <button type='submit' class='btn btn-primary'>Ekle</button>
                        <a href='Index.php' class='btn btn-secondary'>İptal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
