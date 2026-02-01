<?php
/**
 * KULLANICI KAYIT SAYFASI
 * Yeni kullanıcıların sisteme kaydolmasını sağlar
 */

// Veritabanı bağlantı dosyası dahil edilir
include 'db.php';

// Form gönderildi mi kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Formdan gelen verileri al ve güvenli hale getir
  $kullanici_adi = esc($_POST['kullanici_adi']);
  $ad_soyad = esc($_POST['ad_soyad']);
  $email = esc($_POST['email']);

  // password_hash() fonksiyonu ile şifre güvenli bir şekilde şifrelenir (hash'lenir)
  // PASSWORD_DEFAULT = PHP'nin önerdiği en güvenli algoritma (şu an bcrypt)
  // Şifre asla düz metin olarak veritabanına kaydedilmez!
  $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);

  // Prepared Statement ile yeni kullanıcıyı veritabanına ekle
  // 4 parametre var: kullanici_adi, ad_soyad, email, sifre
  $stmt = mysqli_prepare($conn, "INSERT INTO uyeler (kullanici_adi, ad_soyad, email, sifre) VALUES (?, ?, ?, ?)");

  // Parametreleri bağla ('ssss' = 4 tane string parametre)
  mysqli_stmt_bind_param($stmt, 'ssss', $kullanici_adi, $ad_soyad, $email, $sifre);

  // Sorguyu çalıştır
  if (mysqli_stmt_execute($stmt)) {
    // Kayıt başarılıysa giriş sayfasına yönlendir
    header('Location: login.php');
    exit;
  } else {
    // Hata varsa (örneğin aynı kullanıcı adı zaten varsa) hata mesajı göster
    $hata = "Kayıt sırasında hata: " . mysqli_error($conn);
  }
}

// Sayfa üst kısmını dahil et
include 'header.php';
?>

<!-- KAYIT FORMU -->
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-3">Kayıt Ol</h4>

        <!-- Hata varsa göster -->
        <?php if (isset($hata)): ?>
          <div class="alert alert-danger"><?= $hata ?></div>
        <?php endif; ?>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kullanıcı Adı</label>
            <!-- required = bu alan zorunlu -->
            <input class="form-control" name="kullanici_adi" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Ad Soyad</label>
            <!-- required yok = bu alan opsiyonel -->
            <input class="form-control" name="ad_soyad">
          </div>

          <div class="mb-3">
            <label class="form-label">E-posta</label>
            <!-- type="email" = geçerli e-posta formatı kontrolü yapar -->
            <input class="form-control" name="email" type="email">
          </div>

          <div class="mb-3">
            <label class="form-label">Şifre</label>
            <input class="form-control" name="sifre" type="password" required>
          </div>

          <button class="btn btn-primary">Kayıt Ol</button>

          <!-- Giriş sayfasına link -->
          <a href="login.php" class="btn btn-link">Zaten üyeyim</a>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
// Sayfa alt kısmını dahil et
include 'footer.php';
?>