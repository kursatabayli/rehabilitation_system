<?php
$title = "Dashboard";
ob_start();
?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <h4 class="card-title">Dashboard</h4>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../Shared/_Layout.php");
?>
