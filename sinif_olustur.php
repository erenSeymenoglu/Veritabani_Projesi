<?php
include 'baglanti.php';

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $sinif_adi = $_POST['sinif_adi'];
    $egitmen_id = $_POST['egitmen_id'];
    $ogrenci_ids = $_POST['ogrenci_ids'];  // Çoklu öğrenci seçimi
    $ogrenci_ids_json = json_encode($ogrenci_ids);  // Öğrenci IDs'lerini JSON formatına çeviriyoruz

    // Sınıfı kaydet
    $sql = "INSERT INTO siniflar (sinif_adi, egitmen_id, ogrenci_ids) 
            VALUES ('$sinif_adi', '$egitmen_id', '$ogrenci_ids_json')";

    if ($conn->query($sql) === TRUE) {
        $mesaj = "✅ Sınıf başarıyla oluşturuldu.";
    } else {
        $mesaj = "❌ Hata: " . $conn->error;
    }

    $conn->close();
} else {
    $mesaj = "❌ Bu sayfa sadece POST isteklerini kabul eder.";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sınıf Oluşturma İşlemi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h3><?php echo $mesaj; ?></h3>

<a href="sinif_olustur1.php" class="btn">⬅️ Önceki Sayfaya Dön</a>

</body>
</html>
