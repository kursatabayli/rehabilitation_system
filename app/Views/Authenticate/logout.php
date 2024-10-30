<?php
session_start();
session_unset(); // Tüm oturum verilerini temizler
session_destroy(); // Oturumu tamamen kapatır
header('Location: login.php'); // Giriş sayfasına yönlendir
exit;
