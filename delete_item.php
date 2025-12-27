<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id_user = $_SESSION['id_user'] ?? 1;
    
    // Verifikasi bahwa item milik user ini
    $check = mysqli_query($koneksi, 
        "SELECT * FROM detail_pemesanan 
         WHERE id_detail = $id AND id_user = $id_user");
    
    if (mysqli_num_rows($check) === 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Item tidak ditemukan'
        ]);
        exit;
    }
    
    $delete = mysqli_query($koneksi, "DELETE FROM detail_pemesanan WHERE id_detail = $id");
    
    if ($delete) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Item berhasil dihapus'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menghapus item'
        ]);
    }
}
?>