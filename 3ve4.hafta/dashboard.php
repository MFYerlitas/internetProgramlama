<?php
session_start();

// Giriş yapılmamışsa login sayfasına yönlendir
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    header('Location: login.php');
    exit;
}

$kullanici_adi = $_SESSION['kulad'];
$kullanici_rolu = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Anasayfa</title>
</head>
<body>

    <h1>✅ Hoşgeldin, <?php echo htmlspecialchars($kullanici_adi); ?>!</h1>
    <p>Oturum başarılı. Rolünüz: **<?php echo htmlspecialchars($kullanici_rolu); ?>**</p>

    <hr>

    <?php if ($kullanici_rolu === 'admin'): ?>
        <h3>👑 Admin Panel İçeriği</h3>
        <p>Sadece yöneticilerin görebileceği özel raporlar veya ayarlar burada yer alır.</p>
    <?php else: // Rol 'uye' ise ?>
        <h3>👤 Üye Sayfası İçeriği</h3>
        <p>Tüm üyelerin erişebileceği standart kullanıcı içeriği buradadır.</p>
    <?php endif; ?>

    <hr>
    <p><a href="cikis.php">Güvenli Çıkış (Logout)</a></p>

</body>
</html>