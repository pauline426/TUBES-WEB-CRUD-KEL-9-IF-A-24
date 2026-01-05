// ================= MENU PROFIL =================
let profilData = {
  nama: "Pajri Muhamad",
  email: "pajri@gmail.com",
  nomor: "081234567890",
  alamat: "Jl. Merdeka No. 10",
  foto: "img/profil.png",
  whatsapp: "6281234567890",
  instagram: "pajrimuhamad",
  twitter: "pajrimhd",
};

let daftarAkun = [
  {
    nama: "Pajri Muhamad",
    email: "pajri@gmail.com",
    foto: "img/profil.png",
  },
  {
    nama: "Admin Warung",
    email: "admin@warung.com",
    foto: "img/profil.png",
  },
  {
    nama: "Kasir",
    email: "kasir@warung.com",
    foto: "img/profil.png",
  },
];

window.onload = function () {
  loadMenu("profil");
};

function loadMenu(menu) {
  const judul = document.getElementById("judul");
  const menuContent = document.getElementById("menuContent");
  const detailContent = document.getElementById("detailContent");

  if (menu === "profil") {
    judul.innerText = "My Profil";

    menuContent.innerHTML = `
      <p class="menu-item active" onclick="loadDetail('edit', this)">
        <i class="fa-solid fa-pen"></i>
        <span>Edit Profil</span>
        <i class="fa-solid fa-angle-right arrow"></i>
      </p>

      <p class="menu-item" onclick="loadDetail('bagikan', this)">
        <i class="fa-solid fa-share-nodes"></i>
        <span>Bagikan Profil</span>
        <i class="fa-solid fa-angle-right arrow"></i>
      </p>
    `;

    tampilProfil();
  }

  if (menu === "dasbor") {
    judul.innerText = "Dasbor";

    menuContent.innerHTML = `
    <p class="menu-item active" onclick="loadDetail('ringkasan', this)">
      <i class="fa-solid fa-chart-line"></i>
      <span>Ringkasan Penjualan</span>
      <i class="fa-solid fa-angle-right arrow"></i>
    </p>

    <p class="menu-item" onclick="loadDetail('pengunjung', this)">
      <i class="fa-solid fa-users"></i>
      <span>Statistik Pengunjung</span>
      <i class="fa-solid fa-angle-right arrow"></i>
    </p>
  `;

    const firstMenu = menuContent.querySelector(".menu-item");
    loadDetail("ringkasan", firstMenu);
  }

  if (menu === "tampilan") {
    judul.innerText = "Pengaturan Tampilan";
    menuContent.innerHTML = `
  <div class="menu-item active" onclick="loadDetail('mode', this)">
    <i class="fa-solid fa-palette"></i>
    <span>Mode Tampilan</span>
    <i class="fa-solid fa-angle-right arrow"></i>
  </div>

  <div class="menu-item" onclick="loadDetail('bahasa', this)">
    <i class="fa-solid fa-language"></i>
    <span>Bahasa</span>
    <i class="fa-solid fa-angle-right arrow"></i>
  </div>

  <div class="menu-item" onclick="loadDetail('akses', this)">
    <i class="fa-solid fa-universal-access"></i>
    <span>Aksesibilitas</span>
    <i class="fa-solid fa-angle-right arrow"></i>
  </div>
`;

    const firstMenu = menuContent.querySelector(".menu-item");
    loadDetail("mode", firstMenu);
  }

  if (menu === "akun") {
    judul.innerText = "Akun";

    menuContent.innerHTML = `
    <p class="menu-item active" onclick="loadDetail('privasi', this)">
      <i class="fa-solid fa-user-shield"></i>
      <span>Privasi</span>
      <i class="fa-solid fa-angle-right arrow"></i>
    </p>

    <p class="menu-item" onclick="loadDetail('keamanan', this)">
      <i class="fa-solid fa-lock"></i>
      <span>Keamanan</span>
      <i class="fa-solid fa-angle-right arrow"></i>
    </p>
  `;

    const firstMenu = menuContent.querySelector(".menu-item");
    loadDetail("privasi", firstMenu);
  }

  if (menu === "login") {
    judul.innerText = "Login";

    menuContent.innerHTML = `
    <p class="menu-item active" onclick="loadDetail('switch', this)">
      <i class="fa-solid fa-users"></i>
      <span>Beralih Akun</span>
      <i class="fa-solid fa-angle-right arrow"></i>
    </p>

    <p class="menu-item" onclick="loadDetail('logout', this)">
      <i class="fa-solid fa-right-from-bracket"></i>
      <span>Keluar</span>
      <i class="fa-solid fa-angle-right arrow"></i>
    </p>
  `;

    const firstMenu = menuContent.querySelector(".menu-item");
    loadDetail("switch", firstMenu);
  }
}

