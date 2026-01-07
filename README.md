## Deskripsi Proyek

Website Resto Serba Serbi Nasi Bu Henny merupakan aplikasi web yang dirancang untuk membantu pelanggan dalam:
- Melihat informasi restoran
- Menjelajahi menu makanan
- Melakukan pemesanan dan checkout
- Melakukan reservasi meja

Sistem ini juga memudahkan pemilik restoran dalam mengelola data menu dan memantau pesanan melalui database.

## Tujuan Pengembangan
- Menerapkan konsep CRUD
- Mengimplementasikan sistem login & registrasi
- Mengelola pemesanan makanan secara dinamis
- Membangun website responsive dan user-friendly

## Teknologi yang Digunakan
- PHP – Backend
- MySQL – Database
- HTML5 – Struktur halaman website
- CSS3 – Tampilan & layout
- JavaScript – Interaksi & notifikasi
- Apache (XAMPP) – Web Server

## Tim Pengembang
Kelompok 9 – IF A 24  
1. Galuh Pauline Nugraha
2. Pajri Muhamad
3. Dicky Kamilludinn 


## Struktur Proyek
TUBES-WEB/
├── Produk/
│   └── Img/
│       ├── beranda_img/
│       ├── cemilan/
│       ├── hidangan/
│       ├── logo/
│       ├── minuman/
│       ├── paket/
│       ├── Profil/
│       ├── staf_img/
│       └── Profil_warung_nasi/
│
├── Beranda.php
├── cart_action.php
├── Database.php
├── delete_item.php
├── delete_selected.php
├── edit.php
├── get_cart.php
├── get_menu.php
├── hapus.php
├── koneksi.php
├── login.php
├── menu.php
├── Pemesanan.php
├── Pesan.html
├── proses_login.php
├── proses_register.php
├── script_login.js
├── script_menu.js
├── script_Pemesanan.js
├── staf.html
├── style.css
├── style_menu.css
├── style_Pemesanan.css
├── tambah.php
├── tentang.html
├── update_jumlah.php
├── database.sql
└── README.md

##  Panduan Menggunakan Website Resto Serba Serbi Nasi Bu Henny

1. Clone Repository: Buka terminal/command prompt, masuk ke folder yang diinginkan (misal htdocs), dan jalankan perintah: git clone https://github.com/pauline426/TUBES-WEB-CRUD-KEL-9-IF-A-24.git

2. Pastikan Anda telah menginstal XAMPP, WAMP, atau Laragon untuk menjalankan server Apache dan MySQL.Lalu aktifkan apache dan mysql

3. Import Database: Buka phpMyAdmin, buat database baru (contoh: warung_nasi), lalu import skema SQL yang telah disedikan di file database.sql

4. Konfigurasi Koneksi: Periksa dan sesuaikan detail koneksi database (seperti nama host, username, password) di file koneksi.php

5. Jalankan Aplikasi: Arahkan browser Anda ke http://localhost/TUBES-WEB-CRUD-KEL-9-IF-A-24/ atau nama folder tempat file berada.

7. Masuk ke halaman http://localhost/TUBES-WEB-CRUD-KEL-9-IF-A-24/login.php Daftar Akun Baru (Pertama Kali)
- Pilih "Register" jika belum punya akun
- Isi data:
    Nama Lengkap (contoh: Galuh Pauline)
    Email (contoh: galuh@gmail.com)
    Password (minimal 6 karakter)
- Klik "Register" nanti akan ada notification "Registrasi berhasil, silakan login" jika registrasi berhasil.
- pastikan anda mengingat email dan passwordnya

8. Login ke Akun
Pada halaman browser http://localhost/TUBES-WEB-CRUD-KEL-9-IF-A-24/login.php
- Pilih "Login"
- Masukkan:
   Email yang sudah didaftarkan
   Password yang sudah didaftarkan
- Klik "Get Started" Anda akan diarahkan ke Beranda jika login berhasil.

9.  Melihat Profil Restoran
- "Beranda" :  Informasi umum restoran
- "Tentang" : Sejarah & keunggulan restoran
- "Staf" : Memperkenalkan tim, staff, dan pelayan
- "Pesan" :  Kontak, lokasi restoran, dan reservasi 
- "Menu" : MEnampilkan berbagai menu dan beberapa kategori yang berbeda 


10. Menjelajahi Menu
- Klik "Menu" di navbar
- Pilih kategori:
    Hidangan Utama (nasi + lauk)
    Menu Paket (paket lengkap)
    Minuman (es teh, jus, dll)
    Cemilan (gorengan, snack)

