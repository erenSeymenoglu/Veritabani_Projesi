<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sınıf Oluşturma</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h2>Sınıf Oluşturma</h2>

  <form method="POST" action="sinif_olustur.php">
    <!-- Sınıf Adı -->
    <label>Sınıf Adı:</label>
    <input type="text" name="sinif_adi" required><br><br>

    <!-- Eğitmen Seçimi -->
   <label>Eğitmen Seçin:</label>
<select name="egitmen_id" required>
    <?php
    include 'baglanti.php';
    $sql = "SELECT id, ad, soyad FROM egitmenler";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['ad']} {$row['soyad']}</option>";
    }
    ?>
</select><br><br>

<!-- Öğrenci Seçimi -->
<label>Öğrencileri Seçin:</label><br>
<?php
$sql = "SELECT id, ad, soyad FROM ogrenciler WHERE silindi = 0";  // Silinmemiş öğrencileri çekiyoruz
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo "<label><input type='checkbox' name='ogrenci_ids[]' value='{$row['id']}'> {$row['ad']} {$row['soyad']}</label><br>";
}
?>
<br>

    <button type="submit">Sınıfı Oluştur</button>
  </form>

  <div style="margin-top: 20px;">
    <a href="index.html" class="btn-primary">🏠 Ana Sayfaya Dön</a>
  </div>
</body>
</html>
