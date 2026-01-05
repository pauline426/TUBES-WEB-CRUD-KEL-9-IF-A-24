<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

$id_user = $_SESSION['id_user'] ?? 0;
if ($id_user == 0) {
    echo json_encode([]);
    exit;
}

$data = [];

$q = mysqli_query($koneksi,
    "SELECT nama, jumlah 
     FROM detail_pemesanan 
     WHERE id_user = $id_user"
);

while ($row = mysqli_fetch_assoc($q)) {
    $data[$row['nama']] = (int)$row['jumlah'];
}

echo json_encode($data);
