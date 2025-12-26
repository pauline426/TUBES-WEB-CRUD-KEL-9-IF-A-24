<?php
include 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ids']) || !is_array($data['ids'])) {
    echo json_encode(['status'=>'error','message'=>'Data tidak valid']);
    exit;
}

$ids = array_map('intval', $data['ids']);
$idList = implode(',', $ids);

mysqli_query($koneksi,
    "DELETE FROM detail_pemesanan WHERE id_detail IN ($idList)"
);

echo json_encode(['status'=>'success']);
