<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

/* ================= CEK LOGIN ================= */
$id_user = $_SESSION['id_user'] ?? 0;
if ($id_user == 0) {
    echo json_encode(["jumlah" => 0]);
    exit;
}

/* ================= DATA DARI JS ================= */
$nama  = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
$harga = intval($_POST['harga'] ?? 0);
$aksi  = $_POST['aksi'] ?? '';
$type  = $_POST['type'] ?? '';

/* ================= TENTUKAN TABEL ================= */
switch ($type) {
    case 'hidangan':
        $q = mysqli_query($koneksi,
            "SELECT id_hidangan AS id, id_kategori 
             FROM hidangan_utama 
             WHERE nama_menu='$nama'"
        );
        $field = 'id_hidangan';
        break;

    case 'paket':
        $q = mysqli_query($koneksi,
            "SELECT id_paket AS id, id_kategori 
             FROM menu_paket 
             WHERE nama_paket='$nama'"
        );
        $field = 'id_paket';
        break;

    case 'minuman':
        $q = mysqli_query($koneksi,
            "SELECT id_minuman AS id, id_kategori 
             FROM minuman 
             WHERE nama_minuman='$nama'"
        );
        $field = 'id_minuman';
        break;

    case 'cemilan':
        $q = mysqli_query($koneksi,
            "SELECT id_cemilan AS id, id_kategori 
             FROM cemilan 
             WHERE nama_cemilan='$nama'"
        );
        $field = 'id_cemilan';
        break;

    default:
        echo json_encode(["jumlah" => 0]);
        exit;
}

/* ================= VALIDASI MENU ================= */
$menu = mysqli_fetch_assoc($q);
if (!$menu) {
    echo json_encode(["jumlah" => 0]);
    exit;
}

$id_menu     = $menu['id'];
$id_kategori = $menu['id_kategori'];

/* ================= CEK CART USER ================= */
$cek = mysqli_query($koneksi,
    "SELECT jumlah FROM detail_pemesanan
     WHERE id_user=$id_user AND $field=$id_menu"
);

if (mysqli_num_rows($cek) > 0) {

    if ($aksi === 'plus') {
        mysqli_query($koneksi,
            "UPDATE detail_pemesanan
             SET jumlah = jumlah + 1
             WHERE id_user=$id_user AND $field=$id_menu"
        );
    } else {
        mysqli_query($koneksi,
            "UPDATE detail_pemesanan
             SET jumlah = GREATEST(jumlah - 1, 0)
             WHERE id_user=$id_user AND $field=$id_menu"
        );
    }

} else {

    if ($aksi === 'plus') {
        mysqli_query($koneksi,
            "INSERT INTO detail_pemesanan
             (id_user, id_kategori, $field, nama, harga, jumlah)
             VALUES ($id_user, $id_kategori, $id_menu, '$nama', $harga, 1)"
        );
    }
}

/* ================= JUMLAH TERBARU ================= */
$row = mysqli_fetch_assoc(
    mysqli_query($koneksi,
        "SELECT jumlah FROM detail_pemesanan
         WHERE id_user=$id_user AND $field=$id_menu"
    )
);

echo json_encode([
    "jumlah" => $row['jumlah'] ?? 0
]);
