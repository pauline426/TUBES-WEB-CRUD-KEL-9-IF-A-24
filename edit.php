<?php
include 'koneksi.php';

$id = $_GET['id'];

/* =======================
   PROSES UPDATE (PINDAH KE ATAS)
   ======================= */
if (isset($_POST['update'])) {
    $nama   = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $harga  = $_POST['harga'];

    mysqli_query($koneksi, "
        UPDATE detail_pemesanan SET
        nama='$nama',
        jumlah='$jumlah',
        harga='$harga'
        WHERE id_detail='$id'
    ");

    header("Location: Pemesanan.php");
    exit;
}

/* =======================
   AMBIL DATA
   ======================= */
$data = mysqli_query($koneksi,
    "SELECT * FROM detail_pemesanan WHERE id_detail='$id'");
$row = mysqli_fetch_assoc($data);

$menu = mysqli_query($koneksi, "
    SELECT nama_menu AS nama, harga FROM hidangan_utama
    UNION ALL
    SELECT nama_paket AS nama, harga FROM menu_paket
    UNION ALL
    SELECT nama_minuman AS nama, harga FROM minuman
    UNION ALL
    SELECT nama_cemilan AS nama, harga FROM cemilan
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Pemesanan</title>
</head>
<body>

<h2>Edit Pemesanan</h2>

<form method="post">

    Pilih Menu <br>
    <select name="nama" id="menu" onchange="setHarga()" required>
        <?php while($m = mysqli_fetch_assoc($menu)) { ?>
            <option value="<?= $m['nama'] ?>"
                data-harga="<?= $m['harga'] ?>"
                <?= ($m['nama'] == $row['nama']) ? 'selected' : '' ?>>
                <?= $m['nama'] ?> - Rp <?= number_format($m['harga']) ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

    Harga <br>
    <input type="number" name="harga" id="harga"
           value="<?= $row['harga'] ?>" readonly><br><br>

    Jumlah <br>
    <input type="number" name="jumlah" id="jumlah"
           value="<?= $row['jumlah'] ?>" min="1"
           oninput="hitungTotal()"><br><br>

    Total <br>
    <input type="number" id="total" readonly><br><br>

    <button type="submit" name="update">Update</button>
    <a href="Pemesanan.php">Batal</a>
</form>

<script>
function setHarga() {
    let menu = document.getElementById("menu");
    let harga = menu.options[menu.selectedIndex].getAttribute("data-harga");
    document.getElementById("harga").value = harga;
    hitungTotal();
}

function hitungTotal() {
    let harga = document.getElementById("harga").value;
    let jumlah = document.getElementById("jumlah").value;
    document.getElementById("total").value = harga * jumlah;
}

hitungTotal();
</script>

</body>
</html>
