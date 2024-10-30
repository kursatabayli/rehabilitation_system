<?php
include "../../Controllers/StaffController.php";
$title = "Personeller";
$counter = 1;

$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Personeller</h4>
                <p class='card-subtitle mb-4'>Personel oluşturma ve düzenleme alanı.</p>
                    <div class='table-responsive'>
                    <table id='customTable' class='table mb-4'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ad Soyad</th>
                                    <th>Meslek</th>
                                    <th>Detay Gör</th>
                                    <th>Güncelle</th>
                                <th>Uzmanlıkları Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>";

  foreach ($staffList as $staff) {
    $content .= "
                                <tr>
                                    <td>{$counter}</td>
                                    <td>" . htmlspecialchars($staff['name'] . " " . $staff['surname'], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>" . htmlspecialchars($staff['professionName'], ENT_QUOTES, 'UTF-8') . "</td>
                                <td><a href='Detail.php?id=" . htmlspecialchars($staff['staffId'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-outline-info'>Detay Gör</a></td>
                                <td><a href='Update.php?id=" . htmlspecialchars($staff['staffId'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-outline-success'>Güncelle</a></td>
                                <td><a href='staffSpecialty.php?id=" . htmlspecialchars($staff['staffId'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-outline-primary'>Düzenle</a></td>
                                <td><button data-url='../../Controllers/StaffController.php?id=" . htmlspecialchars($staff['staffId'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-outline-danger btn-sm btn-delete'>Sil</button></td>
                                </tr>";
    $counter++;
  }

  $content .= "
                            </tbody>
                        </table>
                </div>
                    <a href='Create.php' class='btn btn-outline-primary'>Personel Ekle</a>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";
