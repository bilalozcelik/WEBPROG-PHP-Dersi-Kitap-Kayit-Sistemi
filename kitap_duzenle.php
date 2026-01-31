<?php
// PHP başlangıcı
// Oturum başlatılır
session_start();
include 'db.php';
// Koşul kontrolü
if (!isset($_SESSION['uye_id'])) { header('Location: login.php'); exit; }
// Değişken tanımı
$uye_id = $_SESSION['uye_id'];
// Değişken tanımı
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kaydı getir
// Değişken tanımı
$stmt = mysqli_prepare($conn, "SELECT id, kitap_adi, yazar, tarih FROM kitaplar WHERE id = ? AND uye_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $id, $uye_id);
mysqli_stmt_execute($stmt);
// Değişken tanımı
$res = mysqli_stmt_get_result($stmt);
// Değişken tanımı
$kitap = mysqli_fetch_assoc($res);
// Koşul kontrolü
if (!$kitap) { header('Location: index.php'); exit; }

// Koşul kontrolü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Değişken tanımı
    $kitap_adi = esc($_POST['kitap_adi']);
// Değişken tanımı
    $yazar = esc($_POST['yazar']);
// Değişken tanımı
    $tarih = $_POST['tarih'] ? esc($_POST['tarih']) : null;

// Değişken tanımı
    $up = mysqli_prepare($conn, "UPDATE kitaplar SET kitap_adi = ?, yazar = ?, tarih = ? WHERE id = ? AND uye_id = ?");
    mysqli_stmt_bind_param($up, 'sssii', $kitap_adi, $yazar, $tarih, $id, $uye_id);
    mysqli_stmt_execute($up);
    header('Location: index.php'); exit;
}

include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4>Kitabı Düzenle</h4>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kitap Adı</label>
            <input class="form-control" name="kitap_adi" value="<?= htmlspecialchars($kitap['kitap_adi']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Yazar</label>
            <input class="form-control" name="yazar" value="<?= htmlspecialchars($kitap['yazar']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Yayın Tarihi</label>
            <input class="form-control" name="tarih" type="date" value="<?= $kitap['tarih'] ?>">
          </div>
          <button class="btn btn-primary">Güncelle</button>
          <a href="index.php" class="btn btn-link">Geri</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>// PHP başlangıcı
