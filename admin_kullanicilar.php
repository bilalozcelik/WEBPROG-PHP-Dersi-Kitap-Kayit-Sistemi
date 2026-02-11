<?php
/**
 * ADMİN - KULLANICI YÖNETİM SAYFASI
 * Sadece adminlerin erişebildiği, tüm kullanıcıların listelendiği sayfa
 */

// Oturumu başlat
session_start();

// Veritabanı bağlantısı
include 'db.php';

// Güvenlik Kontrolü: Giriş yapılmamışsa veya admin değilse erişimi engelle
if (!isset($_SESSION['uye_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: login.php');
    exit;
}

// Tüm kullanıcıları getir (Kendisi hariç listelemek daha iyi olabilir ama basitlik için hepsini çekelim)
$sorgu = "SELECT id, kullanici_adi, ad_soyad, email, rol, created_at FROM uyeler ORDER BY created_at DESC";
$sonuc = mysqli_query($conn, $sorgu);

include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Kullanıcı Yönetimi</h4>
    <span class="badge bg-primary">Toplam:
        <?= mysqli_num_rows($sonuc) ?> Kullanıcı
    </span>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Yetki</th>
                    <th>Kayıt Tarihi</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($uye = mysqli_fetch_assoc($sonuc)): ?>
                    <tr>
                        <td>
                            <?= $uye['id'] ?>
                        </td>
                        <td><strong>
                                <?= htmlspecialchars($uye['kullanici_adi']) ?>
                            </strong></td>
                        <td>
                            <?= htmlspecialchars($uye['ad_soyad'] ?: '-') ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($uye['email'] ?: '-') ?>
                        </td>
                        <td>
                            <?php if ($uye['rol'] == 1): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Üye</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= date('d.m.Y H:i', strtotime($uye['created_at'])) ?>
                        </td>
                        <td class="text-end">
                            <?php if ($uye['id'] != $_SESSION['uye_id']): ?>
                                <!-- Kendi hesabını silmesini engellemek için kontrol -->
                                <a href="admin_kullanici_sil.php?id=<?= $uye['id'] ?>" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Bu kullanıcıyı ve tüm kitaplarını silmek istediğinize emin misiniz?')">
                                    Sil
                                </a>
                            <?php else: ?>
                                <small class="text-muted italic">Siz</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>