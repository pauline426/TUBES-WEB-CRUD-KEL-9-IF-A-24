<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Warung Nasi Serba Serbi</title>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
/>
    <link rel="stylesheet" href="style_menu.css">
    
  </head>

  <body>
    <!----- NAVBAR ----->

    <nav>
      <div class="logo-area">
        <img src="Produk/Img/logo/logo.png" alt="Logo" class="logo" />
        <span class="brand-text">Serba Serbi Nasi<br />Bu Henny</span>
      </div>

      <ul class="nav-menu">
        <li><a href="Beranda.html">Beranda</a></li>
        <li><a href="tentang.html">Tentang</a></li>
        <li><a href="menu.html" class="active">Menu</a></li>
        <li><a href="staf.html">Staf</a></li>
        <li><a href="Pesan.html">Pesan</a></li>
      </ul>

      <div class="auth-buttons">
        <a class="signin" href="#login">Sign In</a>
        <a class="signup" href="#daftar">Sign Up</a>
      </div>

      <!-- HAMBURGER BUTTON -->
      <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <!-- MOBILE MENU -->
      <div class="mobile-menu" id="mobileMenu">
        <ul class="nav-menu-mobile">
          <li><a href="Beranda.html">Beranda</a></li>
          <li><a href="tentang.html">Tentang</a></li>
          <li><a href="menu.html" class="active">Menu</a></li>
          <li><a href="staf.html">Staf</a></li>
          <li><a href="Pesan.html">Pesan</a></li>
        </ul>

        <div class="auth-mobile">
          <a href="#login">Sign In</a>
          <a href="#daftar">Sign Up</a>
        </div>
      </div>
    </nav>

    <!-- LAYOUT -->
    <div class="container">
      <!-- SIDEBAR -->
      <div class="sidebar">
        <h1>Menu Makanan</h1>
        <div class="menu-item">Hidangan utama</div>
        <div class="menu-item">Menu paket</div>
        <div class="menu-item">Minuman</div>
        <div class="menu-item">Cemilan</div>

        <div class="keranjang"onclick="window.location.href='Pemesanan.php'">
        <i class="fa-solid fa-cart-shopping"></i>
        <a href="Pemesanan.php"></a>
        </div>

      </div>

      <!-- CONTENT -->
      <div class="content">
        <div class="search-modern">
          <input type="text" placeholder="Ketik disini..." />
          <button>
            <img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" />
          </button>
        </div>

        <div class="menu-grid"></div>
      </div>
    </div>

    <!-- FOOTER DI LUAR CONTENT -->
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
          <p>Senin - Jumat<br />07:00 – 20:00 WIB</p>
          <br />
          <p>Sabtu - Minggu<br />07:00 – 21:00 WIB</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2025 Serba Serbi Nasi Bu Henny — Semua Hak Dilindungi</p>
      </div>
    </footer>

<script src="script_menu.js">
</script>

  </body>
</html>
