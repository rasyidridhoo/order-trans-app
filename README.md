# Aplikasi manajemen transaksi

Aplikasi manajemen transaksi berbasis web, dibuat dengan PHP dan MySQL.

## 📦 Fitur Utama

- CRUD Produk dan Transaksi
- Transaksi dengan multiple item (master-detail)
- Laporan harian
- Validasi stok saat checkout
- Pencarian dan filter transaksi

## 🛠️ Teknologi

- PHP (Prosedural / OOP)
- MySQL
- XAMPP
- phpMyAdmin

---

## 🚀 Langkah Instalasi

### 1. Clone Repository

git clone https://github.com/username/toko_appnew.git

( Ganti username dengan username GitHub Anda)


### 2. Pindahkan ke htdocs

Jika Anda menggunakan XAMPP, pindahkan folder hasil clone ke direktori:

C:\xampp\htdocs\toko_appnew

(bisa dibuat terlebih dahulu foldernya dengan nama toko_appnew atau bisa disesuaikan sesuai keinginan).

Atau bisa langsung clone di dalam htdocs.


### 3. Import Database

Buka phpMyAdmin (biasanya di http://localhost/phpmyadmin)

Buat database baru, misalnya toko_app

Klik database tersebut, lalu pilih tab Import

Pilih file SQL (toko_db.sql) yang sudah diekspor

Klik Go


### 4. Konfigurasi Koneksi Database

Edit file koneksi (pada config/config.php) dan sesuaikan:

$host = "localhost";
$user = "root";
$pass = "";
$db   = "toko_app";

### 5. Jalankan Aplikasi

Buka browser dan akses:

http://localhost/toko_appnew/public/index.php