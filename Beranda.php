<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Warung Nasi Serba Serbi</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@500;700&display=swap"
      rel="stylesheet"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: Arial, sans-serif;
        overflow-x: hidden;
        background: linear-gradient(135deg, #ffffff 0%, #fcefdc 100%);
      }

      /* ================= NAVBAR ================= */
      nav {
        width: 100%;
        padding: 20px 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: transparent;
      }
      .logo-area {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-left: 20px;
      }
      .logo {
        height: 60px;
        width: 60px;
        border-radius: 50%;
        background: #fff;
        padding: 5px;
        box-shadow: 0 0 20px rgba(255, 166, 0, 0.6),
          0 0 40px rgba(255, 166, 0, 0.3);
      }
      .brand-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #f27202;
        transition: color 0.5s ease;
        line-height: 1.3;
      }

      .nav-menu {
        display: flex;
        gap: 40px;
        list-style: none;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
      }
      .nav-menu li a {
        color: #111;
        text-decoration: none;
        font-weight: bold;
        background-color: #ff7a00;
        padding: 8px 15px;
        border-radius: 50px;
        transition: 0.3s ease;
        display: inline-block;
        transform: scale(1);
      }

      .nav-menu li a:hover {
        transform: scale(1.25);
        background-color: #ff9a2a;
        color: #fff;
      }

      .nav-menu li a.active {
        transform: scale(1.25);
        background-color: #ff9a2a;
        color: #fff;
      }

      .auth-buttons {
        display: flex;
        gap: 15px;
      }
      .auth-buttons a {
        padding: 10px 18px;
        border-radius: 30px;
        font-weight: 700;
        text-decoration: none;
      }
      .signin {
        color: #111;
      }
      .signin:hover {
        background-color: #ff7a00;
        border-radius: 50px;
        transition: 1s;
      }
      .signup {
        background-color: #ff7a00;
        color: white;
      }

      /* ================= HERO ================= */
      .hero {
        padding: 140px 50px 50px 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-left: 70px;
      }
      .hero-text-wrapper {
        max-width: 450px;
        margin-top: -35vh;
      }
      .hero-text-wrapper h1 {
        font-size: 45px;
        font-weight: 800;
        color: #111;
        margin-bottom: 10px;
      }
      .hero-text-wrapper p {
        margin-top: 10px;
        font-size: 18px;
        color: #444;
      }
      .order-btn {
        background-color: #ff7a00;
        color: white;
        border: none;
        padding: 15px 30px;
        margin-top: 20px;
        font-size: 16px;
        border-radius: 30px;
        cursor: pointer;
        font-weight: bold;
      }
      /* ===== ANIMASI SLIDE HERO ===== */
      .hero-img {
        width: 450px;
        height: 450px;
        margin-right: 60px;
        position: relative;
        opacity: 0;
        transform: translateX(80px);
        transition: opacity 0.8s ease, transform 0.8s ease;
        margin-bottom: 50px;
      }

      .hero-img.show {
        opacity: 1;
        transform: translateX(0);
      }

      .hero-img.hide {
        opacity: 0;
        transform: translateX(100px);
      }

      /* ===== CARD MENU ===== */
      .menu-cards {
        display: flex;
        gap: 20px;
        padding: 20px 50px;
        margin-top: -290px;
        margin-bottom: 120px;
        margin-left: 70px;
      }
      .menu-card {
        width: 180px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 15px;
        text-align: center;
        transition: 0.3s;
        cursor: pointer;
        box-shadow: 0 0 20px rgba(255, 166, 0, 0.6),
          0 0 40px rgba(255, 166, 0, 0.3);
      }
      .menu-card:hover {
        transform: translateY(-5px);
      }
      .menu-card img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 100px;
      }
      .menu-card p {
        font-weight: 700;
        margin-top: 8px;
        font-size: 14px;
        background: #ff7a00;
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
      }

      .fade {
        opacity: 0;
        transition: opacity 0.6s ease;
      }
      .fade.show {
        opacity: 1;
      }

      /* ============ FOOTER ===========S */
      .footer {
        background: #222;
        color: #eee;
        padding: 30px 20px;
        font-family: "Poppins", sans-serif;
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
        margin-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        padding-top: 8px;
        text-align: center;
        font-size: 0.85rem;
        opacity: 0.8;
      }
      .footer-bottom p {
        padding-top: 20px;
      }

      /* ================ RESPONSIVE TABLET ================= */
      @media (max-width: 992px) {
        nav {
          padding: 15px 30px;
        }

        .nav-menu {
          gap: 20px;
        }

        .hero {
          flex-direction: column;
          text-align: center;
          padding-top: 120px;
        }

        .hero img {
          width: 70%;
          margin: 0;
        }

        .hero-text-wrapper {
          margin-top: 0;
        }

        .menu-cards {
          justify-content: center;
          flex-wrap: wrap;
          margin-top: 20px;
        }

        .menu-card {
          width: 200px;
        }
      }

      /* ===================== RESPONSIVE TABLET ===================== */
      @media (max-width: 992px) {
        .hero {
          flex-direction: column;
          text-align: center;
          padding: 80px 20px;
          margin-left: 0;
          gap: 20px;
        }

        .hero-text-wrapper {
          margin-top: 0;
          max-width: 100%;
        }

        .hero-img {
          width: 80%;
          height: auto;
          margin: 0 auto;
        }

        .menu-cards {
          justify-content: center;
          flex-wrap: wrap;
          margin-top: 20px;
          margin-left: 0;
        }
      }

      /* ===================== RESPONSIVE MOBILE ===================== */
      @media (max-width: 600px) {
        .hero {
          padding: 60px 20px;
        }

        .hero-text-wrapper h1 {
          font-size: 32px;
        }

        .hero-img {
          width: 90%;
          height: auto;
          margin-top: 20px;
        }

        .menu-card {
          width: 170px;
        }

        .nav-menu {
          flex-wrap: nowrap;
          gap: 10px;
          overflow-x: auto;
          white-space: nowrap;
        }

        .nav-menu li a {
          font-size: 13px;
          padding: 6px 12px;
        }
      }
      /* ======== HAMBURGER MOBILE & TABLET MENU ======= */
      .hamburger {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        z-index: 2001;
      }
      .hamburger span {
        width: 30px;
        height: 4px;
        background: #ff7a00;
        border-radius: 3px;
      }

      .mobile-menu {
        position: fixed;
        top: 0;
        right: -300px;
        width: 260px;
        height: 100vh;
        background: #ff7a00;
        transition: 0.4s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 60px;
        z-index: 2000;
      }

      .nav-menu-mobile {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 25px;
        text-align: center;
      }
      .nav-menu-mobile li {
        width: 100%;
        border-bottom: 2px solid rgba(255, 255, 255, 0.4);
        padding-bottom: 10px;
      }

      .nav-menu-mobile li a {
        color: white;
        font-size: 18px;
        text-decoration: none;
        font-weight: bold;
      }

      .auth-mobile {
        margin-top: 40px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 34vh;
      }
      .auth-mobile a {
        color: white;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        text-align: center;
        text-decoration: none;
      }

      @media (max-width: 992px) {
        .hamburger {
          display: flex;
        }
        .nav-menu,
        .auth-buttons {
          display: none !important;
        }
        .mobile-menu.active {
          right: 0;
        }
      }
    </style>
  </head>
  <body>
    <!-- ================= NAVBAR ================= -->
    <nav>
      <div class="logo-area">
        <img src="Produk/Img/logo/logo.png" alt="Logo" class="logo" />
        <span class="brand-text">Serba Serbi Nasi<br />Bu Henny</span>
      </div>
      <ul class="nav-menu">
        <li><a href="Beranda.php">Beranda</a></li>
        <li><a href="tentang.html">Tentang</a></li>
        <li><a href="menu.html">Menu</a></li>
        <li><a href="staf.html">Staf</a></li>
        <li><a href="Pesan.html">Pesan</a></li>
      </ul>
      <div class="auth-buttons">
        <a class="signin" href="#login">Sign In</a>
        <a class="signup" href="#daftar">Sign Up</a>
      </div>
      <!-- ================= NAVBAR HUMBERGER ================= -->
      <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <div class="mobile-menu" id="mobileMenu">
        <ul class="nav-menu-mobile">
          <li><a href="Beranda.php">Beranda</a></li>
          <li><a href="tentang.html">Tentang</a></li>
          <li><a href="menu.html">Menu</a></li>
          <li><a href="staf.html">Staf</a></li>
          <li><a href="Pesan.html">Pesan</a></li>
        </ul>

        <div class="auth-mobile">
          <a class="signin" href="#login">Sign In</a>
          <a class="signup" href="#daftar">Sign Up</a>
        </div>
      </div>
    </nav>
    <!-- ================= HERO ================= -->

    <section class="hero" id="beranda">
      <div class="hero-text-wrapper">
        <h1>Serba Serbi Makanan</h1>
        <p></p>
        <div class="type-line" id="typeLine" aria-live="polite"></div>

        <button class="order-btn" onclick="window.location.href='Pesan.html'">
          Pesan Sekarang
        </button>
      </div>
      <img
        id="hero-slide"
        class="hero-img show"
        src="Produk/Img/beranda_img/foto1.png"
      />
    </section>

    <!-- ========== CARD MENU ========== -->
    <div class="menu-cards">
      <div class="menu-card fade show" id="card-utama">
        <img id="img-utama" src="Produk/Img/hidangan/makanan1.jpeg" />
        <p>Hidangan Utama</p>
      </div>

      <div class="menu-card fade show" id="card-minuman">
        <img id="img-minuman" src="Produk/Img/minuman/minuman1.jpeg" />
        <p>Minuman</p>
      </div>

      <div class="menu-card fade show" id="card-cemilan">
        <img id="img-cemilan" src="Produk/Img/cemilan/cemilan1.jpeg" />
        <p>Cemilan</p>
      </div>
    </div>

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
    <script>
      /* ================= JS HAMBURGER ================= */
      const hamburger = document.getElementById("hamburger");
      const mobileMenu = document.getElementById("mobileMenu");

      hamburger.addEventListener("click", () => {
        mobileMenu.classList.add("active");
      });

      document.addEventListener("click", (e) => {
        if (!mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
          mobileMenu.classList.remove("active");
        }
      });

      /* ================= TYPING EFFECT ================= */
      const typeLine = document.getElementById("typeLine");
      const typeLines = [
        " Hidangan nasi lengkap dengan lauk pauk pilihan yang memanjakan lidah dan bikin begoyang di mulut kenyang di perut.",
      ];
      let textIndex = 0;
      let charIndex = 0;

      function typeEffect() {
        const currentText = typeLines[textIndex];

        if (charIndex < currentText.length) {
          typeLine.innerHTML += currentText.charAt(charIndex);
          charIndex++;
          setTimeout(typeEffect, 40);
        }
      }
      typeEffect();

      /* ================= SLIDESHOW HERO ================= */
      const paketImages = [
        "Produk/Img/beranda_img/foto1.png",
        "Produk/Img/beranda_img/foto2.png",
        "Produk/Img/beranda_img/foto3.png",
        "Produk/Img/beranda_img/foto4.png",
        "Produk/Img/beranda_img/foto5.png",
      ];

      let idxHero = 0;
      const heroImg = document.getElementById("hero-slide");

      function changeHeroImage() {
        heroImg.classList.remove("show");
        heroImg.classList.add("hide");

        setTimeout(() => {
          idxHero = (idxHero + 1) % paketImages.length;
          heroImg.src = paketImages[idxHero];

          heroImg.classList.remove("hide");
          heroImg.classList.add("show");
        }, 800);
      }

      setInterval(changeHeroImage, 3000);

      /* ================= ANIMASI CARD ================= */
      const dataSlide = {
        utama: [
          "Produk/Img/hidangan/makanan1.jpeg",
          "Produk/Img/hidangan/makanan2.jpeg",
          "Produk/Img/hidangan/makanan3.jpeg",
          "Produk/Img/hidangan/makanan4.jpeg",
          "Produk/Img/hidangan/makanan5.jpeg",
          "Produk/Img/hidangan/makanan6.jpeg",
          "Produk/Img/hidangan/makanan7.jpeg",
          "Produk/Img/hidangan/makanan8.jpeg",
          "Produk/Img/hidangan/makanan9.jpeg",
          "Produk/Img/hidangan/makanan10.jpeg",
          "Produk/Img/hidangan/makanan11.jpeg",
          "Produk/Img/hidangan/makanan12.jpeg",
        ],
        minuman: [
          "Produk/Img/minuman/minuman1.jpeg",
          "Produk/Img/minuman/minuman2.jpeg",
          "Produk/Img/minuman/minuman3.jpeg",
          "Produk/Img/minuman/minuman4.jpeg",
          "Produk/Img/minuman/minuman5.jpeg",
          "Produk/Img/minuman/minuman1.jpeg",
          "Produk/Img/minuman/minuman2.jpeg",
          "Produk/Img/minuman/minuman3.jpeg",
          "Produk/Img/minuman/minuman5.jpeg",
          "Produk/Img/minuman/minuman4.jpeg",
          "Produk/Img/minuman/minuman6.jpeg",
          "Produk/Img/minuman/minuman4.jpeg",
        ],
        cemilan: [
          "Produk/Img/cemilan/cemilan1.jpeg",
          "Produk/Img/cemilan/cemilan2.jpeg",
          "Produk/Img/cemilan/cemilan3.jpeg",
          "Produk/Img/cemilan/cemilan4.jpeg",
          "Produk/Img/cemilan/cemilan2.jpeg",
          "Produk/Img/cemilan/cemilan5.jpeg",
          "Produk/Img/cemilan/cemilan1.jpeg",
          "Produk/Img/cemilan/cemilan6.jpeg",
          "Produk/Img/cemilan/cemilan3.jpeg",
          "Produk/Img/cemilan/cemilan4.jpeg",
          "Produk/Img/cemilan/cemilan5.jpeg",
          "Produk/Img/cemilan/cemilan6.jpeg",
        ],
      };

      window.idxUtama = 0;
      window.idxMinuman = 0;
      window.idxCemilan = 0;

      function slideChange(idCard, idImg, data, indexName) {
        const card = document.getElementById(idCard);
        const img = document.getElementById(idImg);

        card.classList.remove("show");

        setTimeout(() => {
          img.src = data[window[indexName]];
          window[indexName] = (window[indexName] + 1) % data.length;
          card.classList.add("show");
        }, 600);
      }

      setInterval(
        () =>
          slideChange("card-utama", "img-utama", dataSlide.utama, "idxUtama"),
        2500
      );
      setInterval(
        () =>
          slideChange(
            "card-minuman",
            "img-minuman",
            dataSlide.minuman,
            "idxMinuman"
          ),
        2500
      );
      setInterval(
        () =>
          slideChange(
            "card-cemilan",
            "img-cemilan",
            dataSlide.cemilan,
            "idxCemilan"
          ),
        2500
      );

      const currentPage = window.location.pathname.split("/").pop();
      const menuLinks = document.querySelectorAll(".nav-menu li a");

      menuLinks.forEach((link) => {
        if (link.getAttribute("href") === currentPage) {
          link.classList.add("active");
        }
      });
    </script>
  </body>
</html>
