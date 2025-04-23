<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "toko_db";

// Buat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die($conn->connect_error);
}

//echo "Koneksi berhasil!";
?>
