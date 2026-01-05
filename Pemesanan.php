<?php
session_start();
include 'koneksi.php';

// Hitung total semua item
$id_user = $_SESSION['id_user'] ?? 1;
$totalQuery = mysqli_query($koneksi, "SELECT SUM(jumlah * harga) as total FROM detail_pemesanan WHERE id_user = $id_user");
$totalRow = mysqli_fetch_assoc($totalQuery);
$total_all = $totalRow['total'] ?? 0;

// Ambil semua item keranjang user
$query = mysqli_query($koneksi, "SELECT * FROM detail_pemesanan WHERE id_user = $id_user");
$items = [];
while($row = mysqli_fetch_assoc($query)) {
    $items[] = $row;
}
$item_count = count($items);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pesanan - Serba Serbi Nasi Bu Henny</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
     <link rel="stylesheet" href="style_Pemesanan.css">
</head>
<body>
    <!-- LOADING OVERLAY -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- NOTIFICATION OVERLAY -->
    <div class="notification-overlay" id="notificationOverlay">
        <div class="notification" id="notification">
            <div class="notification-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <h3 id="notificationTitle">Notification</h3>
            <p id="notificationMessage">This is a notification message.</p>
            <div class="notification-buttons" id="notificationButtons">
                <!-- Buttons will be added dynamically -->
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav>
        <div class="logo-area">
            <img src="Produk/Img/logo/logo.png" alt="Logo" class="logo">
            <span class="brand-text">Serba Serbi Nasi<br>Bu Henny</span>
        </div>
        
        <a href="menu.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Menu
        </a>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="container">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1 class="page-title">Keranjang Pesanan</h1>
            
            <?php if(isset($_GET['message'])): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($_GET['message']) ?>
                </div>
            <?php endif; ?>
            
            <!-- ACTION TOOLBAR -->
            <div class="action-toolbar">
                <div class="select-all">
                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                    <label for="selectAll">Pilih Semua</label>
                </div>

                <div class="action-buttons">
                    <a href="tambah.php" class="action-btn add-btn">
                        <i class="fas fa-plus"></i> Tambah Menu
                    </a>
                    <?php if($item_count > 0): ?>
                    <button class="action-btn delete-btn" onclick="deleteSelectedItems()">
                        <i class="fas fa-trash"></i> Hapus Terpilih
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if(empty($items)): ?>
            <!-- EMPTY CART -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Keranjang Kosong</h3>
                <p>Belum ada item dalam keranjang Anda. Yuk, pesan makanan lezat!</p>
                <a href="menu.php" class="continue-shopping">Lihat Menu</a>
            </div>
        <?php else: ?>
            <!-- CART TABLE -->
            <div class="cart-table">
                <div class="cart-header">
                    <div></div>
                    <div>Item</div>
                    <div>Harga</div>
                    <div>Jumlah</div>
                    <div>Total</div>
                    <div>Aksi</div>
                </div>
                
                <?php foreach($items as $item): 
                    $total = $item['jumlah'] * $item['harga'];
                ?>
                <div class="cart-item" data-item-id="<?= $item['id_detail'] ?>" id="item-<?= $item['id_detail'] ?>">
                    <div class="item-checkbox">
                        <input type="checkbox" class="item-checkbox-input" 
                               data-item-id="<?= $item['id_detail'] ?>"
                               onchange="toggleSelection(<?= $item['id_detail'] ?>, this)">
                    </div>
                    <div class="item-info">
                        <div class="item-details">
                            <h4><?= htmlspecialchars($item['nama']) ?></h4>
                            <div class="price">Rp <?= number_format($item['harga']) ?></div>
                        </div>
                    </div>
                    <div class="item-price">Rp <?= number_format($item['harga']) ?></div>
                   
                   <div class="qty-control">
                        <button class="minus-btn" data-id="<?= $item['id_detail'] ?>" 
                                <?= $item['jumlah'] <= 1 ? 'disabled' : '' ?>>−</button>
                        <span class="qty" id="qty-<?= $item['id_detail'] ?>"><?= $item['jumlah'] ?></span>
                        <button class="plus-btn" data-id="<?= $item['id_detail'] ?>">+</button>
                    </div>

                    <div class="item-total" id="total-<?= $item['id_detail'] ?>">Rp <?= number_format($total) ?></div>
                    <div class="item-actions">
                        <a href="edit.php?id=<?= $item['id_detail'] ?>" class="action-link edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="javascript:void(0);" class="action-link hapus"
                           onclick="deleteItem(<?= $item['id_detail'] ?>)">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="order-summary">
                <h3 class="summary-title">Ringkasan Pesanan</h3>
                <div class="summary-row">
                    <span>Subtotal (<span id="totalItems"><?= $item_count ?></span> items)</span>
                    <span id="subtotal">Rp <?= number_format($total_all) ?></span>
                </div>
                <div class="summary-row">
                    <span>Biaya Layanan</span>
                    <span>Rp 5,000</span>
                </div>
                <div class="summary-row">
                    <span>Pajak (10%)</span>
                    <span id="tax">Rp <?= number_format($total_all * 0.1) ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total Pembayaran</span>
                    <span id="grandTotal">Rp <?= number_format($total_all + 5000 + ($total_all * 0.1)) ?></span>
                </div>
                <button class="checkout-btn" onclick="checkout()">
                <i class="fas fa-check-circle"></i> Konfirmasi Pesanan
                </button>
                <p style="text-align: center; margin-top: 15px; font-size: 0.9rem; color: #666;">
                    *Pesanan akan diproses setelah konfimasi pesanan
                </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3 class="footer-brand">Serba Serbi Nasi Bu Henny</h3>
                <p>Cita rasa rumahan yang selalu dirindukan.</p>
            </div>
            <div class="footer-column">
                <h4>Hubungi Kami</h4>
                <p>📞 +62 8572 0261 642</p>
                <p>✉️ serbaserbi@gmail.com</p>
            </div>
            <div class="footer-column">
                <h4>Lokasi</h4>
                <p>📍 Jl.Pasirgede Raya,Cianjur</p>
            </div>
            <div class="footer-column">
                <h4>Jam Operasional</h4>
                <p>Senin - Jumat<br>07:00 – 20:00 WIB</p>
                <br>
                <p>Sabtu - Minggu<br>07:00 – 21:00 WIB</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Serba Serbi Nasi Bu Henny — Semua Hak Dilindungi</p>
        </div>
    </footer>

    <script src="script_Pemesanan.js">
    </script>
</body>
</html>