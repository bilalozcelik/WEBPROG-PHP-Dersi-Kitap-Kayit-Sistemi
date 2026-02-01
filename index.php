<?php
/**
 * ANA SAYFA (KİTAPLARIM)
 * Kullanıcının eklediği kitapları listeler
 */

// Oturumu başlat
session_start();

// Veritabanı bağlantısını dahil et
include 'db.php';

// Kullanıcı giriş yapmamışsa (oturumda uye_id yoksa)
if (!isset($_SESSION['uye_id'])) {
  // Giriş sayfasına yönlendir
  header('Location: login.php');
  exit; // Kodun devam etmemesi için
}

// Oturumdaki kullanıcı ID'sini al
$uye_id = $_SESSION['uye_id'];

// Prepared Statement ile sadece bu kullanıcıya ait kitapları getir
// ORDER BY created_at DESC = En yeni eklenen kitaplar önce gelsin
$stmt = mysqli_prepare($conn, "SELECT id, kitap_adi, yazar, yayin_yili FROM kitaplar WHERE uye_id = ? ORDER BY created_at DESC");

// Parametreyi bağla ('i' = integer tipinde parametre)
mysqli_stmt_bind_param($stmt, 'i', $uye_id);

// Sorguyu çalıştır
mysqli_stmt_execute($stmt);

// Sonuçları al (birden fazla satır olabilir)
$result = mysqli_stmt_get_result($stmt);

// Sayfa üst kısmını dahil et
include 'header.php';
?>

<!-- SAYFA BAŞLIĞI VE YENİ KİTAP EKLE BUTONU -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Kitaplarım</h3>
  <div>
    <a href="kitap_ekle.php" class="btn btn-success">Yeni Kitap Ekle</a>
  </div>
</div>

<!-- KİTAPLAR LİSTESİ -->
<div class="card shadow-sm">
  <div class="card-body">
    <?php if (mysqli_num_rows($result) == 0): ?>
      <!-- mysqli_num_rows() = Sonuç kümesindeki satır sayısını verir -->
      <!-- Eğer 0 ise hiç kitap yok demektir -->
      <p>Henüz eklenmiş kitap yok.</p>

    <?php else: ?>
      <!-- Kitaplar varsa tablo halinde göster -->
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Kitap Adı</th>
              <th>Yazar</th>
              <th>Yıl</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <!-- mysqli_fetch_assoc() = Sonraki satırı associative array (ilişkisel dizi) olarak getirir -->
              <!-- while döngüsü tüm satırlar bitene kadar devam eder -->

              <tr>
                <!-- $row['id'] = Kitabın ID'si -->
                <td><?= $row['id'] ?></td>

                <!-- htmlspecialchars() = XSS saldırılarına karşı koruma -->
                <td><?= htmlspecialchars($row['kitap_adi']) ?></td>
                <td><?= htmlspecialchars($row['yazar']) ?></td>

                <!-- Yayın yılı (boş olabilir) -->
                <td><?= $row['yayin_yili'] ?></td>

                <td>
                  <!-- Düzenle butonu - kitap_duzenle.php?id=X şeklinde ID gönderilir -->
                  <a class="btn btn-sm btn-primary" href="kitap_duzenle.php?id=<?= $row['id'] ?>">Düzenle</a>

                  <!-- Sil butonu - onclick ile JavaScript onay penceresi gösterilir -->
                  <!-- return confirm() = Kullanıcı "İptal" derse link çalışmaz -->
                  <a class="btn btn-sm btn-danger" href="kitap_sil.php?id=<?= $row['id'] ?>"
                    onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                </td>
              </tr>

            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    <?php endif; ?>
  </div>
</div>

<?php
// Sayfa alt kısmını dahil et
include 'footer.php';
?>