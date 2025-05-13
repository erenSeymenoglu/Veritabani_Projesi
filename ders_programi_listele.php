<?php
include 'baglanti.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Ders Programı Listesi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th, td {
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
    }
    .btn {
      padding: 8px 15px;
      background-color: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <h2>Ders Programı Listesi</h2>

  <table>
    <thead>
      <tr>
        <th>Gün</th>
        <th>Saat</th>
        <th>Ders (Branş)</th>
        <th>Eğitmen Adı</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // INNER JOIN ile ders_programi tablosunu egitmenler ile birleştir
      $sql = "SELECT dp.gun, dp.saat, e.brans, e.ad, e.soyad 
              FROM ders_programi dp 
              INNER JOIN egitmenler e ON dp.brans_id = e.id 
              ORDER BY dp.gun, dp.saat";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>".$row['gun']."</td>
                      <td>".$row['saat']."</td>
                      <td>".$row['brans']."</td>
                      <td>".$row['ad']." ".$row['soyad']."</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='4'>Henüz bir ders programı eklenmemiş.</td></tr>";
      }

      $conn->close();
      ?>
    </tbody>
  </table>

  <div style="text-align: center; margin-top: 20px;">
    <a href="index.html" class="btn">🏠 Ana Sayfa</a>
  </div>

</body>
</html>
