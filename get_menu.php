<?php
include 'koneksi.php';

$kategori = $_GET['kategori'] ?? 'utama';

switch ($kategori) {
    case 'paket':
        $sql = "SELECT id_paket AS id, nama_paket AS nama, harga, gambar, 'paket' AS tipe
                FROM menu_paket WHERE status='tersedia'";
        break;

    case 'minuman':
        $sql = "SELECT id_minuman AS id, nama_minuman AS nama, harga, gambar, 'minuman' AS tipe
                FROM minuman WHERE status='tersedia'";
        break;

    case 'cemilan':
        $sql = "SELECT id_cemilan AS id, nama_cemilan AS nama, harga, gambar, 'cemilan' AS tipe
                FROM cemilan WHERE status='tersedia'";
        break;

    default:
        $sql = "SELECT id_hidangan AS id, nama_menu AS nama, harga, gambar, 'hidangan' AS tipe
                FROM hidangan_utama WHERE status='tersedia'";
}

$data = mysqli_query($koneksi, $sql);

$result = [];
while ($row = mysqli_fetch_assoc($data)) {
    $result[] = $row;
}

echo json_encode($result);
