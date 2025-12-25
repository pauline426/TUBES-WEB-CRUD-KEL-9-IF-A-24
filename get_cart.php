<?php
session_start();
include 'koneksi.php';

$id_user = $_SESSION['id_user'] ?? 0;
$cart = [];

if ($id_user > 0) {
    $data = mysqli_query($koneksi,
        "SELECT nama, jumlah
         FROM detail_pemesanan
         WHERE id_user=$id_user"
    );

    while ($row = mysqli_fetch_assoc($data)) {
        $cart[$row['nama']] = $row['jumlah'];
    }
}

echo json_encode($cart);
