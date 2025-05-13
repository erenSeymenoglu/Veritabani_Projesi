<?php
include 'baglanti.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ödeme Bilgisi Girişi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h2>Ödeme Bilgisi Girişi</h2>

  <form method="POST" action="odeme_ekle.php">
    
    <label>Öğrenci Seçin:</label>
    <select name="id" required>
        <!-- PHP ile öğrencileri getir -->
        <?php
        // Öğrencileri çekmek için SQL sorgusu
        $sql = "SELECT id, ad, soyad FROM ogrenciler WHERE silindi = 0";
        $result = $conn->query($sql);
        
        // Öğrencileri dropdown olarak listele
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['id']."'>".$row['ad']." ".$row['soyad']."</option>";
        }
        ?>
    </select><br>

    <label>Tutar:</label><input type="number" name="tutar" required><br>

    <label>Tarih:</label><input type="date" name="tarih" required><br>
    
    <label>Ödeme Durumu:</label>
    <select name="odeme_durumu" required>
        <option value="ödendi">Ödendi ✅</option>
        <option value="ödenmedi">Ödenmedi ❌</option>
    </select><br>

    <label>Açıklama:</label><input type="text" name="aciklama" required><br>

    <button type="submit">Kaydet</button>
  </form>

  <div style="margin-top: 20px; text-align: left;">
    <a href="index.html" class="btn-primary" style="display: inline-block; text-decoration: none;">🏠 Ana Sayfaya Dön</a>
  </div>

</body>
</html>

<?php
// Veritabanına ödeme bilgisi ekleme
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Öğrenciyi ID ile seçiyoruz
    $tutar = $_POST['tutar'];
    $tarih = $_POST['tarih'];
    $odeme_durumu = $_POST['odeme_durumu'];
    $aciklama = $_POST['aciklama'];

    // Ödeme bilgilerini ekle
    $sql = "INSERT INTO odemeler (ogrenci_id, tutar, tarih, odeme_durumu, aciklama) 
            VALUES ('$id', '$tutar', '$tarih', '$odeme_durumu', '$aciklama')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Ödeme başarıyla kaydedildi.');</script>";
    } else {
        echo "<script>alert('Hata: " . $conn->error . "');</script>";
    }
}
?>
