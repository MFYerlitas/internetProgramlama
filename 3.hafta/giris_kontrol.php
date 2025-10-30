<?php
// Oturumu başlat
session_start();

// Veritabanı bağlantısını dahil et
require 'db_baglanti.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kulad = trim($_POST['kulad']);
    $sifre = trim($_POST['sifre']);

    // Kullanıcıyı veritabanından sorgula
    $sql = "SELECT kulad, sifre, rol FROM users WHERE kulad = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$kulad]);
    $user = $stmt->fetch();

    // Kullanıcı bulunduysa ve şifre doğruysa (GÜVENLİK NOTU geçerlidir)
    if ($user && $user['sifre'] === $sifre) { // Burası password_verify ile değişmeli!
        
        // **1. Oturumu (Session) Başlatma ve Veri Saklama**
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['kulad'] = $user['kulad'];
        $_SESSION['rol'] = $user['rol']; // Rolü oturumda saklıyoruz

        // Giriş başarılı: Kullanıcının rolüne göre yönlendir
        header('Location: dashboard.php');
        exit;
    } else {
        // Giriş başarısız
        echo "Kullanıcı adı veya şifre yanlış.";
        // İstenirse login.php'ye geri yönlendirilebilir
    }
}
?>