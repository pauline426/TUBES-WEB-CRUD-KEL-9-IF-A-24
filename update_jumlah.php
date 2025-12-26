<?php
include 'koneksi.php';
header('Content-Type: application/json');

if (!isset($_POST['id'], $_POST['jumlah'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Data tidak lengkap'
    ]);
    exit;
}

$id     = (int) $_POST['id'];
$jumlah = (int) $_POST['jumlah'];

if ($jumlah < 1) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Jumlah minimal 1'
    ]);
    exit;
}

/* Update jumlah */
$update = mysqli_query(
    $koneksi,
    "UPDATE detail_pemesanan SET jumlah = $jumlah WHERE id_detail = $id"
);

if (!$update) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal update jumlah'
    ]);
    exit;
}

/* Ambil harga terbaru */
$query = mysqli_query(
    $koneksi,
    "SELECT harga FROM detail_pemesanan WHERE id_detail = $id"
);

$data = mysqli_fetch_assoc($query);

echo json_encode([
    'status' => 'success',
    'harga'  => $data['harga']
]);
