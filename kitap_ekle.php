<?php
// PHP başlangıcı
// Oturum başlatılır
session_start();
include 'db.php';
// Koşul kontrolü
if (!isset($_SESSION['uye_id'])) { header('Location: login.php'); exit; }
// Koşul kontrolü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Değişken tanımı
    $kitap_adi = esc($_POST['kitap_adi']);
// Değişken tanımı
    $yazar = esc($_POST['yazar']);
// Değişken tanımı
    $tarih = $_POST['tarih'] ? esc($_POST['tarih']) : null;
// Değişken tanımı
    $uye_id = $_SESSION['uye_id'];

// Değişken tanımı
    $stmt = mysqli_prepare($conn, "INSERT INTO kitaplar (uye_id, kitap_adi, yazar, tarih) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'isss', $uye_id, $kitap_adi, $yazar, $tarih);
    mysqli_stmt_execute($stmt);
    header('Location: index.php'); exit;
}
include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4>Yeni Kitap Ekle</h4>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kitap Adı</label>
            <input class="form-control" name="kitap_adi" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Yazar</label>
            <input class="form-control" name="yazar" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Yayın Tarihi</label>
            <input class="form-control" name="tarih" type="date">
          </div>
          <button class="btn btn-success">Ekle</button>
          <a href="index.php" class="btn btn-link">Geri</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>// PHP başlangıcı
