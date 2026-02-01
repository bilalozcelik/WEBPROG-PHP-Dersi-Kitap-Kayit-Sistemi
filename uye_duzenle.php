<?php
/**
 * ÜYE BİLGİLERİ DÜZENLEME SAYFASI
 * Kullanıcının kendi hesap bilgilerini güncellemesini sağlar
 */

// Oturumu başlat
session_start();

// Veritabanı bağlantısını dahil et
include 'db.php';

// Kullanıcı giriş yapmamışsa login sayfasına yönlendir
if (!isset($_SESSION['uye_id'])) {
  header('Location: login.php');
  exit;
}

// Oturumdaki kullanıcı ID'sini al
$uye_id = $_SESSION['uye_id'];

// ===== MEVCUT ÜYE BİLGİLERİNİ GETİR =====
// Prepared Statement ile kullanıcı bilgilerini çek
$stmt = mysqli_prepare($conn, "SELECT kullanici_adi, ad_soyad, email FROM uyeler WHERE id = ?");

// Parametreyi bağla ('i' = integer)
mysqli_stmt_bind_param($stmt, 'i', $uye_id);

// Sorguyu çalıştır
mysqli_stmt_execute($stmt);

// Sonuçları değişkenlere bağla
// mysqli_stmt_bind_result() ile her sütun bir değişkene atanır
mysqli_stmt_bind_result($stmt, $kadi, $adsoy, $email);

// Tek satır getir (fetch)
mysqli_stmt_fetch($stmt);

// Sonuç kümesini serbest bırak (free_result)
// Bu yapılmazsa aynı bağlantıda başka sorgu çalıştırılamaz
mysqli_stmt_free_result($stmt);

// Statement'ı kapat
mysqli_stmt_close($stmt);

// ===== FORM GÖNDERİLDİYSE GÜNCELLEME YAP =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Formdan gelen yeni bilgileri al
  $kullanici_adi = esc($_POST['kullanici_adi']);
  $ad_soyad = esc($_POST['ad_soyad']);
  $email = esc($_POST['email']);

  // Şifre alanı boş değilse (kullanıcı yeni şifre girdiyse)
  if (!empty($_POST['sifre'])) {

    // Yeni şifreyi hash'le (güvenli şekilde şifrele)
    $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);

    // UPDATE sorgusu (şifre dahil)
    $up = mysqli_prepare($conn, "UPDATE uyeler SET kullanici_adi = ?, ad_soyad = ?, email = ?, sifre = ? WHERE id = ?");

    // 5 parametre bağla ('ssssi' = 4 string, 1 integer)
    mysqli_stmt_bind_param($up, 'ssssi', $kullanici_adi, $ad_soyad, $email, $sifre, $uye_id);

  } else {
    // Şifre alanı boşsa (kullanıcı şifre değiştirmek istemiyor)

    // UPDATE sorgusu (şifre hariç)
    $up = mysqli_prepare($conn, "UPDATE uyeler SET kullanici_adi = ?, ad_soyad = ?, email = ? WHERE id = ?");

    // 4 parametre bağla ('sssi' = 3 string, 1 integer)
    mysqli_stmt_bind_param($up, 'sssi', $kullanici_adi, $ad_soyad, $email, $uye_id);
  }

  // Sorguyu çalıştır (kullanıcı bilgileri güncellenir)
  mysqli_stmt_execute($up);

  // Ana sayfaya yönlendir
  header('Location: index.php');
  exit;
}

// Sayfa üst kısmını dahil et
include 'header.php';
?>

<!-- ÜYE BİLGİLERİ DÜZENLEME FORMU -->
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4>Hesabım - Düzenle</h4>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kullanıcı Adı</label>
            <!-- value = mevcut kullanıcı adı gösterilir -->
            <!-- htmlspecialchars() = XSS saldırılarına karşı koruma -->
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
            <!-- value yok = boş başlar -->
            <!-- Kullanıcı buraya bir şey yazmazsa şifre değişmez -->
            <input class="form-control" name="sifre" type="password">
          </div>

          <button class="btn btn-primary">Bilgileri Güncelle</button>

          <!-- Hesap silme butonu -->
          <!-- onclick ile JavaScript onay penceresi gösterilir -->
          <!-- return confirm() = Kullanıcı "İptal" derse link çalışmaz -->
          <a href="uye_sil.php" class="btn btn-danger"
            onclick="return confirm('Hesabınızı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')">
            Hesabı Sil
          </a>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
// Sayfa alt kısmını dahil et
include 'footer.php';
?>