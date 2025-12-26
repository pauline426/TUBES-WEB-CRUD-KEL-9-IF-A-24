<?php
include 'koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM detail_pemesanan");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Pemesanan</title>
<style>
table {
    width: 80%;
    margin: auto;
    border-collapse: collapse;
}
th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}
th { background: #ff9800; color: white; }
a {
    padding: 6px 10px;
    color: white;
    border-radius: 4px;
    text-decoration: none;
    margin: 0 2px;
}
.tambah { background: green; }
.edit { background: blue; }
.hapus { background: red; }
</style>
</head>
<body>

<h2 align="center">Daftar Pemesanan</h2>
<div style="text-align:center; margin-bottom:10px;">
    <a href="menu.php" class="tambah">Kembali</a>
</div>
<table>
<tr>
  <th>No</th>
  <th>Nama</th>
  <th>Jumlah</th>
  <th>Harga</th>
  <th>Total</th>
  <th>Aksi</th>
</tr>

<?php $no=1; while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= $row['nama'] ?></td>
  <td><?= $row['jumlah'] ?></td>
  <td>Rp <?= number_format($row['harga']) ?></td>
  <td>Rp <?= number_format($row['jumlah'] * $row['harga']) ?></td>
  <td>
    <a href="tambah.php" class="tambah">Tambah</a>
    <a href="edit.php?id=<?= $row['id_detail'] ?>" class="edit">Edit</a>
    <a href="hapus.php?id=<?= $row['id_detail'] ?>" class="hapus"
       onclick="return confirm('Hapus data?')">Hapus</a>
  </td>
</tr>
<?php } ?>

</table>
<script>
// function loadCart: ambil data dari get_cart.php dan update tabel
function loadCart() {
    fetch('get_cart.php')
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('cart-body');
        tbody.innerHTML = '';
        data.forEach((item, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${index+1}</td>
                    <td>${item.nama}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${Number(item.harga).toLocaleString()}</td>
                    <td>Rp ${Number(item.jumlah * item.harga).toLocaleString()}</td>
                    <td>
                        <button onclick="updateQty('${item.nama}','plus')">+</button>
                        <button onclick="updateQty('${item.nama}','minus')">-</button>
                        <a href="hapus.php?id=${item.id_detail}" onclick="return confirm('Hapus data?')">Hapus</a>
                    </td>
                </tr>
            `;
        });
    });
}

// function updateQty: kirim ke cart_action.php lalu reload tabel
function updateQty(nama, aksi){
    fetch('cart_action.php', {
        method: 'POST',
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `nama=${encodeURIComponent(nama)}&aksi=${aksi}&harga=0` // harga tidak perlu untuk update
    })
    .then(res => res.json())
    .then(() => {
        loadCart(); // reload tabel setelah update
    });
}

// load tabel saat halaman pertama kali dibuka
loadCart();

// opsional: auto-refresh setiap 5 detik
setInterval(loadCart, 5000);
</script>

</body>
</html>