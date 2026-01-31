<?php
// PHP başlangıcı
// Oturum başlatılır
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kitap Sistemi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">KitapSistemi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['uye_id'])): ?>
// PHP başlangıcı
          <li class="nav-item"><a class="nav-link" href="index.php">Kitaplarım</a></li>
          <li class="nav-item"><a class="nav-link" href="kitap_ekle.php">Kitap Ekle</a></li>
          <li class="nav-item"><a class="nav-link" href="uye_duzenle.php">Hesabım</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Çıkış</a></li>
        <?php else: ?>
// PHP başlangıcı
          <li class="nav-item"><a class="nav-link" href="login.php">Giriş</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Kayıt Ol</a></li>
        <?php endif; ?>
// PHP başlangıcı
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">