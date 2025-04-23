<?php
class Transaksi {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk mendapatkan semua transaksi
    public function getAll() {
        return $this->conn->query("SELECT * FROM master_transaksi");
    }

    // Fungsi untuk mendapatkan transaksi berdasarkan ID
    public function getById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM master_transaksi WHERE id = $id";
        return $this->conn->query($query)->fetch_assoc();
    }

    public function getDetail($id) {
        $id = (int)$id;
        return $this->conn->query("
            SELECT d.*, p.produk, p.harga 
            FROM master_detail_transaksi d 
            JOIN master_produk p ON d.id_produk = p.id 
            WHERE d.id_transaksi = $id
        ");
    }

    // Fungsi untuk menambah transaksi
    public function insert($produk) {
        $query = "SELECT MAX(id) AS max_id FROM master_transaksi";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        
        // Jika ada ID sebelumnya, tambahkan 1 untuk ID baru
        $new_id = $row['max_id'] + 1;
        
        // Buat kode transaksi dengan format 'ID-YYYYMMDD'
        $kode_transaksi = $new_id . date('Ymd');
        $tanggal = date('Y-m-d H:i:s');
        $query = "INSERT INTO master_transaksi (kode_transaksi, tanggal) VALUES ('$kode_transaksi', '$tanggal')";
        if ($this->conn->query($query)) {
            $transaksi_id = $this->conn->insert_id;
    
            foreach ($produk as $item) {
                $id_produk = (int)$item['id_produk'];
                $qty = (int)$item['quantity'];
    
                $insertDetailQuery = "INSERT INTO master_detail_transaksi (id_transaksi, id_produk, quantity) VALUES ($transaksi_id, $id_produk, $qty)";
                $this->conn->query($insertDetailQuery);
    
                $this->kurangiStok($id_produk, $qty);
            }
        } else {
            echo "Error: " . $this->conn->error;
        }
    }

    public function kurangiStok($id_produk, $qty) {
        $this->conn->query("UPDATE master_produk SET stok = stok - $qty WHERE id = $id_produk");
    }
    
    

    // Fungsi untuk menghapus transaksi
    public function delete($id) {
        // Ambil detail transaksi untuk mengetahui produk dan quantity
        $detailQuery = "SELECT id_produk, quantity FROM master_detail_transaksi WHERE id_transaksi = $id";
        $result = $this->conn->query($detailQuery);
    
        // Mengembalikan stok produk sesuai dengan quantity yang ada di detail transaksi
        while ($row = $result->fetch_assoc()) {
            $id_produk = $row['id_produk'];
            $qty = $row['quantity'];
    
            // Menambah stok produk yang dihapus dari transaksi
            $this->tambahStok($id_produk, $qty);
        }
    
        // Hapus detail transaksi
        $deleteDetailQuery = "DELETE FROM master_detail_transaksi WHERE id_transaksi = $id";
        $this->conn->query($deleteDetailQuery);
    
        // Hapus transaksi setelah detail berhasil dihapus
        $deleteTransaksiQuery = "DELETE FROM master_transaksi WHERE id = $id";
        if ($this->conn->query($deleteTransaksiQuery)) {
            return true;
        } else {
            echo "Error deleting transaksi: " . $this->conn->error;
            return false;
        }
    }
    

    public function tambahStok($id_produk, $qty) {
        $this->conn->query("UPDATE master_produk SET stok = stok + $qty WHERE id = $id_produk");
    }
    

    public function updateTransaksi($id, $kode_transaksi, $tanggal) {
        $query = "UPDATE master_transaksi SET kode_transaksi = '$kode_transaksi', tanggal = '$tanggal' WHERE id = $id";
        if ($this->conn->query($query)) {
            return true;
        }
        return false;

        
    }
    
    public function updateDetailTransaksi($id_transaksi, $items) {
        // 1. Ambil detail lama dulu
        $query = "SELECT id_produk, quantity FROM master_detail_transaksi WHERE id_transaksi = $id_transaksi";
        $result = $this->conn->query($query);
    
        // 2. Kembalikan stok produk dari detail lama
        while ($row = $result->fetch_assoc()) {
            $id_produk = $row['id_produk'];
            $qty = $row['quantity'];
            $this->conn->query("UPDATE master_produk SET stok = stok + $qty WHERE id = $id_produk");
        }
    
        // 3. Hapus detail lama
        $query = "DELETE FROM master_detail_transaksi WHERE id_transaksi = $id_transaksi";
        if (!$this->conn->query($query)) {
            return false;
        }
    
        // 4. Insert detail baru dan kurangi stok
        foreach ($items as $item) {
            $id_produk = $item['id_produk'];
            $qty = $item['quantity'];
    
            $query = "INSERT INTO master_detail_transaksi (id_transaksi, id_produk, quantity) 
                      VALUES ($id_transaksi, $id_produk, $qty)";
            if (!$this->conn->query($query)) {
                return false;
            }
    
            $this->conn->query("UPDATE master_produk SET stok = stok - $qty WHERE id = $id_produk");
        }
    
        return true;
    }
    
    
    
}

?>