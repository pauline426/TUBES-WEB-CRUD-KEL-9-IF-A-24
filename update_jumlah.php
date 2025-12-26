<?php
session_start();
include 'koneksi.php';

// ======================
// Pastikan user sudah login
// ======================
if (!isset($_SESSION['id_user'])) {
    echo json_encode(['status'=>'error','message'=>'User belum login']);
    exit;
}

$id_user = $_SESSION['id_user']; // ambil id user dari session

// ======================
// Ambil data dari request
// ======================
$data = json_decode(file_get_contents("php://input"), true);
$title = $data['title'] ?? '';
$qty = (int)($data['qty'] ?? 0);
$type = $data['type'] ?? 'utama';

// ======================
// Mapping kategori dan tabel
// ======================
$kategori_map = [
    'utama' => ['table'=>'hidangan_utama','id_col'=>'id_hidangan', 'nama_col'=>'nama_menu', 'id_kategori'=>1],
    'paket' => ['table'=>'menu_paket','id_col'=>'id_paket', 'nama_col'=>'nama_paket', 'id_kategori'=>2],
    'minuman' => ['table'=>'minuman','id_col'=>'id_minuman', 'nama_col'=>'nama_minuman', 'id_kategori'=>3],
    'cemilan' => ['table'=>'cemilan','id_col'=>'id_cemilan', 'nama_col'=>'nama_cemilan', 'id_kategori'=>4],
];

if(!isset($kategori_map[$type])){
    echo json_encode(['status'=>'error','message'=>'Tipe menu tidak valid']);
    exit;
}

$info = $kategori_map[$type];
$id_kategori = $info['id_kategori'];
$table = $info['table'];
$id_col = $info['id_col'];
$nama_col = $info['nama_col'];

// ======================
// Ambil ID item dan harga
// ======================
$sql_id = "SELECT $id_col AS id_item, harga FROM $table WHERE $nama_col='$title' LIMIT 1";
$result = mysqli_query($koneksi, $sql_id);
$row = mysqli_fetch_assoc($result);

if(!$row){
    echo json_encode(['status'=>'error','message'=>'Menu tidak ditemukan']);
    exit;
}

$id_item = $row['id_item'];
$harga = $row['harga'];

// ======================
// Update atau insert ke keranjang
// ======================
$sql_check = "SELECT * FROM detail_pemesanan WHERE id_user=$id_user AND nama='$title'";
$res_check = mysqli_query($koneksi, $sql_check);

if(mysqli_num_rows($res_check) > 0){
    if($qty > 0){
        mysqli_query($koneksi, "UPDATE detail_pemesanan SET jumlah=$qty, harga=$harga WHERE id_user=$id_user AND nama='$title'");
    } else {
        mysqli_query($koneksi, "DELETE FROM detail_pemesanan WHERE id_user=$id_user AND nama='$title'");
    }
}else{
    if($qty > 0){
        $insert_sql = "INSERT INTO detail_pemesanan (id_user, id_kategori, $id_col, nama, jumlah, harga) 
        VALUES ($id_user, $id_kategori, $id_item, '$title', $qty, $harga)";
        mysqli_query($koneksi, $insert_sql);
    }
}

echo json_encode(['status'=>'success']);
?>
