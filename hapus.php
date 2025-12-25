<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi,
    "DELETE FROM detail_pemesanan WHERE id_detail='$id'");

header("Location: Pemesanan.php");
exit;
