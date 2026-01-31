<?php
// PHP başlangıcı
// Oturum başlatılır
session_start();
include 'db.php';
// Koşul kontrolü
if (!isset($_SESSION['uye_id'])) { header('Location: login.php'); exit; }
// Değişken tanımı
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// Değişken tanımı
$uye_id = $_SESSION['uye_id'];
// Değişken tanımı
$stmt = mysqli_prepare($conn, "DELETE FROM kitaplar WHERE id = ? AND uye_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $id, $uye_id);
mysqli_stmt_execute($stmt);
header('Location: index.php');
exit;