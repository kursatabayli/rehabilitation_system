<?php
include_once '../../Helpers/Auth.php';
checkAuth(); // Tüm sayfalar için yetkilendirme kontrolü
?>

<!DOCTYPE html>
<html lang="tr">

<?php include("_Head.php"); ?>

<body>
  <?php
  echo "<div class='main-container'>";

  include("_Sidebar.php");

  echo "<div class='main-content'>";

  include("_Navbar.php");

  echo $content;

  include("_Footer.php");

  echo "</div>";
  echo "</div>";
  include("_Script.php");
  ?>
</body>

</html>