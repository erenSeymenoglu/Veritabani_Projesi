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
