<?php
$servername = "localhost";
$username = "root";
$password = ""; // Wamp kullanıyoruz boş
$dbname = "surucu_kursu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}
?>

