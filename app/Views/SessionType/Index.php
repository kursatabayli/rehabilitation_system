<?php
include "../../Controllers/SessionTypeController.php";
$title = "Seans Türleri";
$counter = 1;

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Seans Türleri</h4>
                    <p class='card-subtitle mb-4'>Seans türü oluşturma ve düzenleme alanı.</p>
                    <div class='table-responsive'>
                        <table id='customTable' class='table mb-4'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Seans Türü</th>
                                    <th>Güncelle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>";

    foreach ($sessionTypes as $item) {
        $content .= "
                                <tr>
                                    <td>{$counter}</td>
                                    <td class='find'>" . htmlspecialchars($item['sessionType'], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td><a href='Update.php?id={$item['sessionTypeId']}' class='btn btn-outline-success'>Güncelle</a></td>
                                    <td><button data-url='../../Controllers/SessionTypeController.php?id={$item['sessionTypeId']}' class='btn btn-outline-danger btn-sm btn-delete'>Sil</button></td>
                                </tr>";
        $counter++;
    }

    $content .= "
                            </tbody>
                        </table>
                    </div>
                   <a href='Create.php' class='btn btn-outline-primary'>Seans Türü Ekle</a>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
