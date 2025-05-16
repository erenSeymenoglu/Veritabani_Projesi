<?php
include 'baglanti.php';

if (isset($_GET['sil'])) {
    $sil_id = intval($_GET['sil']);
    $conn->query("UPDATE siniflar SET silindi = 1 WHERE id = $sil_id");
    header("Location: sinif_listele.php");
    exit;
}

// Arama filtresi
$arama = isset($_GET['arama']) ? trim($_GET['arama']) : '';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sınıf Listesi</title>
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
            position: relative;
            z-index: 1;
        }

        table { 
            border-collapse: collapse; 
            width: 90%; 
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 12px; 
            text-align: center;
            background-color: white; 
        }
        th { 
            background-color: white;
            color: #2c3e50;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        tr {
            background-color: white;
        }
        .btn { text-decoration: none; padding: 6px 12px; margin: 4px; border-radius: 4px; color: white; }
        .sil-btn { background-color: red; }
        .arama-form { width: 90%; text-align: right; margin: 20px auto; }
        .arama-form input[type="text"] { padding: 6px; width: 200px; }
        .arama-form button { padding: 6px 10px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">📚 Sınıf Listesi</h2>

<div class="arama-form">
    <form method="GET" action="">
        <input type="text" name="arama" placeholder="Sınıf, eğitmen veya öğrenci ara..." value="<?= htmlspecialchars($arama) ?>">
        <button type="submit">Ara</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Sınıf Adı</th>
            <th>Eğitmen</th>
            <th>Öğrenciler</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM siniflar WHERE silindi = 0";
        $result = $conn->query($sql);

        $bulundu = false;

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $egitmen_id = intval($row['egitmen_id']);
                $egitmen_query = $conn->query("SELECT ad, soyad FROM egitmenler WHERE id = $egitmen_id");
                $egitmen = $egitmen_query->fetch_assoc();
                $egitmen_adsoyad = $egitmen ? $egitmen['ad'] . ' ' . $egitmen['soyad'] : 'Bilinmiyor';

                $ogrenci_adsoyadlar = [];
                $ogrenci_ids = json_decode($row['ogrenci_ids'], true);
                if (is_array($ogrenci_ids)) {
                    foreach ($ogrenci_ids as $ogr_id) {
                        $ogrenci_query = $conn->query("SELECT ad, soyad FROM ogrenciler WHERE id = " . intval($ogr_id));
                        if ($ogrenci = $ogrenci_query->fetch_assoc()) {
                            $ogrenci_adsoyadlar[] = $ogrenci['ad'] . ' ' . $ogrenci['soyad'];
                        }
                    }
                }
                $ogrenciler = implode(", ", $ogrenci_adsoyadlar);

                // Arama filtresi kontrolü
                if ($arama !== '') {
                    $arama_lower = mb_strtolower($arama, 'UTF-8');
                    $sinif_adi_lower = mb_strtolower($row['sinif_adi'], 'UTF-8');
                    $egitmen_lower = mb_strtolower($egitmen_adsoyad, 'UTF-8');
                    $ogrenciler_lower = mb_strtolower($ogrenciler, 'UTF-8');

                    if (
                        strpos($sinif_adi_lower, $arama_lower) === false &&
                        strpos($egitmen_lower, $arama_lower) === false &&
                        strpos($ogrenciler_lower, $arama_lower) === false
                    ) {
                        continue; // Eşleşmiyorsa atla
                    }
                }

                $bulundu = true;
        ?>
        <tr>
            <td><?= htmlspecialchars($row['sinif_adi']) ?></td>
            <td><?= htmlspecialchars($egitmen_adsoyad) ?></td>
            <td><?= htmlspecialchars($ogrenciler) ?></td>
            <td>
                <a href="?sil=<?= $row['id'] ?>" class="btn sil-btn" onclick="return confirm('Bu sınıfı silmek istediğinizden emin misiniz?')">🗑️ Sil</a>
            </td>
        </tr>
        <?php endwhile; endif; ?>

        <?php if (!$bulundu): ?>
        <tr><td colspan="4">Aramaya uygun sınıf bulunamadı.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 20px;">
    <a href="index.html" class="btn" style="background-color: #3498db;">🏠 Ana Sayfaya Dön</a>
</div>

</body>
</html>
