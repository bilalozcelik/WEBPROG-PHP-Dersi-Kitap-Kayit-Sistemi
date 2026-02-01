<?php
/**
 * KİTAP DÜZENLEME SAYFASI
 * Mevcut kitap bilgilerini günceller
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

// URL'den gelen kitap ID'sini al
// isset() = değişken tanımlı mı kontrol eder
// (int) = type casting, değeri integer'a çevirir (güvenlik için)
// Eğer id yoksa 0 olarak ayarla
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// ===== DÜZENLENECEK KİTABI VERİTABANINDAN GETİR =====
// Prepared Statement ile kitabı getir
// Hem id hem de uye_id kontrolü yapılır (başka kullanıcının kitabını düzenleyemesin)
$stmt = mysqli_prepare($conn, "SELECT id, kitap_adi, yazar, yayin_yili FROM kitaplar WHERE id = ? AND uye_id = ?");

// 2 parametre bağla ('ii' = iki integer)
mysqli_stmt_bind_param($stmt, 'ii', $id, $uye_id);

// Sorguyu çalıştır
mysqli_stmt_execute($stmt);

// Sonuçları al
$res = mysqli_stmt_get_result($stmt);

// Tek satır getir (mysqli_fetch_assoc = associative array döndürür)
$kitap = mysqli_fetch_assoc($res);

// Eğer kitap bulunamadıysa (yanlış ID veya başka kullanıcının kitabı)
if (!$kitap) {
  // Ana sayfaya yönlendir
  header('Location: index.php');
  exit;
}

// ===== FORM GÖNDERİLDİYSE GÜNCELLEME YAP =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Formdan gelen yeni bilgileri al
  $kitap_adi = esc($_POST['kitap_adi']);
  $yazar = esc($_POST['yazar']);
  $yayin_yili = $_POST['yayin_yili'] ? (int) esc($_POST['yayin_yili']) : null;

  // UPDATE sorgusu ile kitap bilgilerini güncelle
  // WHERE koşulunda hem id hem uye_id kontrol edilir (güvenlik)
  $up = mysqli_prepare($conn, "UPDATE kitaplar SET kitap_adi = ?, yazar = ?, yayin_yili = ? WHERE id = ? AND uye_id = ?");

  // 5 parametre bağla
  // 'sssii' = string, string, string (veya null), integer, integer
  mysqli_stmt_bind_param($up, 'sssii', $kitap_adi, $yazar, $yayin_yili, $id, $uye_id);

  // Sorguyu çalıştır
  mysqli_stmt_execute($up);

  // Başarılıysa ana sayfaya yönlendir
  header('Location: index.php');
  exit;
}

// Sayfa üst kısmını dahil et
include 'header.php';
?>

<!-- KİTAP DÜZENLEME FORMU -->
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4>Kitabı Düzenle</h4>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kitap Adı</label>
            <!-- value = input alanının başlangıç değeri (mevcut kitap adı) -->
            <!-- htmlspecialchars() = XSS saldırılarına karşı koruma -->
            <input class="form-control" name="kitap_adi" value="<?= htmlspecialchars($kitap['kitap_adi']) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Yazar</label>
            <input class="form-control" name="yazar" value="<?= htmlspecialchars($kitap['yazar']) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Yayın Yılı</label>
            <!-- Mevcut yayın yılı value olarak gösterilir -->
            <input class="form-control" name="yayin_yili" type="number" min="1000" max="2100"
              value="<?= $kitap['yayin_yili'] ?>">
          </div>

          <button class="btn btn-primary">Güncelle</button>

          <!-- Ana sayfaya geri dön linki -->
          <a href="index.php" class="btn btn-link">Geri</a>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
// Sayfa alt kısmını dahil et
include 'footer.php';
?>