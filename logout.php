<?php
/**
 * ÇIKIŞ SAYFASI
 * Kullanıcının oturumunu sonlandırır ve giriş sayfasına yönlendirir
 */

// Oturumu başlat (sonlandırmak için önce başlatmak gerekir)
session_start();

// session_unset() = Oturumdaki tüm değişkenleri temizler ($_SESSION dizisini boşaltır)
session_unset();

// session_destroy() = Oturumu tamamen yok eder (sunucudaki oturum dosyasını siler)
session_destroy();

// Kullanıcıyı giriş sayfasına yönlendir
header('Location: login.php');

// Kodun devam etmemesi için programı sonlandır
exit;