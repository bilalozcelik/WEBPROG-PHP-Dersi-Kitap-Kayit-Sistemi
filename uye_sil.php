<?php
/**
 * ÜYE SİLME SAYFASI
 * Kullanıcının kendi hesabını tamamen silmesini sağlar
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

// Oturumdaki kullanıcı ID'sini al
$uye_id = $_SESSION['uye_id'];

// ÖNEMLİ NOT: Üye silindiğinde ilişkili kitaplar otomatik olarak silinir
// Bunun nedeni veritabanında "ON DELETE CASCADE" ayarının olmasıdır
// Bu ayar sayesinde bir üye silindiğinde o üyeye ait tüm kitaplar da otomatik silinir

// Prepared Statement ile üyeyi sil
$stmt = mysqli_prepare($conn, "DELETE FROM uyeler WHERE id = ?");

// Parametreyi bağla ('i' = integer)
mysqli_stmt_bind_param($stmt, 'i', $uye_id);

// Sorguyu çalıştır (üye ve ilişkili kitaplar silinir)
mysqli_stmt_execute($stmt);

// Oturumdaki tüm değişkenleri temizle
session_unset();

// Oturumu tamamen yok et
session_destroy();

// Kayıt sayfasına yönlendir (hesap silindi, yeniden kayıt olabilir)
header('Location: register.php');
exit;