<?php
/**
 * KİTAP EKLEME SAYFASI
 * Yeni kitap kaydı oluşturur
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

// Form gönderildi mi kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Formdan gelen kitap bilgilerini al ve güvenli hale getir
  $kitap_adi = esc($_POST['kitap_adi']);
  $yazar = esc($_POST['yazar']);

  // Yayın yılı opsiyonel (boş olabilir)
  // Ternary operator kullanımı: koşul ? doğruysa : yanlışsa
  // Eğer yayin_yili doluysa integer'a çevir, boşsa null yap
  $yayin_yili = $_POST['yayin_yili'] ? (int) esc($_POST['yayin_yili']) : null;

  // Oturumdaki kullanıcı ID'sini al
  $uye_id = $_SESSION['uye_id'];

  // Prepared Statement ile yeni kitap ekle
  // 4 parametre: uye_id, kitap_adi, yazar, yayin_yili
  $stmt = mysqli_prepare($conn, "INSERT INTO kitaplar (uye_id, kitap_adi, yazar, yayin_yili) VALUES (?, ?, ?, ?)");

  // Parametreleri bağla
  // 'issi' = integer, string, string, integer (veya null)
  mysqli_stmt_bind_param($stmt, 'issi', $uye_id, $kitap_adi, $yazar, $yayin_yili);

  // Sorguyu çalıştır
  mysqli_stmt_execute($stmt);

  // Başarılıysa ana sayfaya yönlendir
  header('Location: index.php');
  exit;
}

// Sayfa üst kısmını dahil et
include 'header.php';
?>

<!-- KİTAP EKLEME FORMU -->
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4>Yeni Kitap Ekle</h4>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Kitap Adı</label>
            <!-- required = bu alan zorunlu -->
            <input class="form-control" name="kitap_adi" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Yazar</label>
            <input class="form-control" name="yazar" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Yayın Yılı</label>
            <!-- type="number" = sadece sayı girişi -->
            <!-- min ve max = kabul edilen değer aralığı -->
            <!-- required yok = bu alan opsiyonel -->
            <input class="form-control" name="yayin_yili" type="number" min="1000" max="2100">
          </div>

          <button class="btn btn-success">Ekle</button>

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