<?php

class Produk {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM master_produk");
    }

    public function getById($id) {
        $id = (int)$id;  
    
        $query = "SELECT * FROM master_produk WHERE id = $id";
        $result = $this->conn->query($query);
    
        return $result ? $result->fetch_assoc() : null;
    }
    

    public function insert($produk, $stok, $harga) {
        $produk = $this->conn->real_escape_string($produk);
        $stok = (int)$stok;
        $harga = (int)$harga;
    
        $query = "INSERT INTO master_produk (produk, stok, harga) VALUES ('$produk', $stok, $harga)";
        return $this->conn->query($query);
    }
    

    public function update($id, $produk, $stok, $harga) {
        $id = (int)$id;
        $produk = $this->conn->real_escape_string($produk);
        $stok = (int)$stok;
        $harga = (int)$harga;
        $query = "UPDATE master_produk SET produk='$produk', stok=$stok, harga=$harga WHERE id=$id";
        return $this->conn->query($query);
    }
    

    public function delete($id) {
        $id = (int)$id;
        $query = "DELETE FROM master_produk WHERE id = $id";
        return $this->conn->query($query);
    }
    
    public function getStok($id_produk) {
        $id_produk = (int)$id_produk;
        $query = "SELECT stok FROM master_produk WHERE id = $id_produk";
        $result = $this->conn->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['stok'];
        }
        return 0;
    }
    
}


?>