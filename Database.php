-- =========================
-- TABEL KATEGORI
-- =========================
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
);

INSERT INTO kategori (nama_kategori) VALUES
('Hidangan Utama'),
('Menu Paket'),
('Minuman'),
('Cemilan');

-- =========================
-- TABEL HIDANGAN UTAMA
-- =========================
CREATE TABLE hidangan_utama (
    id_hidangan INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NOT NULL,
    nama_menu VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    gambar VARCHAR(255),
    status ENUM('tersedia','habis') DEFAULT 'tersedia',
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
);

INSERT INTO hidangan_utama 
(id_kategori, nama_menu, harga, stok, deskripsi, gambar)
VALUES
(1,'Ikan Bakar',28000,10,'Ikan bakar bumbu khas','ikan_bakar.jpg'),
(1,'Perkedel',5000,10,'Perkedel kentang goreng gurih','Perkedel.jpg'),
(1,'Cumi Bakar',32000,10,'Cumi bakar saus pedas manis','Cumi_bakar.jpg'),
(1,'Ayam Goreng Serundeng',22000,15,'Ayam goreng dengan taburan serundeng','Ayam_Goreng.jpg'),
(1,'Sop Iga',38000,10,'Sop iga sapi hangat','Sop_Iga.jpg'),
(1,'Sambal Joss',4000,10,'Sambal pedas manis','Sambal_Joss.jpg'),
(1,'Ayam Goreng',20000,12,'Ayam goreng gurih','ayam_goreng.jpg'),
(1,'Sop Ayam',18000,10,'Sop ayam bening','sop_ayam.jpg'),
(1,'Gule Sapi',35000,7,'Gule sapi berbumbu','gule_sapi.jpg'),
(1, 'Nasi Goreng', 15000, 100, 'Nasi goreng khas warung', 'makanan10.jpeg'),
(1, 'Nasi Biasa', 6000, 100, 'Nasi putih', 'Produk/Img/hidangan/makanan11.jpeg'),
(1, 'Nasi Kuning', 100000, 100, 'Nasi kuning spesial', 'Produk/Img/hidangan/makanan12.jpeg');

 

-- =========================
-- TABEL MENU PAKET
-- =========================
CREATE TABLE menu_paket (
    id_paket INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NOT NULL,
    nama_paket VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    isi_paket TEXT,
    gambar VARCHAR(255),
    status ENUM('tersedia','habis') DEFAULT 'tersedia',
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
);

INSERT INTO menu_paket
(id_kategori, nama_paket, harga, stok, isi_paket, gambar, status)
VALUES
(2,'Paket 1',180000,10,'Paket nasi dan lauk lengkap','paket1.jpg','tersedia'),
(2,'Paket 2',200000,10,'Paket nasi dan lauk lengkap','paket2.jpg','tersedia'),
(2,'Paket 3',220000,10,'Paket nasi dan lauk lengkap','paket3.jpg','tersedia'),
(2,'Paket 4',240000,10,'Paket nasi dan lauk lengkap','paket4.jpg','tersedia'),
(2,'Paket 5',107000,10,'Paket nasi dan lauk lengkap','paket5.jpg','tersedia'),
(2,'Paket 6',280000,10,'Paket nasi dan lauk lengkap','paket6.jpg','tersedia');

-- =========================
-- TABEL MINUMAN
-- =========================
CREATE TABLE minuman (
    id_minuman INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NOT NULL,
    nama_minuman VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    ukuran ENUM('Kecil','Sedang','Besar') DEFAULT 'Sedang',
    gambar VARCHAR(255),
    status ENUM('tersedia','habis') DEFAULT 'tersedia',
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
);

