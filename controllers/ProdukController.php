<?php

require_once '../models/Produk.php';

class ProdukController {
    private $produk;

    public function __construct($db) {
        $this->produk = new Produk($db);
    }

    public function index() {
        $data = $this->produk->getAll();
        include '../views/produk/index.php';
    }

    public function detail($id): void {
        $row = $this->produk->getById($id);
        include '../views/produk/form_detail.php';
    }

    public function formEdit($id) {
        $row = $this->produk->getById($id);
        include '../views/produk/form_edit.php';
    }

    public function formTambah() {
        include '../views/produk/form_tambah.php';
    }

    public function simpan($post) {
        $this->produk->insert($post['produk'], $post['stok'], $post['harga']);
        header("Location: index.php");
    }

    public function update($post) {
        $this->produk->update($post['id'], $post['produk'], $post['stok'], $post['harga']);
        header("Location: index.php");
    }

    public function hapus($id) {
        $this->produk->delete($id);
        header("Location: index.php");
    }
}

?>