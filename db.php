<?php
// PHP başlangıcı
// Veritabanı bağlantısı - ihtiyaç halinde kullanıcı/parola/db ismini düzenleyin
// Değişken tanımı
$host = "localhost";
// Değişken tanımı
$user = "root";
// Değişken tanımı
$pass = "";
// Değişken tanımı
$dbname = "kitap_sistemi";

// Değişken tanımı
$conn = mysqli_connect($host, $user, $pass, $dbname);
// Koşul kontrolü
if (!$conn) {
    die("Bağlantı hatası: " . mysqli_connect_error());
}

// Basit güvenlik yardımcıları
function esc($s) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, $s), ENT_QUOTES, 'UTF-8');
}
?>