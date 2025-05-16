<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eğitmen Ekle</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
            color: #2c3e50;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        <h2>👨‍🏫 Eğitmen Ekle</h2>
        
        <form method="POST" action="egitmen_ekle.php">
            <div class="form-group">
                <label for="ad">Ad</label>
                <input type="text" id="ad" name="ad" required placeholder="Eğitmenin adını girin">
            </div>

            <div class="form-group">
                <label for="soyad">Soyad</label>
                <input type="text" id="soyad" name="soyad" required placeholder="Eğitmenin soyadını girin">
            </div>

            <div class="form-group">
                <label for="tc">TC Kimlik No</label>
                <input type="text" id="tc" name="tc" required placeholder="TC kimlik numarasını girin" pattern="[0-9]{11}" maxlength="11">
            </div>

            <div class="form-group">
                <label for="telefon">Telefon</label>
                <input type="tel" id="telefon" name="telefon" required placeholder="Telefon numarasını girin">
            </div>

            <div class="form-group">
                <label for="email">E-posta</label>
                <input type="email" id="email" name="email" required placeholder="E-posta adresini girin">
            </div>

            <div class="form-group">
                <label for="brans">Branş</label>
                <input type="text" id="brans" name="brans" required placeholder="Eğitmenin branşını girin">
            </div>

            <div class="form-group">
                <label for="adres">Adres</label>
                <input type="text" id="adres" name="adres" required placeholder="Adres bilgisini girin">
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">💾 Kaydet</button>
                <a href="index.html" class="btn btn-secondary">🏠 Ana Sayfa</a>
            </div>
        </form>
    </div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'baglanti.php';
    
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $tc = $_POST['tc'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $brans = $_POST['brans'];
    $adres = $_POST['adres'];

    $sql = "INSERT INTO egitmenler (ad, soyad, tc, telefon, email, brans, adres) 
            VALUES ('$ad', '$soyad', '$tc', '$telefon', '$email', '$brans', '$adres')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Eğitmen başarıyla eklendi.');</script>";
    } else {
        echo "<script>alert('Hata: " . $conn->error . "');</script>";
    }
}
?>
</body>
</html> 