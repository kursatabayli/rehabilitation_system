<?php
$host = 'localhost';
$dbname = 'rehabilitation_system';
$username = 'root';
$password = '2332';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  error_log("Veritabanı bağlantı hatası: " . $e->getMessage());
  die("Veritabanı bağlantı hatası");
}
