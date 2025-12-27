<?php
session_start();
include 'koneksi.php';

$id_detail = $_GET['id'] ?? 0;
$id_user = $_SESSION['id_user'] ?? 1;

// PROSES UPDATE JIKA ADA POST
if (isset($_POST['update'])) {
    $jumlah = intval($_POST['jumlah']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    
    mysqli_query($koneksi, "
        UPDATE detail_pemesanan SET
        nama = '$nama',
        jumlah = $jumlah
        WHERE id_detail = $id_detail AND id_user = $id_user
    ");
    
    header("Location: Pemesanan.php?message=Item berhasil diperbarui");
    exit;
}

// Get item details
$query = mysqli_query($koneksi, 
    "SELECT * FROM detail_pemesanan 
     WHERE id_detail = $id_detail AND id_user = $id_user");
$item = mysqli_fetch_assoc($query);

if(!$item) {
    header('Location: Pemesanan.php');
    exit;
}

// GET DAFTAR SEMUA MENU DARI SEMUA TABEL
$allMenus = [];

// 1. Ambil dari hidangan_utama
$queryHidangan = mysqli_query($koneksi, "SELECT id_hidangan, nama_menu, harga FROM hidangan_utama");
while($menu = mysqli_fetch_assoc($queryHidangan)) {
    $allMenus[] = [
        'type' => 'hidangan',
        'id' => $menu['id_hidangan'],
        'nama' => $menu['nama_menu'],
        'harga' => $menu['harga']
    ];
}

// 2. Ambil dari menu_paket
$queryPaket = mysqli_query($koneksi, "SELECT id_paket, nama_paket, harga FROM menu_paket");
while($menu = mysqli_fetch_assoc($queryPaket)) {
    $allMenus[] = [
        'type' => 'paket',
        'id' => $menu['id_paket'],
        'nama' => $menu['nama_paket'],
        'harga' => $menu['harga']
    ];
}

// 3. Ambil dari minuman
$queryMinuman = mysqli_query($koneksi, "SELECT id_minuman, nama_minuman, harga FROM minuman");
while($menu = mysqli_fetch_assoc($queryMinuman)) {
    $allMenus[] = [
        'type' => 'minuman',
        'id' => $menu['id_minuman'],
        'nama' => $menu['nama_minuman'],
        'harga' => $menu['harga']
    ];
}

// 4. Ambil dari cemilan
$queryCemilan = mysqli_query($koneksi, "SELECT id_cemilan, nama_cemilan, harga FROM cemilan");
while($menu = mysqli_fetch_assoc($queryCemilan)) {
    $allMenus[] = [
        'type' => 'cemilan',
        'id' => $menu['id_cemilan'],
        'nama' => $menu['nama_cemilan'],
        'harga' => $menu['harga']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item - Serba Serbi Nasi Bu Henny</title>
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
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
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #555;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            transition: border 0.3s;
        }

        .form-control:focus {
            border-color: #ff7a00;
            outline: none;
        }

        select.form-control {
            cursor: pointer;
            background: white;
        }

        .menu-type {
            font-size: 0.85rem;
            color: #666;
            background: #f0f0f0;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 10px;
        }

        .menu-info {
            background: #fff8ef;
            padding: 10px 15px;
            border-radius: 10px;
            margin-top: 5px;
            border: 1px solid #ffd8b4;
            font-size: 0.9rem;
        }

        .menu-info .harga {
            color: #ff7a00;
            font-weight: bold;
            margin-left: 10px;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }

        .qty-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: none;
            background: #ff7a00;
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .qty-btn:hover {
            background: #ff9a2a;
            transform: scale(1.1);
        }

        .qty-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .qty-display {
            min-width: 60px;
            text-align: center;
            font-size: 1.3rem;
            font-weight: bold;
            color: #7a3e00;
        }

        .total-price {
            background: #fff8ef;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
            border: 2px solid #ffd8b4;
        }

        .total-price .label {
            color: #666;
            font-size: 0.9rem;
        }

        .total-price .amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff7a00;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 30px;
            font-size: 1rem;
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
        }

        .btn-cancel {
            background: #f5f5f5;
            color: #666;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background: #e0e0e0;
        }

        @media (max-width: 576px) {
            .container {
                padding: 30px 20px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .back-btn {
                position: relative;
                top: 0;
                left: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <a href="Pemesanan.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="container">
        <div class="header">
            <h1 class="page-title">Edit Item</h1>
            <p>Ubah menu dan jumlah</p>
        </div>

        <form method="post" id="editForm">
            <input type="hidden" name="id_detail" value="<?= $item['id_detail'] ?>">
            
            <div class="form-group">
                <label>Pilih Menu</label>
                <select name="nama" id="menuSelect" class="form-control" required>
                    <option value="">-- Pilih Menu --</option>
                    <?php foreach($allMenus as $menu): 
                        $selected = ($item['nama'] == $menu['nama']) ? 'selected' : '';
                    ?>
                    <option value="<?= htmlspecialchars($menu['nama']) ?>" 
                            data-harga="<?= $menu['harga'] ?>"
                            <?= $selected ?>>
                        <?= htmlspecialchars($menu['nama']) ?> 
                        <span class="menu-type"><?= ucfirst($menu['type']) ?></span>
                    </option>
                    <?php endforeach; ?>
                </select>
                <div class="menu-info">
                    Harga terpilih: <span id="selectedPrice">Rp <?= number_format($item['harga']) ?></span>
                </div>
            </div>
            
            <div class="form-group">
                <label>Jumlah</label>
                <div class="qty-control">
                    <button type="button" class="qty-btn" id="decreaseQty" 
                            <?= $item['jumlah'] <= 1 ? 'disabled' : '' ?>>-</button>
                    <input type="hidden" name="jumlah" id="jumlahInput" value="<?= $item['jumlah'] ?>">
                    <span class="qty-display" id="quantity"><?= $item['jumlah'] ?></span>
                    <button type="button" class="qty-btn" id="increaseQty">+</button>
                </div>
            </div>
            
            <div class="total-price">
                <div class="label">Total Harga</div>
                <div class="amount" id="totalPrice">
                    Rp <?= number_format($item['jumlah'] * $item['harga']) ?>
                </div>
            </div>
            
            <div class="action-buttons">
                <button type="submit" name="update" class="btn btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="Pemesanan.php" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        let quantity = <?= $item['jumlah'] ?>;
        let price = <?= $item['harga'] ?>;
        
        // Fungsi update harga total
        function updateTotalPrice() {
            const total = quantity * price;
            document.getElementById('totalPrice').textContent = 
                'Rp ' + total.toLocaleString('id-ID');
            
            // Update hidden input
            document.getElementById('jumlahInput').value = quantity;
            
            document.getElementById('decreaseQty').disabled = quantity <= 1;
        }
        
        // Event listener untuk dropdown menu
        document.getElementById('menuSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value !== "") {
                price = parseInt(selectedOption.getAttribute('data-harga'));
                document.getElementById('selectedPrice').textContent = 
                    'Rp ' + price.toLocaleString('id-ID');
                updateTotalPrice();
            }
        });
        
        // Event listener untuk tombol jumlah
        document.getElementById('increaseQty').addEventListener('click', function() {
            quantity++;
            document.getElementById('quantity').textContent = quantity;
            updateTotalPrice();
        });
        
        document.getElementById('decreaseQty').addEventListener('click', function() {
            if (quantity > 1) {
                quantity--;
                document.getElementById('quantity').textContent = quantity;
                updateTotalPrice();
            }
        });
        
        
        updateTotalPrice();
    </script>
</body>
</html>