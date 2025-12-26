<?php
session_start();
include 'koneksi.php';

header('Content-Type: application/json');

// ambil id_user dari session
if (!isset($_SESSION['id_user'])) {
    echo json_encode(['status'=>'error','message'=>'User belum login']);
    exit;
}

$id_user = $_SESSION['id_user'];

$cart = [];

// ambil semua item dari detail_pemesanan untuk user ini
$query = "SELECT * FROM detail_pemesanan WHERE id_user = $id_user";
$result = mysqli_query($koneksi, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $cart[$row['nama']] = (int)$row['jumlah'];
}

echo json_encode($cart);
?>
