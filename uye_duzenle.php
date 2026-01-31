<?php
// PHP başlangıcı
// Oturum başlatılır
session_start();
include 'db.php';
// Koşul kontrolü
if (!isset($_SESSION['uye_id'])) { header('Location: login.php'); exit; }
// Değişken tanımı
$uye_id = $_SESSION['uye_id'];

// Mevcut bilgileri al
// Değişken tanımı
$stmt = mysqli_prepare($conn, "SELECT kullanici_adi, ad_soyad, email FROM uyeler WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $uye_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $kadi, $adsoy, $email);
mysqli_stmt_fetch($stmt);

// Koşul kontrolü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Değişken tanımı
    $kullanici_adi = esc($_POST['kullanici_adi']);
// Değişken tanımı
    $ad_soyad = esc($_POST['ad_soyad']);
// Değişken tanımı
    $email = esc($_POST['email']);

// Koşul kontrolü
    if (!empty($_POST['sifre'])) {
// Değişken tanımı
        $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);
// Değişken tanımı
        $up = mysqli_prepare($conn, "UPDATE uyeler SET kullanici_adi = ?, ad_soyad = ?, email = ?, sifre = ? WHERE id = ?");
        mysqli_stmt_bind_param($up, 'ssssi', $kullanici_adi, $ad_soyad, $email, $sifre, $uye_id);
    } else {
// Değişken tanımı
        $up = mysqli_prepare($conn, "UPDATE uyeler SET kullanici_adi = ?, ad_soyad = ?, email = ? WHERE id = ?");
        mysqli_stmt_bind_param($up, 'sssi', $kullanici_adi, $ad_soyad, $email, $uye_id);
    }
    mysqli_stmt_execute($up);
    header('Location: index.php'); exit;
}

include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4>Hesabım - Düzenle</h4>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kullanıcı Adı</label>
            <input class="form-control" name="kullanici_adi" value="<?= htmlspecialchars($kadi) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Ad Soyad</label>
            <input class="form-control" name="ad_soyad" value="<?= htmlspecialchars($adsoy) ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">E-posta</label>
            <input class="form-control" name="email" type="email" value="<?= htmlspecialchars($email) ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Yeni Şifre (boş bırakılırsa değişmez)</label>
            <input class="form-control" name="sifre" type="password">
          </div>
          <button class="btn btn-primary">Bilgileri Güncelle</button>
          <a href="uye_sil.php" class="btn btn-danger" onclick="return confirm('Hesabınızı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')">Hesabı Sil</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>// PHP başlangıcı
