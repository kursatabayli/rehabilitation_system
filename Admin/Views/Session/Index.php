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
                    <table id="adminSessionsTable" class="table table-bordered">
                        <thead>
                            <!-- javascript'ten Dinamik olarak saatler buraya ekleniyor -->
                        </thead>
                        <tbody>
                            <!-- javascript'ten Dinamik seans bilgileri buraya eklenecek -->
                        </tbody>
                    </table>
                </div>
                <!-- Boş Gün Mesajı -->
                <div id="noSessionsMessage">
                    <p class="no-session-text">Seans bulunmamaktadır.</p>
                </div>
                <a href="Create.php" class="btn btn-outline-primary">Seans Ekle</a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include "../Shared/_Layout.php";
?>