<?php
/**
 * HEADER (ÜST KISIM) DOSYASI
 * Tüm sayfalarda kullanılan üst menü ve HTML başlangıç kodları
 */

// Eğer oturum henüz başlatılmamışsa (PHP_SESSION_NONE = oturum yok demek)
if (session_status() === PHP_SESSION_NONE) {
  // session_start() ile kullanıcı oturumu başlatılır
  // Oturum sayesinde kullanıcı bilgileri sayfalar arası taşınabilir
  session_start();
}
?>
<!doctype html>
<html lang="tr">

<head>
  <!-- UTF-8 karakter seti ile Türkçe karakterler düzgün görüntülenir -->
  <meta charset="utf-8">

  <!-- Mobil cihazlarda responsive (duyarlı) tasarım için gerekli -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Tarayıcı sekmesinde görünecek başlık -->
  <title>Kitap Sistemi</title>

  <!-- Bootstrap CSS kütüphanesi CDN üzerinden yüklenir (hazır stil dosyası) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <!-- Üst navigasyon menüsü (navbar) -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <!-- Site logosu/başlığı - tıklanınca ana sayfaya gider -->
      <a class="navbar-brand" href="index.php">KitapSistemi</a>

      <!-- Mobil cihazlarda menüyü açıp kapatan buton -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menü öğeleri (mobilde gizlenir, butona basınca açılır) -->
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['uye_id'])): ?>
            <!-- KULLANICI GİRİŞ YAPMIŞSA GÖSTER -->
            <!-- isset() fonksiyonu değişkenin tanımlı olup olmadığını kontrol eder -->
            <!-- $_SESSION['uye_id'] varsa kullanıcı giriş yapmış demektir -->

            <li class="nav-item"><a class="nav-link" href="index.php">Kitaplarım</a></li>
            <li class="nav-item"><a class="nav-link" href="kitap_ekle.php">Kitap Ekle</a></li>
            <li class="nav-item"><a class="nav-link" href="uye_duzenle.php">Hesabım</a></li>
            <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Çıkış</a></li>

          <?php else: ?>
            <!-- KULLANICI GİRİŞ YAPMAMIŞSA GÖSTER -->

            <li class="nav-item"><a class="nav-link" href="login.php">Giriş</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Kayıt Ol</a></li>

          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Sayfa içeriğinin başlayacağı container (ana kapsayıcı) -->
  <div class="container mt-4">