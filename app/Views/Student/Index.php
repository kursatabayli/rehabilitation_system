<?php
include "../../Controllers/StudentController.php";
$title = "Öğrenciler";
$counter = 1;

// Aktif ve pasif öğrencileri ayırma
$activeStudents = array_filter($students, fn($student) => $student['isActive'] == 1);
$inactiveStudents = array_filter($students, fn($student) => $student['isActive'] == 0);


$content = "
    <div class='page-content'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-xl-12'>
                    <h4 class='card-title'>Öğrenciler</h4>
                    <p class='card-subtitle mb-4'>Öğrenci ekleme ve bilgilerini listeleme alanı.</p>
                    <div class='table-responsive'>
                        <table id='customTable' class='table mb-4'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Öğrenci Adı-Soyadı</th>
                                    <th>Kimlik Numarası</th>
                                    <th>Detay Gör</th>
                                    <th>Güncelle</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>";

    foreach (array_merge($activeStudents, $inactiveStudents) as $student) {
        $status = $student['isActive'] == 1 ? 'Aktif' : 'Pasif';
        $content .= "
                                <tr>
                                    <td>{$counter}</td>
                                    <td>" . htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($student['surname'], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>" . htmlspecialchars($student['identityNumber'], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td><a href='Detail.php?id={$student['studentId']}' class='btn btn-outline-info'>Detay Gör</a></td>
                                    <td><a href='Update.php?id=" . htmlspecialchars($student['studentId'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-outline-success'>Güncelle</a></td>
                                    <td>{$status}</td>
                                </tr>";
        $counter++;
    }

    $content .= "
                            </tbody>
                        </table>
                    </div>
                   <a href='Create.php' class='btn btn-outline-primary'>Öğrenci Ekle</a>
                </div>
            </div>
        </div>
    </div>";

include "../Shared/_Layout.php";