<?php

require_once '../models/Transaksi.php';
require_once '../models/Produk.php';

class TransaksiController {
    private $transaksi;
    private $produk;

    public function __construct($db) {
        $this->transaksi = new Transaksi($db);
        $this->produk = new Produk($db);
    }

    public function index() {
        $data = $this->transaksi->getAll();
        include '../views/transaksi/index.php';
    }

    public function detail($id) {
        $transaksi = $this->transaksi->getById($id);
        $items = $this->transaksi->getDetail($id);
        include '../views/transaksi/form_detail.php';
    }

    public function formTambah() {
        $produk = $this->produk->getAll();
        include '../views/transaksi/form_tambah.php';
    }

    public function simpan($post) {
        $items = [];
    
        // Ambil data produk dan quantity dari form
        foreach ($post['produk'] as $i => $id_produk) {
            $items[] = [
                'id_produk' => (int)$id_produk,
                'quantity' => (int)$post['quantity'][$i]
            ];
        }
    
        // Validasi stok untuk setiap produk
        foreach ($items as $item) {
            $stok = $this->produk->getStok ($item['id_produk']); // Ambil stok produk dari database
            if ($stok == 0) {
                echo "<script>alert('Stock Kosong'); window.history.back();</script>";
                exit;
            }
    
            // Cek apakah quantity yang dimasukkan lebih besar dari stok
            if ($item['quantity'] > $stok) {
                echo "<script>alert('Jumlah produk ID " . $item['id_produk'] . " melebihi stok yang tersedia ($stok).'); window.history.back();</script>";
                exit;
            }

            
        }
    
        // Simpan transaksi jika validasi lolos
        $this->transaksi->insert($items);
        echo "<script>
            alert('Transaksi berhasil disimpan!');
            try {
                window.opener.location.href = 'index.php?page=transaksi';
            } catch (e) {
                console.error('Tidak bisa akses window.opener:', e);
            }
            window.close();
        </script>";
        exit;

    }

    public function hapus($id) {
        $this->transaksi->delete($id);
        header("Location: index.php?page=transaksi");
    }

    public function formEdit($id) {
        // Ambil transaksi berdasarkan id
        $transaksi = $this->transaksi->getById($id);
        $id_get = $id;
        // Ambil detail transaksi
        $produkData = $this->transaksi->getAll();
        $produkDetail = $this->transaksi->getDetail($id);  // Ambil detail produk yang terlibat
        include '../views/transaksi/form_edit.php';  // Form untuk edit transaksi
    }

    public function update($post) {
        $id_transaksi = $_GET['id'];
        $items = [];
        
        // Ambil data produk dan quantity dari form
        foreach ($post['produk'] as $i => $id_produk) {
            $items[] = [
                'id_produk' => (int)$id_produk,
                'quantity' => (int)$post['quantity'][$i]
            ];
        }
        
        // Validasi stok untuk setiap produk
        foreach ($items as $item) {
            $stok = $this->produk->getStok($item['id_produk']); // Ambil stok produk dari database
            if ($stok == 0) {
                echo "<script>alert('Stock Kosong'); window.history.back();</script>";
                exit;
            }
    
            // Cek apakah quantity yang dimasukkan lebih besar dari stok
            if ($item['quantity'] > $stok) {
                echo "<script>alert('Jumlah produk ID " . $item['id_produk'] . " melebihi stok yang tersedia ($stok).'); window.history.back();</script>";
                exit;
            }
        }
    
        // Update transaksi
        $this->transaksi->updateTransaksi($id_transaksi, $post['kode_transaksi'], $post['tanggal']);
        
        // Update detail transaksi
        $this->transaksi->updateDetailTransaksi($id_transaksi, $items);
    
        echo "<script>
            alert('Transaksi berhasil diperbarui!');
            try {
                window.opener.location.href = 'index.php?page=transaksi';
            } catch (e) {
                console.error('Tidak bisa akses window.opener:', e);
            }
            window.close();
        </script>";
        exit;
    }
    


}


?>