<?php
include "../../Controllers/ProfessionController.php";
$title = "Meslekler";
$counter = 1;

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Meslekler</h4>
                    <p class='card-subtitle mb-4'>Meslek oluşturma ve düzenleme alanı.</p>
                    <div class='table-responsive'>
                        <table id='customTable' class='table mb-4'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Meslek Adı</th>
                                    <th>Güncelle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>";

                                foreach ($professions as $profession) {
                                    $content .= "
                                                            <tr>
                                                                <td>{$counter}</td>
                                                                <td class='find'>" . htmlspecialchars($profession['professionName'], ENT_QUOTES, 'UTF-8') . "</td>
                                                                <td><a href='Update.php?id={$profession['professionId']}' class='btn btn-outline-success'>Güncelle</a></td>
                                                                <td><button data-url='../../Controllers/ProfessionController.php?id={$profession['professionId']}' class='btn btn-outline-danger btn-sm btn-delete'>Sil</button></td>
                                                            </tr>";
                                    $counter++;
                                }

    $content .= "
                            </tbody>
                        </table>
                    </div>
                   <a href='Create.php' class='btn btn-outline-primary'>Meslek Ekle</a>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
