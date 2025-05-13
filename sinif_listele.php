<?php
include 'baglanti.php';

if (isset($_GET['sil'])) {
    $sil_id = intval($_GET['sil']);

    // Soft delete işlemleri
    $conn->query("UPDATE siniflar SET silindi = 1 WHERE id = $sil_id");

    header("Location: sinif_listele.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sınıf Listesi</title>
    <style>
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: center; }
        th { background-color: #f2f2f2; }
        .btn { text-decoration: none; padding: 6px 12px; margin: 4px; border-radius: 4px; color: white; }
        .sil-btn { background-color: red; }
    </style>
</head>
<body>

<h2 style="text-align:center;">📚 Sınıf Listesi</h2>

<table>
    <thead>
        <tr>
            <th>Sınıf Adı</th>
            <th>Eğitmen ID</th>
            <th>Öğrenciler</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM siniflar WHERE silindi = 0";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                // Öğrencilerin ID'lerini al
                $ogrenci_ids = json_decode($row['ogrenci_ids']); // Varsayalım ki öğrenci IDs'leri JSON formatında
                $ogrenciler = implode(", ", $ogrenci_ids); // Öğrenci ID'lerini birleştir

        ?>
        <tr>
            <td><?= htmlspecialchars($row['sinif_adi']) ?></td>
            <td><?= htmlspecialchars($row['egitmen_id']) ?></td>
            <td><?= htmlspecialchars($ogrenciler) ?></td>
            <td>
                <a href="?sil=<?= $row['id'] ?>" class="btn sil-btn" onclick="return confirm('Bu sınıfı silmek istediğinizden emin misiniz?')">🗑️ Sil</a>
            </td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="4">Kayıtlı sınıf bulunamadı.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 20px;">
    <a href="index.html" class="btn" style="background-color: #3498db;">🏠 Ana Sayfaya Dön</a>
</div>

</body>
</html>