INSERT INTO minuman
(id_kategori, nama_minuman, harga, stok, ukuran, gambar, status)
VALUES
(3,'Cappuccino',14000,10,'Kecil','Cappucino.jpg','tersedia'),
(3,'Es Cendol',8000,10,'Sedang','Es_Cendol.jpg','tersedia'),
(3,'Es Teh Manis',14000,10,'Besar','Es_Teh_Manis.jpg','habis'),
(3,'Brown Sugar',5000,10,'Sedang','Brown_Sugar.jpg','tersedia'),
(3,'Kopi Hitam',7000,10,'Kecil','Kopi_Hitam.jpg','tersedia'),
(3,'Es Jeruk Peras',8000,10,'Sedang','Es_Jeruk_Peras.jpg','tersedia');

-- =========================
-- TABEL CEMILAN
-- =========================
CREATE TABLE cemilan (
    id_cemilan INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NOT NULL,
    nama_cemilan VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    gambar VARCHAR(255),
    status ENUM('tersedia','habis') DEFAULT 'tersedia',
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
);

INSERT INTO cemilan
(id_kategori, nama_cemilan, harga, stok, deskripsi, gambar, status)
VALUES
(4,'Dimsum',12000,10,'Dimsum ayam lezat','dimsum.jpg','tersedia'),
(4,'Cireng',6000,10,'Cireng goreng khas Bandung','cireng.jpg','tersedia'),
(4,'Pisang Keju',12000,10,'Pisang goreng topping keju','pisang_keju.jpg','tersedia'),
(4,'Nugget Goreng',10000,10,'Nugget ayam crispy','nugget_goreng.jpg','tersedia'),
(4,'Tahu Crispy',6000,10,'Tahu goreng crispy','tahu_crispy.jpg','tersedia'),
(4,'Onde-Onde',5000,10,'Onde-onde kacang hijau','onde_onde.jpg','tersedia');

-- =========================
-- TABEL USERS
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- =========================
-- TABEL DETAIL PEMESANAN
-- =========================
CREATE TABLE detail_pemesanan (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_kategori INT,
    id_hidangan INT,
    id_paket INT,
    id_minuman INT,
    id_cemilan INT,
    nama VARCHAR(50),
    jumlah INT NOT NULL,
    harga INT NOT NULL,
    
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori),
    FOREIGN KEY (id_hidangan) REFERENCES hidangan_utama(id_hidangan),
    FOREIGN KEY (id_paket) REFERENCES menu_paket(id_paket),
    FOREIGN KEY (id_minuman) REFERENCES minuman(id_minuman),
    FOREIGN KEY (id_cemilan) REFERENCES cemilan(id_cemilan)
);

ALTER TABLE detail_pemesanan
ADD UNIQUE KEY uniq_user_hidangan (id_user, id_hidangan),
ADD UNIQUE KEY uniq_user_paket (id_user, id_paket),
ADD UNIQUE KEY uniq_user_minuman (id_user, id_minuman),
ADD UNIQUE KEY uniq_user_cemilan (id_user, id_cemilan);



-- =========================
-- SELECT DATA
-- =========================
SELECT * FROM kategori;
SELECT * FROM hidangan_utama;
SELECT * FROM menu_paket;
SELECT * FROM minuman;
SELECT * FROM cemilan;
SELECT * FROM users;
SELECT * FROM detail_pemesanan;

DROP TABLE IF EXISTS detail_pemesanan;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS cemilan;
DROP TABLE IF EXISTS minuman;
DROP TABLE IF EXISTS menu_paket;
DROP TABLE IF EXISTS hidangan_utama;
DROP TABLE IF EXISTS kategori;

SELECT 
    dp.id_detail,
    u.nama_lengkap,
    dp.jumlah,
    dp.harga,
    (dp.jumlah * dp.harga) AS total
FROM detail_pemesanan dp
JOIN users u ON dp.id_user = u.id;

SELECT
    dp.id_detail,
    u.nama_lengkap,
    h.nama_menu,
    dp.jumlah,
    dp.harga,
    (dp.jumlah * dp.harga) AS total
FROM detail_pemesanan dp
JOIN users u ON dp.id_user = u.id
JOIN hidangan_utama h ON dp.id_hidangan = h.id_hidangan;