<?php
include 'baglanti.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brans_id = $_POST['brans_id'];
    $gun = $_POST['gun'];
    $saat = $_POST['saat'];
    $sinif_id = $_POST['sinif_id'];

    // Aynı sınıf, gün ve saatte başka bir ders var mı kontrol et
    $check_sql = "SELECT * FROM ders_programi WHERE sinif_id = '$sinif_id' AND gun = '$gun' AND saat = '$saat'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>
            alert('Bu sınıfta seçilen gün ve saatte başka bir ders bulunmaktadır!');
            window.location.href = 'ders_programi_ekle1.php';
        </script>";
    } else {
        $sql = "INSERT INTO ders_programi (brans_id, gun, saat, sinif_id) 
                VALUES ('$brans_id', '$gun', '$saat', '$sinif_id')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Ders programı başarıyla eklendi.');
                window.location.href = 'ders_programi_listele.php';
            </script>";
        } else {
            echo "<script>
                alert('Hata: " . $conn->error . "');
                window.location.href = 'ders_programi_ekle1.php';
            </script>";
        }
    }
}
?> 