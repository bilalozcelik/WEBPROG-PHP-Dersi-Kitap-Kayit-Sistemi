<?php
// PHP başlangıcı
// Oturum başlatılır
session_start();
include 'db.php';
// Koşul kontrolü
if (!isset($_SESSION['uye_id'])) { header('Location: login.php'); exit; }
// Değişken tanımı
$uye_id = $_SESSION['uye_id'];
// Üye silindiğinde ilişkili kitaplar ON DELETE CASCADE ile silinecek
// Değişken tanımı
$stmt = mysqli_prepare($conn, "DELETE FROM uyeler WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $uye_id);
mysqli_stmt_execute($stmt);
session_unset();
session_destroy();
header('Location: register.php');
exit;