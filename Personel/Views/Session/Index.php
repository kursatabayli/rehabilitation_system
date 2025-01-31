<?php
$title = "Haftalık Seans Planı";
include_once __DIR__ . '/../../../config/config.php';
$dayOfWeek = date('N');
// Gün ID'sini al
$selectedDayId = isset($_GET['dayId']) ? $_GET['dayId'] : $dayOfWeek; // Dinamik olarak içinde olunan gün

ob_start();
?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Haftalık Seans Planı</h4>

                <!-- Gün Seçici Menü -->
                <div class="mb-4 days-menu">
                    <?php
                    foreach ($days as $dayId => $dayName) {
                        $selectedClass = ($selectedDayId == $dayId) ? "selected-day" : "";
                        echo "<a href=\"?dayId=$dayId\" class=\"btn day-btn $selectedClass\">$dayName</a>";
                    }
                    ?>
                </div>

                <div>
                    <table id="staffSessionsTable" class="table table-bordered">
                        <thead>
                            <!-- Dinamik olarak saatler buraya ekleniyor -->
                        </thead>
                        <tbody>
                            <!-- Dinamik seans bilgileri buraya eklenecek -->
                        </tbody>
                    </table>
                </div>
                <!-- Boş Gün Mesajı -->
                <div id="noSessionsMessage" style="display: none; text-align: center; margin-top: 20px;">
                    <p class="no-session-text">Seansınız bulunmamaktadır.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>