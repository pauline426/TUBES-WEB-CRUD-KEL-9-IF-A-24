<?php
$conn = mysqli_connect("localhost", "root", "", "warung_nasi");
if (!$conn) {
    die("Koneksi gagal" . mysqli_connect_error());
}
