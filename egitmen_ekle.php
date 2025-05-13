<?php
include 'baglanti.php';

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $brans = $_POST['brans'];
    $telefon = $_POST['telefon'];

    // Veritabanına veri ekleme işlemi
    $sql = "INSERT INTO egitmenler (ad, soyad, brans, telefon)
            VALUES ('$ad', '$soyad', '$brans', '$telefon')";

    if ($conn->query($sql) === TRUE) {
        $mesaj = "✅ Eğitmen başarıyla eklendi.";
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
    <title>Eğitmen Ekleme İşlemi</title>
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

<a href="egitmen_ekle.html" class="btn">⬅️ Önceki Sayfaya Dön</a>

</body>
</html>
