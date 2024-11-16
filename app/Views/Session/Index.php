<?php
$title = "Haftalık Seans Planı";

// Seçili gün ID'sini al
$selectedDayId = isset($_GET['dayId']) ? $_GET['dayId'] : 1; // Varsayılan olarak Pazartesi

ob_start();
?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Haftalık Seans Planı</h4>

                <!-- Gün Seçici Menü -->
                <div class="mb-4 days-menu">
                    <a href="?dayId=1" class="btn day-btn <?php echo ($selectedDayId == 1 ? "selected-day" : ""); ?>">Pazartesi</a>
                    <a href="?dayId=2" class="btn day-btn <?php echo ($selectedDayId == 2 ? "selected-day" : ""); ?>">Salı</a>
                    <a href="?dayId=3" class="btn day-btn <?php echo ($selectedDayId == 3 ? "selected-day" : ""); ?>">Çarşamba</a>
                    <a href="?dayId=4" class="btn day-btn <?php echo ($selectedDayId == 4 ? "selected-day" : ""); ?>">Perşembe</a>
                    <a href="?dayId=5" class="btn day-btn <?php echo ($selectedDayId == 5 ? "selected-day" : ""); ?>">Cuma</a>
                    <a href="?dayId=6" class="btn day-btn <?php echo ($selectedDayId == 6 ? "selected-day" : ""); ?>">Cumartesi</a>
                    <a href="?dayId=7" class="btn day-btn <?php echo ($selectedDayId == 7 ? "selected-day" : ""); ?>">Pazar</a>
                </div>

                <!-- DataTable -->
                <div>
                    <table id="sessionsTable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Personeller</th>
                            <!-- Dinamik olarak saatler buraya ekleniyor -->
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Dinamik seans bilgileri buraya eklenecek -->
                        </tbody>
                    </table>
                </div>
                <!-- Boş Gün Mesajı -->
                <div id="noSessionsMessage" style="display: none; text-align: center; margin-top: 20px;">
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
