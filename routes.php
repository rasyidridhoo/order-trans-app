<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/config.php';

$page = $_GET['page'] ?? 'produk';  
$action = $_GET['action'] ?? 'index'; 
$id = $_GET['id'] ?? null;

switch($page) {
    case 'produk':
        require_once 'controllers/ProdukController.php';
        $controller = new ProdukController($conn);
        switch ($action) {
            case 'detail':
                $controller->detail($id);
                break;
            case 'edit':
                $controller->formEdit($id);
                break;
            case 'tambah':
                $controller->formTambah();
                break;
            case 'simpan':
                $controller->simpan($_POST);
                break;
            case 'update':
                $controller->update($_POST);
                break;
            case 'hapus':
                $controller->hapus($id);
                break;
            case 'index':
            default:
                $controller->index(); // <= ini yang belum ada
                break;
        }
        break;
    case 'transaksi':
        require_once 'controllers/TransaksiController.php';
        $controller = new TransaksiController($conn);
        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'tambah':
                $controller->formTambah();
                break;
            case 'edit':
                $controller->formEdit($id);
                break;
            case 'simpan':
                $controller->simpan($_POST);
                break;
            case 'update':
                $controller->update($_POST);
                break;
            case 'hapus':
                $controller->hapus($id);
                break;
            case 'detail':
                $controller->detail($id);
                break;
            default:
                $controller->index();
                break;
        }
        break;
}



?>
