<?php
session_start();
require 'db_baglanti.php';

// Sadece adminler erişebilir
if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] !== 'admin') {
    header('Location: dashboard.php'); // Yetkisiz erişimi engelle
    exit;
}

$mesaj = "";

// --- CRUD İŞLEMLERİ ---

// 1. YENİ ÜYE EKLEME (CREATE)
if (isset($_POST['uye_ekle'])) {
    $kulad = trim($_POST['kulad']);
    $sifre = trim($_POST['sifre']); // **GÜVENLİK UYARISI: GERÇEK PROJEDE HASH KULLANIN!**
    $rol = $_POST['rol'];
    $status = $_POST['status'];

    try {
        $sql = "INSERT INTO users (kulad, sifre, rol, status) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$kulad, $sifre, $rol, $status]);
        $mesaj = "✅ Yeni üye başarıyla eklendi!";
    } catch (PDOException $e) {
        $mesaj = "❌ Üye eklenirken hata oluştu (Kullanıcı adı zaten var olabilir): " . $e->getMessage();
    }
}

// 2. ÜYE DURUM/ROL GÜNCELLEME (UPDATE)
if (isset($_POST['guncelle'])) {
    $id = (int)$_POST['user_id'];
    $rol = $_POST['rol'];
    $status = $_POST['status'];

    try {
        $sql = "UPDATE users SET rol = ?, status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rol, $status, $id]);
        $mesaj = "✅ Üye bilgisi başarıyla güncellendi!";
    } catch (PDOException $e) {
        $mesaj = "❌ Güncelleme hatası: " . $e->getMessage();
    }
}

// 3. ÜYELERİ LİSTELEME (READ)
$stmt = $pdo->query("SELECT id, kulad, rol, status FROM users ORDER BY id");
$kullanicilar = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Üye Yönetimi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .mesaj { padding: 10px; margin-bottom: 20px; border: 1px solid; }
        .aktif { color: green; font-weight: bold; }
        .pasif { color: orange; }
        .engelli { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>👥 Üye Yönetimi</h1>
    <p><a href="dashboard.php">← Ana Sayfaya Dön</a></p>
    <hr>

    <?php if ($mesaj): ?>
        <div class="mesaj"><?php echo $mesaj; ?></div>
    <?php endif; ?>

        <h3>Yeni Üye Ekle</h3>
    <form method="POST" action="uye_yonetimi.php">
        <input type="text" name="kulad" placeholder="Kullanıcı Adı" required>
        <input type="password" name="sifre" placeholder="Şifre" required>
        <select name="rol" required>
            <option value="uye">Üye</option>
            <option value="admin">Admin</option>
        </select>
        <select name="status" required>
            <option value="aktif">Aktif</option>
            <option value="pasif">Pasif</option>
            <option value="engelli">Engelli</option>
        </select>
        <button type="submit" name="uye_ekle">Üye Ekle</button>
    </form>

    <hr>

        <h3>Mevcut Kullanıcılar</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kullanıcı Adı</th>
                <th>Rol</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kullanicilar as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['kulad']); ?></td>
                <form method="POST" action="uye_yonetimi.php">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <td>
                        <select name="rol">
                            <option value="uye" <?php echo $user['rol'] == 'uye' ? 'selected' : ''; ?>>Üye</option>
                            <option value="admin" <?php echo $user['rol'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </td>
                    <td>
                        <select name="status" class="<?php echo $user['status']; ?>">
                            <option value="aktif" <?php echo $user['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="pasif" <?php echo $user['status'] == 'pasif' ? 'selected' : ''; ?>>Pasif</option>
                            <option value="engelli" <?php echo $user['status'] == 'engelli' ? 'selected' : ''; ?>>Engelli</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit" name="guncelle">Güncelle</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>