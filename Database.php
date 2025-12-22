CREATE TABLE hidangan_utama (
    id_hidangan INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    gambar VARCHAR(255),
    status ENUM('tersedia','habis') DEFAULT 'tersedia'
);

INSERT INTO hidangan_utama 
(nama_menu, harga, stok, deskripsi, gambar)
VALUES
('Ikan Bakar', 28000, 10, 'Ikan bakar bumbu khas', 'ikan_bakar.jpg'),
('Perkedel', 5000, 10, 'Perkedel kentang goreng gurih', 'Perkedel.jpg'),
('Cumi Bakar', 32000, 10, 'Cumi bakar saus pedas manis', 'Cumi_bakar.jpg'),
('Ayam Goreng', 25000, 15, 'Ayam goreng renyah', 'Ayam_Goreng.jpg'),
('Sop Iga', 38000, 10, 'Sop Iga sapi hangat', 'Sop_Iga.jpg'),
('Sambal Joss', 4000, 10, 'Sambal Pedas Manis', 'Sambal_Joss.jpg'),
('Ayam Goreng', 20000, 12, 'Ayam goreng gurih.', 'ayam_goreng.jpg'),
('Sop Ayam', 18000, 10, 'Sop ayam bening.', 'sop_ayam.jpg'),
('Gule Sapi', 35000, 7, 'Gule sapi berbumbu.', 'gule_sapi.jpg');

CREATE TABLE menu_paket (
    id_paket INT AUTO_INCREMENT PRIMARY KEY,
    nama_paket VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
		stok INT NOT NULL DEFAULT 0,
    isi_paket TEXT,
    gambar VARCHAR(255),
    status ENUM('tersedia','habis') DEFAULT 'tersedia'
	  
);

INSERT INTO menu_paket (nama_paket, harga,stok, isi_paket, gambar, status)
VALUES
('Paket 1', 180000, 10, 'Paket nasi dan lauk lengkap.', 'paket1.jpg', 'tersedia'),
('Paket 2', 200000, 10, 'Paket nasi dan lauk lengkap.', 'paket2.jpg', 'tersedia'),
('Paket 3', 220000, 10, 'Paket nasi dan lauk lengkap.', 'paket3.jpg', 'tersedia'),
('Paket 4', 240000, 10, 'Paket nasi dan lauk lengkap.', 'paket4.jpg', 'tersedia'),
('Paket 5', 107000, 10, 'Paket nasi dan lauk lengkap.', 'paket5.jpg', 'tersedia'),
('Paket 6', 280000, 10, 'Paket nasi dan lauk lengkap.', 'paket6.jpg', 'tersedia');

CREATE TABLE minuman (
    id_minuman INT AUTO_INCREMENT PRIMARY KEY,
    nama_minuman VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
		stok INT NOT NULL DEFAULT 0,
    ukuran ENUM('Kecil','Sedang','Besar') DEFAULT 'Sedang',
    gambar VARCHAR(255),
    status ENUM('tersedia','habis') DEFAULT 'tersedia'
);

INSERT INTO minuman (nama_minuman, harga,stok, ukuran, gambar, status)
VALUES 
('Cappucino', 14000, 10, 'Kecil', 'Cappucino.jpg', 'tersedia'),
('Es Cendol', 8000, 10, 'Sedang', 'Es_Cendol.jpg', 'tersedia'),
('Es Teh Manis', 14000, 10, 'Besar', 'Es_Teh_Manis.jpg', 'habis'),
('Brown Sugar', 5000, 10, 'Sedang', 'Brown_Sugar.jpg', 'tersedia'),
('Kopi Hitam', 7000, 10, 'Kecil', 'Kopi_Hitam.jpg', 'tersedia'),
('Es Jeruk Peras', 8000, 10, 'sedang','Es_Jeruk_Peras.jpg', 'Tersedia');

CREATE TABLE cemilan (
    id_cemilan INT AUTO_INCREMENT PRIMARY KEY,
    nama_cemilan VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
		stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    gambar VARCHAR(255),
    status ENUM('tersedia','habis') DEFAULT 'tersedia'
);

INSERT INTO cemilan (nama_cemilan, harga,stok, deskripsi, gambar, status) VALUES
('Dimsum', 12000, 10, 'Dimsum ayam lezat disajikan dengan saus', 'dimsum.jpg', 'tersedia'),
('Cireng', 6000, 10, 'Cireng goreng renyah khas Bandung', 'cireng.jpg', 'tersedia'),
('Pisang Keju', 12000, 10, 'Pisang goreng dengan topping keju', 'pisang_keju.jpg', 'tersedia'),
('Nugget Goreng', 10000, 10, 'Nugget ayam goreng crispy', 'nugget_goreng.jpg', 'tersedia'),
('Tahu Crispy', 6000, 10, 'Tahu goreng tepung crispy', 'tahu_crispy.jpg', 'tersedia'),
('Onde-Onde', 5000, 10, 'Onde-onde isi kacang hijau', 'onde_onde.jpg', 'tersedia');

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



SELECT * FROM hidangan_utama;
SELECT * FROM menu_paket;
SELECT * FROM minuman;
SELECT * FROM cemilan;