11. Untuk menambah pesanan:
   - Klik "+" pada item yang diinginkan
   - Jumlah akan bertambah (lihat angka di tengah)
   - Klik "-" jika ingin mengurangi


12. Melihat Keranjang
- Klik ikon "(keranjang)🛒" di sidebar (halaman Menu)
- Anda akan di arahkan ke halaman Pemesanan
- Di halaman pemesanan anda bisa:
   - Lihat semua item yang dipesan
   - Ubah jumlah (+/-)
   - Hapus item (trash icon)
   - Edit item (pencil icon)
   - Tambah item (plus icon)

13. Checkout & Konfirmasi Pesanan
- Di halaman "Pemesanan", periksa kembali pesanan
- Lihat Ringkasan Pesanan:
   - Subtotal
   - Biaya layanan (Rp 5.000)
   - Pajak (10%)
   - *Total Pembayaran*
- Klik "Konfirmasi Pesanan"
- Pesanan akan diproses oleh restoran
- Notifikasi sukses akan muncul
- ketika proses pemesanan telah selesai anda bisa kembali ke halaman menu dengan mengklik "kembali ke menu"

14. Tahapan Reservasi 
- Klik "Pesan" di navbar
- Isi form reservasi:
   - Pemesanan: Pilih pemesanan (makan ditempat, bawa pulang, atau booking meja)
   - Nama: Masukkan Nama Anda
   - Nomor Telepon: No. HP aktif
   - Keterangan**: Jam/tanggal & jumlah orang/ catatan tambahan
- Klik "Kirim" maka reservasi terkirim ke restoran


15. Logout
- Klik "Profil" di pojok kanan atas
- Pilih "Login" dan pilih keluar
- saat pilih keluar anda akan ada 2 pilihann saat klik keluar anda akan di arahkan ke halaman login
- saat anda pilih tambah akun anda akan di arahkan ke halaman register

16. Icon user di ujung kanan atas
- digunakan saat anda akan mengedit, menambah dan keluar dari akun 
- terdapat icon dasbor, tampilan dan akun namun pada bagian ini belum 100% dikembangkan

---

## Tips & Trik

 Fitur Cepat
- Tombol "+" langsung dari halaman Menu
- Auto-save keranjang (tidak hilang saat refresh)
- Notifikasi jumlah muncul di ikon keranjang


## Keamanan
- Password dienkripsi
- Session timeout otomatis
- Data pribadi pengguna saat login aman tersimpan dalam database


## Masalah Umum & Solusi

1. Tidak Bisa Login
Gejala:
- Tombol login tidak merespons
- "Email atau password salah" muncul terus
- Tidak ada notifikasi setelah login

Penyelesaian:

- Periksa email & password - Pastikan tidak ada typo
- Belum punya akun? - Klik "Register" untuk membuat akun baru
- Clear cache browser - Buka settings → Clear browsing data
- Ganti browser - Coba di Chrome atau Firefox

2. Gambar Tidak Muncul
Gejala:
- Gambar menu muncul sebagai teks yang tampil tanpa gambar

Penyelesaian:
pastikan folder Produk\img ada karena pada folder itu tersimpan semua gambar 

3. Keranjang Kosong
Gejala:
- Item tidak bertambah ke keranjang
- Notifikasi keranjang tetap 0
- Item hilang setelah refresh

Penyelesaian:
- Pastikan sudah login
- Klik "+" pada menu - Tunggu notifikasi jumlah berubah
- Refresh halaman - Kemudian cek kembali keranjang
- Clear cache - Kemudian login ulang


## Panduan Singkat untuk Pemilik Restoran atau yang mengendalikan website

1. Update Menu
- Edit file Database.php
- Tambah data baru di tabel hidangan_utama, minuman, dll
- Upload gambar ke folder Produk/Img/

2. Lihat Pesanan
- Buka phpMyAdmin (http://localhost/phpmyadmin)
- Pilih database warung_nasi
- Lihat tabel detail_pemesanan untuk pesanan yang telah terkoneksi dengan halaman pemesanan.php

3. Ganti Info Restoran
- Edit file tentang.html untuk profil
- Edit file staf.html untuk tim
- Edit file Pesan.html untuk kontak
catatan: jangan lupa sesusaikan bagian css dan js nya


## Akses Mobile (responsive)
Website sudah dioptimalkan untuk:
- Smartphone (Android/iOS)
- Tablet (iPad/Android tablet)
- Desktop (PC/Laptop)