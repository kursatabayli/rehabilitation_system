<!DOCTYPE html>
<html lang="en">
<?php include("_Head.php"); ?>

<body>
  <?php

  include("_Sidebar.php");

  echo "<div class='main-content'>";

  include("_Navbar.php");

  echo $content;

  include("_Footer.php");

  echo "</div>";

  include("_Script.php"); ?>
</body>

</html>