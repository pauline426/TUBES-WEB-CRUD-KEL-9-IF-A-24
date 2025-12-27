<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id_user = $_SESSION['id_user'] ?? 1;

if (!isset($data['ids']) || !is_array($data['ids'])) {
    echo json_encode(['status'=>'error','message'=>'Data tidak valid']);
    exit;
}

$ids = array_map('intval', $data['ids']);
$idList = implode(',', $ids);

// Hapus hanya item yang dimiliki oleh user ini
mysqli_query($koneksi,
    "DELETE FROM detail_pemesanan 
     WHERE id_detail IN ($idList) AND id_user = $id_user"
);

echo json_encode(['status'=>'success']);
?>