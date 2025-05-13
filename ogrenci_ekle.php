<?php
include 'baglanti.php';

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $tc = $_POST['tc'];
    $telefon = $_POST['telefon'];
    $dogum_tarihi = $_POST['dogum_tarihi'];
    $ehliyet_sinifi = $_POST['ehliyet_sinifi'];

    $sql = "INSERT INTO ogrenciler (ad, soyad, tc, telefon, dogum_tarihi, ehliyet_sinifi)
            VALUES ('$ad', '$soyad', '$tc', '$telefon', '$dogum_tarihi', '$ehliyet_sinifi')";

    if ($conn->query($sql) === TRUE) {
        $mesaj = "✅ Öğrenci başarıyla eklendi.";
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
    <title>Öğrenci Ekleme İşlemi</title>
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

<a href="ogrenci_ekle.html" class="btn">⬅️ Önceki Sayfaya Dön</a>

</body>
</html>
