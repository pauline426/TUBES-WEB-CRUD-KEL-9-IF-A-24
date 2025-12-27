<?php
session_start();
include 'koneksi.php';

$id_user = $_SESSION['id_user'] ?? 1;

// Ambil semua menu dari berbagai tabel
$menu = mysqli_query($koneksi, "
    SELECT 'hidangan_utama' as tipe, nama_menu AS nama, harga FROM hidangan_utama
    UNION ALL
    SELECT 'paket' as tipe, nama_paket AS nama, harga FROM menu_paket
    UNION ALL
    SELECT 'minuman' as tipe, nama_minuman AS nama, harga FROM minuman
    UNION ALL
    SELECT 'cemilan' as tipe, nama_cemilan AS nama, harga FROM cemilan
    ORDER BY tipe, nama
");

// Cek struktur tabel detail_pemesanan
$check_table = mysqli_query($koneksi, "DESCRIBE detail_pemesanan");
$columns = [];
while($col = mysqli_fetch_assoc($check_table)) {
    $columns[] = $col['Field'];
}

if (isset($_POST['simpan'])) {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jumlah = intval($_POST['jumlah']);
    $harga  = intval($_POST['harga']);

    // cek apakah menu sudah ada di keranjang user ini
    $cek = mysqli_query($koneksi,
        "SELECT * FROM detail_pemesanan 
         WHERE nama='$nama' AND id_user='$id_user'");
    
    if (mysqli_num_rows($cek) > 0) {
        // jika sudah ada maakaa tambah jumlah
        $row = mysqli_fetch_assoc($cek);
        $jumlah_baru = $row['jumlah'] + $jumlah;

        mysqli_query($koneksi, "
            UPDATE detail_pemesanan SET
            jumlah='$jumlah_baru'
            WHERE nama='$nama' AND id_user='$id_user'
        ");
        
        $message = "Jumlah $nama berhasil ditambahkan";
    } else {
        // jika belum ada → insert baru
        // Cek apakah kolom id_menu ada
        if (in_array('id_menu', $columns)) {
            // Jika ada kolom id_menu, kita perlu cari ID menu sebenarnya
            // Tapi karena tidak ada ID, kita bisa set 0 atau NULL
            $id_menu = 0;
            mysqli_query($koneksi, "
                INSERT INTO detail_pemesanan (id_user, id_menu, nama, jumlah, harga)
                VALUES ('$id_user', '$id_menu', '$nama', '$jumlah', '$harga')
            ");
        } else {
            // Jika tidak ada kolom id_menu
            mysqli_query($koneksi, "
                INSERT INTO detail_pemesanan (id_user, nama, jumlah, harga)
                VALUES ('$id_user', '$nama', '$jumlah', '$harga')
            ");
        }
        
        $message = "$nama berhasil ditambahkan ke keranjang";
    }

    header("Location: Pemesanan.php?message=" . urlencode($message));
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Serba Serbi Nasi Bu Henny</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fff7ef;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .back-btn {
            padding: 10px 25px;
            background: #ff7a00;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            background: #ff9a2a;
            transform: scale(1.05);
        }

        .page-title {
            color: #7a3e00;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #555;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 12px;
            font-size: 1rem;
            transition: border 0.3s;
            background: #fff;
        }

        .form-control:focus {
            border-color: #ff7a00;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.2);
        }

        select.form-control {
            height: 50px;
            cursor: pointer;
        }

        .readonly {
            background: #f9f9f9;
            cursor: not-allowed;
        }

        .price-display {
            font-size: 1.2rem;
            color: #ff7a00;
            font-weight: bold;
            padding: 10px 0;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
        }

        .qty-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background: #ff7a00;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .qty-btn:hover:not(:disabled) {
            background: #ff9a2a;
            transform: scale(1.1);
        }

        .qty-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .qty-display {
            min-width: 80px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #7a3e00;
            padding: 10px 20px;
            background: #fff8ef;
            border-radius: 10px;
            border: 2px solid #ffd8b4;
        }

        .total-section {
            background: #fff8ef;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            border: 2px solid #ffd8b4;
            text-align: center;
        }

        .total-label {
            color: #666;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .total-amount {
            font-size: 2rem;
            font-weight: bold;
            color: #ff7a00;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            margin-top: 40px;
        }

        .btn {
            flex: 1;
            padding: 18px;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-save {
            background: #4CAF50;
            color: white;
        }

        .btn-save:hover {
            background: #45a049;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-cancel {
            background: #f5f5f5;
            color: #666;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: #e0e0e0;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .container {
                padding: 25px;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .qty-control {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="page-title">Tambah Menu ke Keranjang</h1>
            <a href="Pemesanan.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form method="post" id="tambahForm">
            <div class="form-group">
                <label>Pilih Menu</label>
                <select name="nama" id="menu" class="form-control" onchange="setHarga()" required>
                    <option value="">-- Pilih Menu --</option>
                    <?php 
                   
                    mysqli_data_seek($menu, 0);
                    while($m = mysqli_fetch_assoc($menu)) { 
                        $harga = $m['harga'];
                    ?>
                        <option value="<?= htmlspecialchars($m['nama']) ?>" 
                                data-harga="<?= $harga ?>">
                            <?= htmlspecialchars($m['nama']) ?> - Rp <?= number_format($harga) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Harga Satuan</label>
                <div class="price-display">
                    Rp <span id="hargaDisplay">0</span>
                </div>
                <input type="hidden" name="harga" id="harga">
            </div>
            
            <div class="form-group">
                <label>Jumlah</label>
                <div class="qty-control">
                    <button type="button" class="qty-btn" id="decreaseQty" disabled>-</button>
                    <span class="qty-display" id="quantity">1</span>
                    <button type="button" class="qty-btn" id="increaseQty">+</button>
                </div>
                <input type="hidden" name="jumlah" id="jumlah" value="1">
            </div>
            
            <div class="total-section">
                <div class="total-label">Total Harga</div>
                <div class="total-amount" id="totalPrice">Rp 0</div>
            </div>
            
            <div class="action-buttons">
                <button type="submit" name="simpan" class="btn btn-save">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
                <a href="Pemesanan.php" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        let quantity = 1;
        let harga = 0;
        
        function setHarga() {
            const menu = document.getElementById("menu");
            const selectedOption = menu.options[menu.selectedIndex];
            harga = selectedOption.getAttribute("data-harga") || 0;
            
            document.getElementById("harga").value = harga;
            document.getElementById("hargaDisplay").textContent = 
                parseInt(harga).toLocaleString('id-ID');
            
            updateTotal();
            
           
            if (harga > 0) {
                document.getElementById('decreaseQty').disabled = quantity <= 1;
                document.getElementById('increaseQty').disabled = false;
            }
        }
        
        function updateTotal() {
            const total = quantity * harga;
            document.getElementById('totalPrice').textContent = 
                'Rp ' + total.toLocaleString('id-ID');
        }
        
        document.getElementById('increaseQty').addEventListener('click', function() {
            quantity++;
            document.getElementById('quantity').textContent = quantity;
            document.getElementById('jumlah').value = quantity;
            document.getElementById('decreaseQty').disabled = false;
            updateTotal();
        });
        
        document.getElementById('decreaseQty').addEventListener('click', function() {
            if (quantity > 1) {
                quantity--;
                document.getElementById('quantity').textContent = quantity;
                document.getElementById('jumlah').value = quantity;
                
                if (quantity === 1) {
                    this.disabled = true;
                }
                updateTotal();
            }
        });
        
       
        document.addEventListener('DOMContentLoaded', function() {
            const menu = document.getElementById('menu');
            if (menu.value) {
                setHarga();
            }
        });
    </script>
</body>
</html>