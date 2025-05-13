<?php
include 'baglanti.php';

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $brans_id = $_POST['brans_id']; // Eğitmenin branşı (ders)
    $gun = $_POST['gun'];
    $saat = $_POST['saat'];
    $sinif_id = $_POST['sinif_id']; // Artık sadece ID geliyor

    // Veritabanına veri ekleme işlemi
    $sql = "INSERT INTO ders_programi (brans_id, gun, saat, sinif_id)
            VALUES ('$brans_id', '$gun', '$saat', '$sinif_id')";

    if ($conn->query($sql) === TRUE) {
        $mesaj = "✅ Ders programı başarıyla kaydedildi.";
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
    <title>Ders Programı Ekleme İşlemi</title>
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

<a href="ders_programi_ekle1.php" class="btn">⬅️ Önceki Sayfaya Dön</a>

</body>
</html>
