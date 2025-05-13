<?php
include 'baglanti.php';

// Silme işlemi (soft delete)
if (isset($_GET['sil'])) {
    $sil_id = intval($_GET['sil']);
    $conn->query("UPDATE ogrenciler SET silindi = 1 WHERE id = $sil_id");
    $conn->query("UPDATE odemeler SET silindi = 1 WHERE ogrenci_id = $sil_id");
    header("Location: ogrenci_listele.php");
    exit;
}

// Arama işlemi
$arama = '';
$filtre_sql = 'WHERE silindi = 0';
if (isset($_GET['arama']) && $_GET['arama'] !== '') {
    $arama = $conn->real_escape_string($_GET['arama']);
    $filtre_sql .= " AND (id = '$arama' OR ad LIKE '%$arama%' OR soyad LIKE '%$arama%')";
}

$sql = "SELECT * FROM ogrenciler $filtre_sql";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Öğrenci Listesi</title>
    <style>
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: center; }
        th { background-color: #f2f2f2; }
        .btn { text-decoration: none; padding: 6px 12px; margin: 4px; border-radius: 4px; color: white; }
        .sil-btn { background-color: red; }
    </style>
</head>
<body>

<h2 style="text-align:center;">👨‍🎓 Öğrenci Listesi</h2>

<!-- Arama Kutusu -->
<div style="text-align: right; width: 90%; margin: auto;">
    <form method="get" action="ogrenci_listele.php" style="display:inline;">
        <input type="text" name="arama" placeholder="ID, Ad, Soyad..." value="<?= htmlspecialchars($arama) ?>" style="padding:6px; width:200px;">
        <button type="submit" style="padding:6px 12px;">Ara</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>TC</th>
            <th>Telefon</th>
            <th>Ehliyet Sınıfı</th>
            <th>Doğum Tarihi</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr id="ogrenci_<?= $row['id'] ?>">
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['ad']) ?></td>
                    <td><?= htmlspecialchars($row['soyad']) ?></td>
                    <td><?= htmlspecialchars($row['tc']) ?></td>
                    <td><?= htmlspecialchars($row['telefon']) ?></td>
                    <td><?= htmlspecialchars($row['ehliyet_sinifi']) ?></td>
                    <td><?= htmlspecialchars($row['dogum_tarihi']) ?></td>
                    <td>
                        <a href="?sil=<?= $row['id'] ?>" class="btn sil-btn" onclick="return confirm('Bu öğrenciyi silmek istediğinizden emin misiniz?')">🗑️ Sil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">Kayıtlı öğrenci bulunamadı.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Ana Sayfa Butonu -->
<div style="text-align: center; margin-top: 20px;">
    <a href="index.html" class="btn" style="background-color: #3498db;">🏠 Ana Sayfaya Dön</a>
</div>

<!-- Scroll ve Vurgu Scripti -->
<script>
    // Eğer GET ile gelen ID varsa otomatik kaydır
    const urlParams = new URLSearchParams(window.location.search);
    const arama = urlParams.get('arama');
    if (arama && !isNaN(arama)) {
        const row = document.getElementById('ogrenci_' + arama);
        if (row) {
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            row.style.backgroundColor = '#ffff99';
            setTimeout(() => row.style.backgroundColor = '', 2000);
        }
    }
</script>

</body>
</html>
