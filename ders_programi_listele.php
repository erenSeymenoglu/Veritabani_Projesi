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
      padding: 8px 15px;
      background-color: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <h2 style="text-align:center;">📅 Ders Programı Listesi</h2>

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