// ================= DETAIL PROFIL =================
function tampilProfil() {
  const detailContent = document.getElementById("detailContent");
  detailContent.className = "detail-content center";

  detailContent.innerHTML = `
  <div class="profile-card">
    <img src="${profilData.foto}" class="profile-photo">

    <div class="profile-info">
      <div class="profile-row"><span>Nama</span><span>:</span><span>${profilData.nama}</span></div>
      <div class="profile-row"><span>Email</span><span>:</span><span>${profilData.email}</span></div>
      <div class="profile-row"><span>No HP</span><span>:</span><span>${profilData.nomor}</span></div>
      <div class="profile-row"><span>Alamat</span><span>:</span><span>${profilData.alamat}</span></div>
    </div>
  </div>

  <!-- SOSIAL MEDIA DI LUAR CARD -->
  <h3 class="social-title">Sosial Media</h3>
  <div class="social-box">
    <a href="https://wa.me/6281435225342" target="_blank">
      <i class="fa-brands fa-whatsapp"></i>
      <span>081435225342</span>
    </a>

    <a href="https://instagram.com/pajri_02" target="_blank">
      <i class="fa-brands fa-instagram"></i>
      <span>@pajri_02</span>
    </a>

    <a href="https://twitter.com/pajrii_02" target="_blank">
      <i class="fa-brands fa-x-twitter"></i>
      <span>@pajrii_02</span>
    </a>
  </div>
`;
}

