CREATE DATABASE toko_db;

CREATE TABLE master_produk (
    id INT PRIMARY KEY AUTO_INCREMENT,
    produk VARCHAR(255) UNIQUE NOT NULL,
    stok INT NOT NULL,
    harga INT NOT NULL
);

CREATE TABLE master_transaksi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_transaksi VARCHAR(255),
    tanggal DATETIME NOT NULL
);

CREATE TABLE master_detail_transaksi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_transaksi INT,
    id_produk INT,
    quantity INT NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES master_transaksi(id),
    FOREIGN KEY (id_produk) REFERENCES master_produk(id)
);


FOREIGN KEY (id_transaksi) REFERENCES master_transaksi(id) ON DELETE CASCADE,


