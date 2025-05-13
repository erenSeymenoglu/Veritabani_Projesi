<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ders Programı Seçimi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h2>Ders Programı Seçimi</h2>

  <form method="POST" action="ders_programi_ekle.php">
    
    <!-- Branş Seçimi -->
    <label>Branş (Ders) Seçin:</label>
    <select name="brans_id" required>
        <?php
        include 'baglanti.php';
        $sql = "SELECT id, brans FROM egitmenler";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['id']."'>".$row['brans']."</option>";
        }
        ?>
    </select><br>

    <!-- Gün Seçimi -->
    <label>Gün Seçin:</label>
    <select name="gun" required>
        <option value="Pazartesi">Pazartesi</option>
        <option value="Salı">Salı</option>
        <option value="Çarşamba">Çarşamba</option>
        <option value="Perşembe">Perşembe</option>
        <option value="Cuma">Cuma</option>
        <option value="Cumartesi">Cumartesi</option>
    </select><br>

    <!-- Saat Seçimi -->
    <label>Saat Seçin:</label>
    <input type="time" name="saat" required><br>

    <!-- Sınıf Seçimi -->
    <label>Sınıf Seçin:</label>
    <select name="sinif_id" required>
        <?php
        // siniflar tablosundan sınıf adlarını çekiyoruz
        $sql = "SELECT id, sinif_adi FROM siniflar";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['id']."'>".$row['sinif_adi']."</option>";
        }
        ?>
    </select><br>

    <button type="submit">Kaydet</button>
  </form>

  <div style="margin-top: 20px; text-align: left;">
    <a href="index.html" class="btn-primary" style="display: inline-block; text-decoration: none;">🏠 Ana Sayfaya Dön</a>
  </div>
</body>
</html>