// ================= SUB MENU =================
function loadDetail(detail, el) {
  // hapus active dari semua menu
  document.querySelectorAll(".menu-item").forEach((item) => {
    item.classList.remove("active");
  });

  // aktifkan yang diklik
  if (el) el.classList.add("active");

  const detailContent = document.getElementById("detailContent");
  detailContent.className = "detail-content";

  if (detail === "edit") {
    detailContent.innerHTML = `
      <h3>Edit Profil</h3><br>

      <div class="photo-wrapper">
        <img src="${profilData.foto}" class="profile-photo" id="previewFoto">
        <label for="uploadFoto" class="edit-photo-icon">
          <i class="fa-solid fa-camera"></i>
        </label>
        <input type="file" id="uploadFoto" accept="image/*"
          onchange="ubahFoto(event)" hidden>
      </div>

      <form class="edit-form" onsubmit="simpanProfil(event)">
        <input type="text" id="nama" value="${profilData.nama}" required>
        <input type="text" id="nomor" value="${profilData.nomor}">
        <input type="email" id="email" value="${profilData.email}" required>
        <textarea id="alamat">${profilData.alamat}</textarea>
        <button type="submit">Simpan</button>
      </form>
    `;
  }

  if (detail === "bagikan") {
    detailContent.innerHTML = `
      <h3>Bagikan Profil</h3>
      <p>Link profil berhasil disalin</p>
    `;
  }
  if (detail === "ringkasan") {
    detailContent.innerHTML = `
    <h3>Ringkasan Penjualan</h3>
    <p>Data penjualan hari ini.</p>
  `;
  }

  if (detail === "pengunjung") {
    detailContent.innerHTML = `
    <h3>Statistik Pengunjung</h3>
    <p>Grafik dan data pengunjung.</p>
  `;
  }

  if (detail === "switch") {
    detailContent.innerHTML = `
    <h3>Beralih Akun</h3>
    <div class="account-list">
      ${daftarAkun
        .map(
          (akun) => `
          <div class="account-item">
            <img src="${akun.foto}">
            <div class="account-info">
              <strong>${akun.nama}</strong><br>
              <small>${akun.email}</small>
            </div>
            <button onclick="pilihAkun('${akun.email}')">
              Masuk
            </button>
          </div>
        `
        )
        .join("")}
    </div>
  `;
  }
  if (detail === "mode") {
    detailContent.innerHTML = `
    <h3>Mode Tampilan</h3>

    <div class="option-grid">
      <div class="option-card" onclick="setMode('light')">
        <i class="fa-solid fa-sun"></i>
        <h4>Mode Terang</h4>
        <p>Tampilan cerah untuk siang hari</p>
      </div>

      <div class="option-card" onclick="setMode('dark')">
        <i class="fa-solid fa-moon"></i>
        <h4>Mode Gelap</h4>
        <p>Nyaman untuk mata di malam hari</p>
      </div>
    </div>
  `;
  }
  if (detail === "bahasa") {
    detailContent.innerHTML = `
    <h3>Bahasa</h3>

    <div class="language-box">
      ${[
        "Indonesia",
        "English",
        "日本語",
        "한국어",
        "中文",
        "Español",
        "Français",
        "Deutsch",
        "Português",
        "Русский",
        "العربية",
        "Italiano",
        "Nederlands",
        "ไทย",
        "Tiếng Việt",
        "Türkçe",
        "Polski",
        "Українська",
        "Čeština",
        "Magyar",
        "Română",
        "Svenska",
        "Dansk",
        "Suomi",
        "Norsk",
        "Ελληνικά",
        "עברית",
        "हिन्दी",
        "বাংলা",
        "فارسی",
        "Slovenčina",
        "Slovenščina",
        "Latviešu",
        "Lietuvių",
        "Eesti",
        "Íslenska",
        "Gaeilge",
        "Malti",
        "Shqip",
        "Srpski",
        "Hrvatski",
        "Bosanski",
        "Македонски",
        "ქართული",
        "Հայերեն",
      ]
        .map(
          (b) => `
        <div class="language-item" onclick="pilihBahasa('${b}')">
          ${b}
        </div>
      `
        )
        .join("")}
    </div>
  `;
  }
  if (detail === "akses") {
    detailContent.innerHTML = `
    <h3>Aksesibilitas</h3>

    <div class="accessibility-list">

      <div class="access-item">
        <span>Ukuran Teks Besar</span>
        <input type="checkbox">
      </div>

      <div class="access-item">
        <span>Kontras Tinggi</span>
        <input type="checkbox">
      </div>

      <div class="access-item">
        <span>Kurangi Animasi</span>
        <input type="checkbox">
      </div>

      <div class="access-item">
        <span>Mode Ramah Mata</span>
        <input type="checkbox">
      </div>

    </div>
  `;
  }

  if (detail === "privasi") {
    detailContent.innerHTML = `
    <h3>Privasi</h3>
    <p>Pengaturan privasi akun Anda.</p>
  `;
  }

  if (detail === "keamanan") {
    detailContent.innerHTML = `
    <h3>Keamanan</h3>
    <p>Pengaturan keamanan akun Anda.</p>
  `;
  }

  if (detail === "logout") {
    detailContent.innerHTML = `
    <h3>Keluar</h3>

    <div class="logout-wrapper">

 
      <div class="logout-box">
        <p>Apakah Anda yakin ingin keluar?</p>

        <button class="btn-logout" onclick="logout()">
          Keluar
        </button>
      </div>


      <div class="add-account-box">
        <p>Ingin masuk dengan akun lain?</p>

        <button class="btn-add-account" onclick="tambahAkun()">
          + Tambah Akun
        </button>
      </div>

    </div>
  `;
  }
}

// ================= FOTO =================
function ubahFoto(event) {
  const file = event.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (e) => {
    profilData.foto = e.target.result;
    document.getElementById("previewFoto").src = e.target.result;
  };
  reader.readAsDataURL(file);
}

function simpanProfil(e) {
  e.preventDefault();

  profilData.nama = nama.value;
  profilData.nomor = nomor.value;
  profilData.email = email.value;
  profilData.alamat = alamat.value;

  alert("Profil berhasil disimpan");
  tampilProfil();
}

function setActiveSidebar(el) {
  document.querySelectorAll(".sidebar li").forEach((item) => {
    item.classList.remove("active");
  });

  el.classList.add("active");
}

//============= MENU DASHBOR ============

// ================= MODE TAMPILAN =================
function setMode(mode) {
  if (mode === "dark") {
    document.body.classList.add("dark");
    localStorage.setItem("theme", "dark");
  } else {
    document.body.classList.remove("dark");
    localStorage.setItem("theme", "light");
  }
}

// load theme saat halaman dibuka
window.addEventListener("DOMContentLoaded", () => {
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark") {
    document.body.classList.add("dark");
  }
});

//============= MENU AKUN ============

//============= MENU LOGIN ============
function pilihAkun(email) {
  alert("Login sebagai: " + email);
  // nanti bisa arahkan ke dashboard / simpan session
}

function logout() {
  window.location.href = "login.php";
}

function tambahAkun() {
  window.location.href = "register.php";
}
