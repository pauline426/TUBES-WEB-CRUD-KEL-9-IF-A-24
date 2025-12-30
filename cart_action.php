<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

$id_user = $_SESSION['id_user'] ?? 0;
if ($id_user == 0) {
    echo json_encode(['jumlah' => 0]);
    exit;
}

$aksi = $_POST['aksi'] ?? '';
$type = $_POST['type'] ?? '';
$nama = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');

/* ================= AMBIL MENU DARI DB ================= */
switch ($type) {
    case 'hidangan':
        $menuQ = mysqli_query($koneksi,
            "SELECT id_hidangan AS id, id_kategori, harga 
             FROM hidangan_utama WHERE nama_menu='$nama'"
        );
        $field = 'id_hidangan';
        break;

    case 'paket':
        $menuQ = mysqli_query($koneksi,
            "SELECT id_paket AS id, id_kategori, harga 
             FROM menu_paket WHERE nama_paket='$nama'"
        );
        $field = 'id_paket';
        break;

    case 'minuman':
        $menuQ = mysqli_query($koneksi,
            "SELECT id_minuman AS id, id_kategori, harga 
             FROM minuman WHERE nama_minuman='$nama'"
        );
        $field = 'id_minuman';
        break;

    case 'cemilan':
        $menuQ = mysqli_query($koneksi,
            "SELECT id_cemilan AS id, id_kategori, harga 
             FROM cemilan WHERE nama_cemilan='$nama'"
        );
        $field = 'id_cemilan';
        break;

    default:
        echo json_encode(['jumlah' => 0]);
        exit;
}

$menu = mysqli_fetch_assoc($menuQ);
if (!$menu) {
    echo json_encode(['jumlah' => 0]);
    exit;
}

$id_menu = $menu['id'];
$id_kategori = $menu['id_kategori'];
$harga = $menu['harga'];

/* ================= CEK ITEM USER ================= */
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
             SET jumlah = jumlah - 1
             WHERE id_user=$id_user AND $field=$id_menu AND jumlah > 0"
        );

        mysqli_query($koneksi,
            "DELETE FROM detail_pemesanan
             WHERE id_user=$id_user AND $field=$id_menu AND jumlah <= 0"
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

/* ================= KIRIM JUMLAH TERBARU ================= */
$hasil = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT jumlah FROM detail_pemesanan
     WHERE id_user=$id_user AND $field=$id_menu"
));

echo json_encode([
    'jumlah' => $hasil['jumlah'] ?? 0
]);
