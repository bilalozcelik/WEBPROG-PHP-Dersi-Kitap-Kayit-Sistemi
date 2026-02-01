<?php
/**
 * VERİTABANI BAĞLANTI DOSYASI
 * Bu dosya tüm sayfalarda kullanılacak veritabanı bağlantısını sağlar
 */

// Veritabanı sunucu adresi (genellikle localhost)
$host = "localhost";

// Veritabanı kullanıcı adı (XAMPP'te varsayılan olarak root)
$user = "root";

// Veritabanı şifresi (XAMPP'te varsayılan olarak boş)
$pass = "";

// Kullanılacak veritabanının adı
$dbname = "kitap_sistemi";

// mysqli_connect fonksiyonu ile veritabanına bağlantı kurulur
// Bu bağlantı nesnesi ($conn) diğer tüm veritabanı işlemlerinde kullanılacak
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Bağlantı başarısız olursa (!$conn = bağlantı yok ise)
if (!$conn) {
    // die() fonksiyonu programı durdurur ve hata mesajı gösterir
    // mysqli_connect_error() bağlantı hatasının detayını verir
    die("Bağlantı hatası: " . mysqli_connect_error());
}

/**
 * GÜVENLİK FONKSİYONU
 * SQL Injection ve XSS saldırılarına karşı koruma sağlar
 */
function esc($s)
{
    // global anahtar kelimesi ile fonksiyon içinde $conn değişkenine erişim sağlanır
    global $conn;

    // mysqli_real_escape_string: SQL Injection saldırılarını önler (özel karakterleri temizler)
    // htmlspecialchars: XSS saldırılarını önler (HTML etiketlerini güvenli hale getirir)
    // ENT_QUOTES: Hem tek hem çift tırnakları dönüştürür
    // UTF-8: Türkçe karakterlerin doğru çalışması için karakter seti
    return htmlspecialchars(mysqli_real_escape_string($conn, $s), ENT_QUOTES, 'UTF-8');
}
?>