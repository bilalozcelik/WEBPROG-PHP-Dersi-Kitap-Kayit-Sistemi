<?php
/**
 * KULLANICI GİRİŞ SAYFASI
 * Kayıtlı kullanıcıların sisteme giriş yapmasını sağlar
 */

// Oturum başlatılır (kullanıcı bilgilerini saklamak için)
session_start();

// Veritabanı bağlantı dosyası dahil edilir
include 'db.php';

// Form gönderildi mi kontrol et (POST metodu ile veri geldi mi?)
// $_SERVER['REQUEST_METHOD'] = sayfaya nasıl erişildiğini gösterir (GET veya POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Formdan gelen kullanıcı adını al ve güvenli hale getir
  // $_POST['kullanici_adi'] = formdan gelen kullanıcı adı
  // esc() fonksiyonu ile SQL Injection ve XSS saldırılarına karşı koruma
  $kullanici_adi = esc($_POST['kullanici_adi']);

  // Formdan gelen şifreyi al (şifre hash'lenmiş olduğu için esc() kullanmaya gerek yok)
  $sifre = $_POST['sifre'];

  // Prepared Statement (Hazırlanmış Sorgu) ile veritabanından kullanıcıyı ara
  // ? işareti parametre yerine kullanılır (SQL Injection'a karşı güvenli)
  $stmt = mysqli_prepare($conn, "SELECT id, sifre FROM uyeler WHERE kullanici_adi = ?");

  // Parametreyi sorguya bağla ('s' = string tipinde parametre)
  mysqli_stmt_bind_param($stmt, 's', $kullanici_adi);

  // Sorguyu çalıştır
  mysqli_stmt_execute($stmt);

  // Sonuçları değişkenlere bağla (id ve sifre sütunları)
  mysqli_stmt_bind_result($stmt, $id, $hash);

  // Eğer kullanıcı bulunduysa (mysqli_stmt_fetch() = bir satır getir)
  if (mysqli_stmt_fetch($stmt)) {

    // password_verify() ile girilen şifre ile veritabanındaki hash'lenmiş şifre karşılaştırılır
    // Bu fonksiyon güvenli şifre kontrolü yapar
    if (password_verify($sifre, $hash)) {

      // Şifre doğruysa, kullanıcı ID'sini oturuma kaydet
      // Artık kullanıcı giriş yapmış sayılır
      $_SESSION['uye_id'] = $id;

      // Ana sayfaya yönlendir
      header('Location: index.php');
      exit; // Yönlendirmeden sonra kodun devam etmemesi için

    } else {
      // Şifre yanlışsa hata mesajı oluştur
      $hata = "Hatalı kullanıcı adı veya şifre.";
    }
  } else {
    // Kullanıcı bulunamadıysa hata mesajı oluştur
    $hata = "Hatalı kullanıcı adı veya şifre.";
  }
}

// Sayfa üst kısmını (header) dahil et
include 'header.php';
?>

<!-- GİRİŞ FORMU -->
<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-3 text-center">Giriş Yap</h4>

        <!-- Hata varsa göster -->
        <?php if (isset($hata)): ?>
          <div class="alert alert-danger"><?= $hata ?></div>
        <?php endif; ?>

        <!-- method="post" = form verileri POST ile gönderilir (güvenli) -->
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kullanıcı Adı</label>
            <!-- required = bu alan boş bırakılamaz -->
            <input class="form-control" name="kullanici_adi" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Şifre</label>
            <!-- type="password" = girilen karakterler gizlenir -->
            <input class="form-control" name="sifre" type="password" required>
          </div>

          <button class="btn btn-primary w-100">Giriş</button>
        </form>

        <!-- Kayıt sayfasına link -->
        <div class="mt-3 text-center">
          <a href="register.php">Kayıt Ol</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// Sayfa alt kısmını (footer) dahil et
include 'footer.php';
?>