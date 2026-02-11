CREATE DATABASE IF NOT EXISTS kitap_sistemi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kitap_sistemi;

CREATE TABLE IF NOT EXISTS uyeler (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kullanici_adi VARCHAR(50) UNIQUE NOT NULL,
  ad_soyad VARCHAR(100),
  email VARCHAR(100),
  sifre VARCHAR(255) NOT NULL,
<<<<<<< HEAD
=======
  rol INT DEFAULT 0, -- 0: Kullanıcı, 1: Admin
>>>>>>> 9637f3e (Admin yönetimi ve kullanıcı silme özellikleri eklendi)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS kitaplar (
  id INT AUTO_INCREMENT PRIMARY KEY,
  uye_id INT NOT NULL,
  kitap_adi VARCHAR(150),
  yazar VARCHAR(150),
  yayin_yili INT(4),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (uye_id) REFERENCES uyeler(id) ON DELETE CASCADE
);