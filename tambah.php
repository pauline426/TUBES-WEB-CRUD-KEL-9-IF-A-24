<?php
include 'koneksi.php';

$menu = mysqli_query($koneksi, "
    SELECT nama_menu AS nama, harga FROM hidangan_utama
    UNION ALL
    SELECT nama_paket AS nama, harga FROM menu_paket
    UNION ALL
    SELECT nama_minuman AS nama, harga FROM minuman
    UNION ALL
    SELECT nama_cemilan AS nama, harga FROM cemilan
");

if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $harga  = $_POST['harga'];

    // cek apakah menu sudah ada
    $cek = mysqli_query($koneksi,
        "SELECT * FROM detail_pemesanan WHERE nama='$nama'");
    $row = mysqli_fetch_assoc($cek);

    if ($row) {
        // jika sudah ada → tambah jumlah
        $jumlah_baru = $row['jumlah'] + $jumlah;

        mysqli_query($koneksi, "
            UPDATE detail_pemesanan SET
            jumlah='$jumlah_baru'
            WHERE nama='$nama'
        ");
    } else {
        // jika belum ada → insert baru
        mysqli_query($koneksi, "
            INSERT INTO detail_pemesanan (nama, jumlah, harga)
            VALUES ('$nama', '$jumlah', '$harga')
        ");
    }

    header("Location: Pemesanan.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah Pemesanan</title>
</head>
<body>

<h2>Tambah Pemesanan</h2>

<form method="post">
    Pilih Menu <br>
    <select name="nama" id="menu" onchange="setHarga()" required>
        <option value="">-- Pilih Menu --</option>
        <?php while($m = mysqli_fetch_assoc($menu)) { ?>
            <option value="<?= $m['nama'] ?>" data-harga="<?= $m['harga'] ?>">
                <?= $m['nama'] ?> - Rp <?= number_format($m['harga']) ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

    Harga <br>
    <input type="number" name="harga" id="harga" readonly><br><br>

    Jumlah <br>
    <input type="number" name="jumlah" id="jumlah" value="1" min="1" oninput="hitungTotal()"><br><br>

    Total <br>
    <input type="number" id="total" readonly><br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="Pemesanan.php">Kembali</a>
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
</script>

</body>
</html>
