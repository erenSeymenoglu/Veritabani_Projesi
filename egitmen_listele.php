<?php
include 'baglanti.php';

// Silme işlemi
if (isset($_GET['sil'])) {
    $sil_id = intval($_GET['sil']);
    $conn->query("DELETE FROM egitmenler WHERE id = $sil_id");
    header("Location: egitmen_listele.php");
    exit;
}

// Arama işlemi
$arama = '';
$filtre_sql = '';
if (isset($_GET['arama']) && $_GET['arama'] !== '') {
    $arama = $conn->real_escape_string($_GET['arama']);
    $filtre_sql = "WHERE ad LIKE '%$arama%' OR soyad LIKE '%$arama%' OR brans LIKE '%$arama%'";
}

$sql = "SELECT * FROM egitmenler $filtre_sql";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Eğitmen Listesi</title>
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

<h2 style="text-align:center;">📋 Eğitmen Listesi</h2>

<!-- Arama Kutusu -->
<div class="arama-formu">
    <form method="get" action="egitmen_listele.php">
        <input type="text" name="arama" placeholder="Ad, Soyad veya Branş" value="<?= htmlspecialchars($arama) ?>" style="padding:6px; width:200px;">
        <button type="submit" style="padding:6px 12px;">Ara</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Branş</th>
            <th>Telefon</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['ad']) ?></td>
                <td><?= htmlspecialchars($row['soyad']) ?></td>
                <td><?= htmlspecialchars($row['brans']) ?></td>
                <td><?= htmlspecialchars($row['telefon']) ?></td>
                <td>
                    <a href="?sil=<?= $row['id'] ?>" class="btn sil-btn" onclick="return confirm('Bu eğitmeni silmek istediğinizden emin misiniz?')">🗑️ Sil</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Kayıtlı eğitmen bulunamadı.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 20px;">
    <a href="index.html" class="btn" style="background-color: #3498db;">🏠 Ana Sayfaya Dön</a>
</div>

</body>
</html>
