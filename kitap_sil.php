<?php
/**
 * KİTAP SİLME SAYFASI
 * Belirtilen kitabı veritabanından siler
 */

// Oturumu başlat
session_start();

// Veritabanı bağlantısını dahil et
include 'db.php';

// Kullanıcı giriş yapmamışsa login sayfasına yönlendir
if (!isset($_SESSION['uye_id'])) {
    header('Location: login.php');
    exit;
}

// URL'den gelen kitap ID'sini al
// isset() ile kontrol edilir, yoksa 0 yapılır
// (int) ile integer'a çevrilir (güvenlik için)
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Oturumdaki kullanıcı ID'sini al
$uye_id = $_SESSION['uye_id'];

// Prepared Statement ile kitabı sil
// WHERE koşulunda hem id hem uye_id kontrol edilir
// Bu sayede kullanıcı sadece kendi kitaplarını silebilir (güvenlik)
$stmt = mysqli_prepare($conn, "DELETE FROM kitaplar WHERE id = ? AND uye_id = ?");

// 2 parametre bağla ('ii' = iki integer)
mysqli_stmt_bind_param($stmt, 'ii', $id, $uye_id);

// Sorguyu çalıştır (kitap silinir)
mysqli_stmt_execute($stmt);

// Ana sayfaya yönlendir
header('Location: index.php');
exit;