<?php
// PHP başlangıcı
// Oturum başlatılır
session_start();
include 'db.php';
// Koşul kontrolü
if (!isset($_SESSION['uye_id'])) {
  header('Location: login.php');
  exit;
}
// Değişken tanımı
$uye_id = $_SESSION['uye_id'];
// Değişken tanımı
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Kaydı getir
// Değişken tanımı
$stmt = mysqli_prepare($conn, "SELECT id, kitap_adi, yazar, yayin_yili FROM kitaplar WHERE id = ? AND uye_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $id, $uye_id);
mysqli_stmt_execute($stmt);
// Değişken tanımı
$res = mysqli_stmt_get_result($stmt);
// Değişken tanımı
$kitap = mysqli_fetch_assoc($res);
// Koşul kontrolü
if (!$kitap) {
  header('Location: index.php');
  exit;
}

// Koşul kontrolü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Değişken tanımı
  $kitap_adi = esc($_POST['kitap_adi']);
  // Değişken tanımı
  $yazar = esc($_POST['yazar']);
  // Değişken tanımı
  $yayin_yili = $_POST['yayin_yili'] ? (int) esc($_POST['yayin_yili']) : null;

  // Değişken tanımı
  $up = mysqli_prepare($conn, "UPDATE kitaplar SET kitap_adi = ?, yazar = ?, yayin_yili = ? WHERE id = ? AND uye_id = ?");
  mysqli_stmt_bind_param($up, 'sssii', $kitap_adi, $yazar, $yayin_yili, $id, $uye_id);
  mysqli_stmt_execute($up);
  header('Location: index.php');
  exit;
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
            <label class="form-label">Yayın Yılı</label>
            <input class="form-control" name="yayin_yili" type="number" min="1000" max="2100"
              value="<?= $kitap['yayin_yili'] ?>">
          </div>
          <button class="btn btn-primary">Güncelle</button>
          <a href="index.php" class="btn btn-link">Geri</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>// PHP başlangıcı