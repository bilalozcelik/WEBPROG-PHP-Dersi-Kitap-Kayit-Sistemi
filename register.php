<?php
// PHP başlangıcı
include 'db.php';
// Koşul kontrolü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Değişken tanımı
    $kullanici_adi = esc($_POST['kullanici_adi']);
// Değişken tanımı
    $ad_soyad = esc($_POST['ad_soyad']);
// Değişken tanımı
    $email = esc($_POST['email']);
// Değişken tanımı
    $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);

// Değişken tanımı
    $stmt = mysqli_prepare($conn, "INSERT INTO uyeler (kullanici_adi, ad_soyad, email, sifre) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $kullanici_adi, $ad_soyad, $email, $sifre);
// Koşul kontrolü
    if (mysqli_stmt_execute($stmt)) {
        header('Location: login.php');
        exit;
    } else {
// Değişken tanımı
        $hata = "Kayıt sırasında hata: " . mysqli_error($conn);
    }
}
include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-3">Kayıt Ol</h4>
        <?php if(isset($hata)): ?><div class="alert alert-danger"><?= $hata ?></div><?php endif; ?>
// PHP başlangıcı
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kullanıcı Adı</label>
            <input class="form-control" name="kullanici_adi" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Ad Soyad</label>
            <input class="form-control" name="ad_soyad">
          </div>
          <div class="mb-3">
            <label class="form-label">E-posta</label>
            <input class="form-control" name="email" type="email">
          </div>
          <div class="mb-3">
            <label class="form-label">Şifre</label>
            <input class="form-control" name="sifre" type="password" required>
          </div>
          <button class="btn btn-primary">Kayıt Ol</button>
          <a href="login.php" class="btn btn-link">Zaten üyeyim</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>// PHP başlangıcı
