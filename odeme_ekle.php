<?php
include 'baglanti.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme Bilgisi Girişi</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
            color: #2c3e50;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23000000' fill-opacity='0.05'%3E%3Cpath d='M50 20c16.569 0 30 13.431 30 30 0 16.569-13.431 30-30 30-16.569 0-30-13.431-30-30 0-16.569 13.431-30 30-30zm0 10c-11.046 0-20 8.954-20 20s8.954 20 20 20 20-8.954 20-20-8.954-20-20-20zm0 5c8.284 0 15 6.716 15 15s-6.716 15-15 15-15-6.716-15-15 6.716-15 15-15zm0 25c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10z'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: repeat;
            opacity: 0.3;
            pointer-events: none;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>💰 Ödeme Bilgisi Girişi</h2>
        
        <form method="POST" action="odeme_ekle.php">
            <div class="form-group">
                <label for="id">Öğrenci Seçin</label>
                <select id="id" name="id" required>
                    <?php
                    // Öğrencileri çekmek için SQL sorgusu
                    $sql = "SELECT id, ad, soyad FROM ogrenciler WHERE silindi = 0";
                    $result = $conn->query($sql);
                    
                    // Öğrencileri dropdown olarak listele
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='".$row['id']."'>".$row['ad']." ".$row['soyad']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tutar">Tutar</label>
                <input type="number" id="tutar" name="tutar" required>
            </div>

            <div class="form-group">
                <label for="tarih">Tarih</label>
                <input type="date" id="tarih" name="tarih" required>
            </div>

            <div class="form-group">
                <label for="odeme_durumu">Ödeme Durumu</label>
                <select id="odeme_durumu" name="odeme_durumu" required>
                    <option value="ödendi">Ödendi ✅</option>
                    <option value="ödenmedi">Ödenmedi ❌</option>
                </select>
            </div>

            <div class="form-group">
                <label for="aciklama">Açıklama</label>
                <input type="text" id="aciklama" name="aciklama" required placeholder="Ödeme ile ilgili açıklama girin">
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">💾 Kaydet</button>
                <a href="index.html" class="btn btn-secondary">🏠 Ana Sayfa</a>
            </div>
        </form>
    </div>

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
</body>
</html>
