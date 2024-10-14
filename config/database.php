<?php
// config/database.php

$host = 'localhost';
$dbname = 'rehabilitation_system'; // Veritabanı adını buraya yazın
$username = 'root'; // Veritabanı kullanıcı adını buraya yazın
$password = '2332'; // Veritabanı şifresini buraya yazın

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  error_log("Veritabanı bağlantı hatası: " . $e->getMessage());
  die("Veritabanı bağlantı hatası");
}
