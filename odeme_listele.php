<?php
include 'baglanti.php';

// Ödeme silme (soft delete)
if (isset($_GET['sil'])) {
    $sil_id = intval($_GET['sil']);
    $conn->query("UPDATE odemeler SET silindi = 1 WHERE id = $sil_id");
    header("Location: odeme_listele.php");
    exit;
}

// Arama işlemi
$arama = '';
$filtre_sql = '';
if (isset($_GET['arama']) && $_GET['arama'] !== '') {
    $arama = $conn->real_escape_string($_GET['arama']);
    $filtre_sql = "WHERE (ad LIKE '%$arama%' OR soyad LIKE '%$arama%' OR aciklama LIKE '%$arama%')";
}

$sql = "SELECT * FROM view_odeme_ogrenci $filtre_sql";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ödeme Listesi</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            text-decoration: none;
            padding: 6px 12px;
            margin: 4px;
            border-radius: 4px;
            color: white;
        }
        .sil-btn {
            background-color: red;
        }
        .duzenle-btn {
            background-color: green;
        }
        .arama-formu {
            width: 80%;
            margin: 10px auto;
            text-align: right;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">📋 Ödeme Listesi</h2>

<!-- Arama Kutusu -->
<div class="arama-formu">
    <form method="get" action="odeme_listele.php">
        <input type="text" name="arama" placeholder="Ad, Soyad veya Açıklama" value="<?= htmlspecialchars($arama) ?>" style="padding:6px; width:200px;">
        <button type="submit" style="padding:6px 12px;">Ara</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Öğrenci Adı</th>
            <th>Tutar</th>
            <th>Tarih</th>
            <th>Ödeme Durumu</th>
            <th>Açıklama</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['ad']) . " " . htmlspecialchars($row['soyad']) ?></td>
                <td><?= htmlspecialchars($row['tutar']) ?> ₺</td>
                <td><?= htmlspecialchars($row['tarih']) ?></td>
                <td><?= htmlspecialchars($row['odeme_durumu']) ?></td>
                <td><?= htmlspecialchars($row['aciklama']) ?></td>
                <td>
                    <a href="?sil=<?= $row['odeme_id'] ?>" class="btn sil-btn" onclick="return confirm('Bu ödemeyi silmek istediğinizden emin misiniz?')">🗑️ Sil</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Kayıtlı ödeme bulunamadı.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 20px;">
    <a href="index.html" class="btn" style="background-color: #3498db;">🏠 Ana Sayfaya Dön</a>
</div>

</body>
</html>
