CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    kulad VARCHAR(50) NOT NULL UNIQUE,
    sifre VARCHAR(255) NOT NULL, -- Şifreler HASH'lenmiş olarak tutulmalı!
    rol ENUM('admin', 'uye') NOT NULL DEFAULT 'uye', -- Kullanıcı rolleri
    email VARCHAR(100)
);

-- Örnek Kullanıcılar Ekleme (gerçek projede hash'lenmiş şifre kullanın!)
INSERT INTO users (kulad, sifre, rol) VALUES
('admin_kullanici', 'admin123', 'admin'), -- Bu, gerçek projede HASH'lenmeli
('normal_uye', 'uye456', 'uye');         -- Bu, gerçek projede HASH'lenmeli