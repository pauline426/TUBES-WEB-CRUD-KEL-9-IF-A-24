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
            flex-direction: column;
        }

        /* NAVBAR */
        nav {
            width: 100%;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: transparent;
            flex-wrap: wrap;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            height: 50px;
            width: 50px;
            border-radius: 50%;
            background: #fff;
            padding: 5px;
            box-shadow: 0 0 20px rgba(255, 166, 0, 0.6), 0 0 40px rgba(255, 166, 0, 0.3);
        }

        .brand-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: #f27202;
            line-height: 1.3;
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

        /* LOADING OVERLAY */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 3000;
            display: none;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #ff7a00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* NOTIFICATION OVERLAY */
        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .notification-overlay.active {
            display: flex;
        }

        .notification {
            background: white;
            border-radius: 15px;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: slideUp 0.3s ease;
        }

        .notification-icon {
            font-size: 3rem;
            color: #ff7a00;
            margin-bottom: 15px;
        }

        .notification h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .notification p {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .notification-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .notification-btn {
            padding: 10px 25px;
            border: none;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            min-width: 100px;
        }

        .notification-btn.ok {
            background: #2196F3;
            color: white;
        }

        .notification-btn.ok:hover {
            background: #0b7dda;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* MAIN CONTENT */
        .container {
            max-width: 1200px;
            margin: 0 auto 40px;
            padding: 0 20px;
            flex: 1;
        }

        .page-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .page-title {
            color: #7a3e00;
            font-size: 2.5rem;
            margin-bottom: 20px;
            position: relative;
        }

        /* ACTION TOOLBAR */
        .action-toolbar {
            display: flex;
            background: white;
            border-radius: 20px;
            padding: 20px 30px;
            margin: 20px 0 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-btn {
            padding: 10px 25px;
            border: none;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .select-all {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            color: #7a3e00;
        }

        .select-all input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .add-btn {
            background: #4CAF50;
            color: white;
            text-decoration: none;
        }

        .add-btn:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .delete-btn {
            background: #ff4444;
            color: white;
        }

        .delete-btn:hover {
            background: #ff6666;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 68, 68, 0.4);
        }

        /* CART TABLE */
        .cart-table {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .cart-header {
            display: grid;
            grid-template-columns: 50px 2.5fr 1.2fr 1.3fr 1fr 150px;
            padding: 20px 30px;
            background: #ff7a00;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .cart-header div:nth-child(2) {
            text-align: left;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 50px 2.5fr 1.2fr 1.3fr 1fr 150px;
            align-items: center;
            padding: 25px 30px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item.selected {
            background: #fff8e1;
            border-left: 4px solid #ff7a00;
        }

        .cart-item.updating {
            opacity: 0.7;
            pointer-events: none;
        }

        .item-checkbox {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .item-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .item-img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #ff7a00;
        }

        .item-details h4 {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 5px;
        }

        .item-details .price {
            color: #ff7a00;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .item-price, .item-total {
            text-align: center;
            font-weight: 600;
            color: #7a3e00;
            font-size: 1.1rem;
        }

        .qty-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .qty-control button {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: #ff7a00;
            color: white;
            font-size: 1.4rem;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-control button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .qty-control button:hover:not(:disabled) {
            background: #ff9a2a;
            transform: scale(1.1);
        }

        .qty {
            min-width: 40px;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            color: #7a3e00;
            background: #fff8ef;
            padding: 5px 10px;
            border-radius: 8px;
            border: 1px solid #ffd8b4;
        }

        .item-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-link {
            padding: 8px 15px;
            border-radius: 20px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: 0.3s;
        }

        .action-link.edit {
            background: #2196F3;
        }

        .action-link.hapus {
            background: #ff4444;
        }

        .action-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* ORDER SUMMARY */
        .order-summary {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .summary-title {
            color: #7a3e00;
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            color: #555;
            padding: 8px 0;
        }

        .summary-row.total {
            font-size: 1.3rem;
            font-weight: bold;
            color: #7a3e00;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background: #ff7a00;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .checkout-btn:hover {
            background: #ff9a2a;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 122, 0, 0.3);
        }

        /* EMPTY CART */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        .empty-cart i {
            font-size: 4rem;
            color: #ff7a00;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            color: #7a3e00;
            margin-bottom: 15px;
        }

        .empty-cart p {
            color: #666;
            margin-bottom: 30px;
        }

        .continue-shopping {
            display: inline-block;
            padding: 12px 30px;
            background: #ff7a00;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
        }

        .continue-shopping:hover {
            background: #ff9a2a;
            transform: scale(1.05);
        }

        /* FOOTER */
        .footer {
            background: #222;
            color: #eee;
            padding: 20px 20px;
            margin-top: auto;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .footer-column h3,
        .footer-column h4 {
            color: #ff7a00;
            margin-bottom: 12px;
        }

        .footer-bottom {
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 20px;
            text-align: center;
            font-size: 0.85rem;
            opacity: 0.8;
        }

        /* SUCCESS MESSAGE */
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin: 20px 0;
            border: 1px solid #c3e6cb;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .success-message i {
            color: #28a745;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 992px) {
            .cart-header,
            .cart-item {
                grid-template-columns: 50px 2fr 1.2fr 1.3fr 1fr 140px;
            }
            
            .action-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .action-buttons {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }
            
            .back-btn {
                margin-top: 10px;
            }
            
            .cart-header {
                display: none;
            }
            
            .cart-item {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 25px 20px;
                border-bottom: 2px solid #eee;
                text-align: center;
            }
            
            .item-checkbox {
                order: 1;
                justify-content: flex-start;
            }
            
            .item-info {
                order: 2;
                flex-direction: column;
                text-align: center;
            }
            
            .item-price {
                order: 3;
                font-size: 1.3rem;
                padding: 5px 0;
            }
            
            .qty-control {
                order: 4;
                justify-content: center;
                gap: 20px;
            }
            
            .item-total {
                order: 5;
                text-align: center;
                font-size: 1.4rem;
                padding: 5px 0;
            }
            
            .item-actions {
                order: 6;
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .action-btn {
                padding: 8px 20px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 15px;
            }
            
            .cart-item {
                padding: 20px 15px;
            }
            
            .checkout-btn {
                padding: 12px;
            }
            
            .action-link {
                padding: 6px 12px;
                font-size: 12px;
            }
            
            .footer-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                    <i class="fas fa-credit-card"></i> Lanjutkan ke Pembayaran
                </button>
                <p style="text-align: center; margin-top: 15px; font-size: 0.9rem; color: #666;">
                    *Pesanan akan diproses setelah pembayaran
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

    <script>
        let selectedItems = new Set();
        
        // Show/hide loading overlay
        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }
        
        // NOTIFICATION FUNCTIONS
        function showNotification(title, message, type = 'info', autoHide = false) {
            const overlay = document.getElementById('notificationOverlay');
            const notification = document.getElementById('notification');
            const titleEl = document.getElementById('notificationTitle');
            const messageEl = document.getElementById('notificationMessage');
            const buttonsEl = document.getElementById('notificationButtons');
            
            // Set icon based on type
            const iconEl = notification.querySelector('.notification-icon i');
            switch(type) {
                case 'success':
                    iconEl.className = 'fas fa-check-circle';
                    iconEl.style.color = '#4CAF50';
                    break;
                case 'warning':
                    iconEl.className = 'fas fa-exclamation-triangle';
                    iconEl.style.color = '#ff9800';
                    break;
                case 'error':
                    iconEl.className = 'fas fa-exclamation-circle';
                    iconEl.style.color = '#f44336';
                    break;
                default:
                    iconEl.className = 'fas fa-info-circle';
                    iconEl.style.color = '#ff7a00';
            }
            
            // Set content
            titleEl.textContent = title;
            messageEl.textContent = message;
            
            // Clear existing buttons and add OK button
            buttonsEl.innerHTML = '<button class="notification-btn ok" onclick="hideNotification()">OK</button>';
            
            // Show notification
            overlay.classList.add('active');
            
            // Auto-hide if specified
            if (autoHide) {
                setTimeout(() => {
                    hideNotification();
                }, 3000);
            }
        }
        
        function hideNotification() {
            document.getElementById('notificationOverlay').classList.remove('active');
        }
        
        // Format currency
        function formatCurrency(amount) {
            return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
        }

        // Update order summary
        function updateOrderSummary() {
            let subtotal = 0;
            let itemCount = 0;

            document.querySelectorAll('.cart-item').forEach(item => {
                const qty = parseInt(item.querySelector('.qty').textContent);
                const priceText = item.querySelector('.item-price').textContent;
                const price = parseInt(priceText.replace(/[^\d]/g, ''));

                itemCount += qty;
                subtotal += qty * price;
            });

            const tax = subtotal * 0.1;
            const grandTotal = subtotal + 5000 + tax;

            document.getElementById('totalItems').textContent = itemCount;
            document.getElementById('subtotal').textContent = formatCurrency(subtotal);
            document.getElementById('tax').textContent = formatCurrency(tax);
            document.getElementById('grandTotal').textContent = formatCurrency(grandTotal);
        }

        // ITEM SELECTION FUNCTIONS
        function toggleSelection(itemId, checkbox) {
            const cartItem = document.getElementById('item-' + itemId);
            
            if (checkbox.checked) {
                selectedItems.add(itemId);
                cartItem.classList.add('selected');
            } else {
                selectedItems.delete(itemId);
                cartItem.classList.remove('selected');
                document.getElementById('selectAll').checked = false;
            }
        }
        
        function toggleSelectAll(checkbox) {
            const allCheckboxes = document.querySelectorAll('.item-checkbox-input');
            
            if (checkbox.checked) {
                selectedItems.clear();
                allCheckboxes.forEach((cb) => {
                    const itemId = cb.dataset.itemId;
                    cb.checked = true;
                    selectedItems.add(itemId);
                    document.getElementById('item-' + itemId).classList.add('selected');
                });
            } else {
                selectedItems.clear();
                allCheckboxes.forEach((cb) => {
                    cb.checked = false;
                    const itemId = cb.dataset.itemId;
                    document.getElementById('item-' + itemId).classList.remove('selected');
                });
            }
        }
        
        // UPDATE QUANTITY FUNCTION (AJAX)
        function updateQuantity(itemId, change) {
            const cartItem = document.getElementById('item-' + itemId);
            const currentQty = parseInt(document.getElementById('qty-' + itemId).textContent);
            const newQty = currentQty + change;
            
            if (newQty < 1) {
                showNotification('Peringatan', 'Jumlah tidak boleh kurang dari 1', 'warning');
                return;
            }
            
            // Show loading on the specific item
            cartItem.classList.add('updating');
            showLoading(true);
            
            // Prepare data
            const formData = new FormData();
            formData.append('id', itemId);
            formData.append('jumlah', newQty);
            
            // Send AJAX request
            fetch('update_jumlah.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Server error');
                return response.json();
            })
            .then(data => {
                showLoading(false);
                cartItem.classList.remove('updating');
                
                if (data.status === 'success') {
                    // Update quantity display
                    document.getElementById('qty-' + itemId).textContent = newQty;
                    
                    // Update total for this item
                    const price = parseInt(data.harga);
                    const total = price * newQty;
                    document.getElementById('total-' + itemId).textContent = formatCurrency(total);
                    
                    // Update minus button state
                    const minusBtn = cartItem.querySelector('.minus-btn');
                    minusBtn.disabled = newQty <= 1;
                    
                    // Update order summary
                    updateOrderSummary();
                    
                    showNotification('Berhasil', 'Jumlah berhasil diupdate', 'success', true);
                    
                } else {
                    showNotification('Error', data.message, 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                cartItem.classList.remove('updating');
                showNotification('Error', 'Terjadi kesalahan saat mengupdate', 'error');
                console.error('Error:', error);
            });
        }
        
        // DELETE ITEM FUNCTION (AJAX)
        function deleteItem(itemId) {
            showNotification(
                'Konfirmasi Hapus',
                'Apakah Anda yakin ingin menghapus item ini?',
                'warning'
            );
            
            document.getElementById('notificationButtons').innerHTML = `
                <button class="notification-btn" style="background: #f5f5f5; color: #666;" onclick="hideNotification()">Batal</button>
                <button class="notification-btn" style="background: #ff4444; color: white;" 
                        onclick="confirmDeleteItem(${itemId})">Hapus</button>
            `;
        }
        
        function confirmDeleteItem(itemId) {
            showLoading(true);
            
            fetch('delete_item.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${itemId}`
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                hideNotification();
                
                if (data.status === 'success') {
                    // Remove item from DOM
                    const cartItem = document.getElementById('item-' + itemId);
                    if (cartItem) cartItem.remove();
                    
                    // Remove from selected items
                    selectedItems.delete(itemId);
                    
                    // Update order summary
                    updateOrderSummary();
                    
                    // Check if cart is empty
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    } else {
                        showNotification('Berhasil', 'Item berhasil dihapus', 'success', true);
                    }
                } else {
                    showNotification('Error', data.message, 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                hideNotification();
                showNotification('Error', 'Terjadi kesalahan saat menghapus', 'error');
                console.error('Error:', error);
            });
        }
        
        // DELETE SELECTED ITEMS
        function deleteSelectedItems() {
            if (selectedItems.size === 0) {
                showNotification('Peringatan', 'Pilih minimal satu item terlebih dahulu', 'warning');
                return;
            }
            
            showNotification(
                'Konfirmasi Hapus',
                `Yakin ingin menghapus ${selectedItems.size} item yang dipilih?`,
                'warning'
            );
            
            document.getElementById('notificationButtons').innerHTML = `
                <button class="notification-btn" style="background: #f5f5f5; color: #666;" onclick="hideNotification()">Batal</button>
                <button class="notification-btn" style="background: #ff4444; color: white;" 
                        onclick="confirmDeleteSelected()">Hapus</button>
            `;
        }
        
        function confirmDeleteSelected() {
            showLoading(true);
            
            fetch('delete_selected.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify({ 
                    ids: Array.from(selectedItems) 
                })
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                hideNotification();
                
                if (data.status === 'success') {
                    // Remove selected items from DOM
                    selectedItems.forEach(id => {
                        const item = document.getElementById('item-' + id);
                        if (item) item.remove();
                    });
                    
                    // Clear selection
                    selectedItems.clear();
                    document.getElementById('selectAll').checked = false;
                    
                    // Update order summary
                    updateOrderSummary();
                    
                    // Check if cart is empty
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    } else {
                        showNotification('Berhasil', 'Item terpilih berhasil dihapus', 'success', true);
                    }
                } else {
                    showNotification('Error', data.message, 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                hideNotification();
                showNotification('Error', 'Terjadi kesalahan saat menghapus item', 'error');
                console.error('Error:', error);
            });
        }
        
        // CHECKOUT FUNCTION
        function checkout() {
            const itemCount = document.querySelectorAll('.cart-item').length;
            if (itemCount === 0) {
                showNotification('Peringatan', 'Keranjang Anda masih kosong!', 'warning');
                return;
            }
            
            showLoading(true);
            
            fetch('checkout.php', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                
                if (data.status === 'success') {
                    showNotification('Berhasil', 'Pesanan berhasil dibuat!', 'success');
                    setTimeout(() => {
                        window.location.href = 'pembayaran.php?order_id=' + data.order_id;
                    }, 2000);
                } else {
                    showNotification('Error', data.message, 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                showNotification('Error', 'Terjadi kesalahan saat checkout', 'error');
                console.error('Error:', error);
            });
        }

        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Plus buttons
            document.querySelectorAll('.plus-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    updateQuantity(itemId, 1);
                });
            });
            
            // Minus buttons
            document.querySelectorAll('.minus-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    updateQuantity(itemId, -1);
                });
            });
            
            // Auto-hide success message after 5 seconds
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    successMessage.style.transition = 'opacity 0.5s';
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>