<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "warung_nasi";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
