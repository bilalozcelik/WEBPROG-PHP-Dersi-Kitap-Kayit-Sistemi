<?php
/**
 * ADMİN - KULLANICI SİLME İŞLEMİ
 * Belirli bir kullanıcının kaydını ve ona ait her şeyi siler
 */

// Oturumu başlat
session_start();

// Veritabanı bağlantısı
include 'db.php';

// Güvenlik Kontrolü: Giriş yapılmamışsa veya admin değilse erişimi engelle
if (!isset($_SESSION['uye_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: login.php');
    exit;
}

// Silinecek kullanıcı ID'sini URL'den al
if (isset($_GET['id'])) {
    $silinecek_id = (int) $_GET['id'];

    // Kendisini silmesini engelle
    if ($silinecek_id === (int) $_SESSION['uye_id']) {
        header('Location: admin_kullanicilar.php?hata=kendi_hesabini_silemezsin');
        exit;
    }

    // Kullanıcıyı sil (Veritabanında ON DELETE CASCADE olduğu için kitapları da otomatik silinir)
    $stmt = mysqli_prepare($conn, "DELETE FROM uyeler WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $silinecek_id);

    if (mysqli_stmt_execute($stmt)) {
        // Başarılıysa listeye geri dön
        header('Location: admin_kullanicilar.php?durum=silindi');
    } else {
        // Hata varsa geri dön
        header('Location: admin_kullanicilar.php?hata=silinemedi');
    }

    mysqli_stmt_close($stmt);
} else {
    // ID gelmemişse listeye geri dön
    header('Location: admin_kullanicilar.php');
}
exit;
