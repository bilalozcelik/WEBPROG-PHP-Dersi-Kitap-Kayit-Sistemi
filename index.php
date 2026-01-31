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
$stmt = mysqli_prepare($conn, "SELECT id, kitap_adi, yazar, yayin_yili FROM kitaplar WHERE uye_id = ? ORDER BY created_at DESC");
mysqli_stmt_bind_param($stmt, 'i', $uye_id);
mysqli_stmt_execute($stmt);
// Değişken tanımı
$result = mysqli_stmt_get_result($stmt);

include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Kitaplarım</h3>
  <div>
    <a href="kitap_ekle.php" class="btn btn-success">Yeni Kitap Ekle</a>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <?php if (mysqli_num_rows($result) == 0): ?>
      // PHP başlangıcı
      <p>Henüz eklenmiş kitap yok.</p>
    <?php else: ?>
      // PHP başlangıcı
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
              // PHP başlangıcı
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['kitap_adi']) ?></td>
                <td><?= htmlspecialchars($row['yazar']) ?></td>
                <td><?= $row['yayin_yili'] ?></td>
                <td>
                  <a class="btn btn-sm btn-primary" href="kitap_duzenle.php?id=<?= $row['id'] ?>">Düzenle</a>
                  <a class="btn btn-sm btn-danger" href="kitap_sil.php?id=<?= $row['id'] ?>"
                    onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                </td>
              </tr>
            <?php endwhile; ?>
            // PHP başlangıcı
          </tbody>
        </table>
      </div>
    <?php endif; ?>
    // PHP başlangıcı
  </div>
</div>

<?php include 'footer.php'; ?>// PHP başlangıcı