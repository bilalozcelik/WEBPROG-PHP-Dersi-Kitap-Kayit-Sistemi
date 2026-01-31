<?php
// PHP başlangıcı
// Oturum başlatılır
session_start();
include 'db.php';
// Koşul kontrolü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Değişken tanımı
    $kullanici_adi = esc($_POST['kullanici_adi']);
// Değişken tanımı
    $sifre = $_POST['sifre'];

// Değişken tanımı
    $stmt = mysqli_prepare($conn, "SELECT id, sifre FROM uyeler WHERE kullanici_adi = ?");
    mysqli_stmt_bind_param($stmt, 's', $kullanici_adi);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hash);
// Koşul kontrolü
    if (mysqli_stmt_fetch($stmt)) {
// Koşul kontrolü
        if (password_verify($sifre, $hash)) {
// Değişken tanımı
            $_SESSION['uye_id'] = $id;
            header('Location: index.php');
            exit;
        } else {
// Değişken tanımı
            $hata = "Hatalı kullanıcı adı veya şifre.";
        }
    } else {
// Değişken tanımı
        $hata = "Hatalı kullanıcı adı veya şifre.";
    }
}
include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-3 text-center">Giriş Yap</h4>
        <?php if(isset($hata)): ?><div class="alert alert-danger"><?= $hata ?></div><?php endif; ?>
// PHP başlangıcı
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kullanıcı Adı</label>
            <input class="form-control" name="kullanici_adi" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Şifre</label>
            <input class="form-control" name="sifre" type="password" required>
          </div>
          <button class="btn btn-primary w-100">Giriş</button>
        </form>
        <div class="mt-3 text-center">
          <a href="register.php">Kayıt Ol</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>// PHP başlangıcı
