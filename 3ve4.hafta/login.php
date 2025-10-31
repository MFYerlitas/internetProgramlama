<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Girişi</title>
</head>
<body>

    <h2>Kullanıcı Giriş Sayfası</h2>

    <form action="giris_kontrol.php" method="POST">
        <label for="kulad">Kullanıcı Adı:</label>
        <input type="text" id="kulad" name="kulad" required><br><br>

        <label for="sifre">Şifre:</label>
        <input type="password" id="sifre" name="sifre" required><br><br>

        <button type="submit">Giriş Yap</button>
    </form>

</body>
</html>