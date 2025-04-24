<?php
include(__DIR__ . '/../../config/config.php');


$search = $_GET['search'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$where = [];

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $where[] = "(mt.kode_transaksi LIKE '%$search%' OR mp.produk LIKE '%$search%')";
}
if (!empty($start_date) && !empty($end_date)) {
    $start = $conn->real_escape_string($start_date);
    $end = $conn->real_escape_string($end_date);
    $where[] = "DATE(mt.tanggal) BETWEEN '$start' AND '$end'";
}

$where_sql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "
  SELECT DISTINCT mt.*
  FROM master_transaksi mt
  LEFT JOIN master_detail_transaksi mdt ON mt.id = mdt.id_transaksi
  LEFT JOIN master_produk mp ON mdt.id_produk = mp.id
  $where_sql
  ORDER BY mt.tanggal DESC
";

if ($conn) {
  $data = $conn->query($sql);
} else {
  die("Koneksi gagal");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
    }

    .wrapper {
      display: flex;
    }

    .sidebar {
      width: 250px;
      background: #ffffff;
      height: 100vh;
      padding-top: 20px;
      position: fixed;
      transition: all 0.3s ease;
      border-right: 1px solid #ccc;
    }

    .sidebar a {
      color: #333;
      display: block;
      padding: 10px 20px;
      text-decoration: none;
    }

    .sidebar a:hover {
      background-color: #f1f1f1;
    }

    .sidebar h4 {
      text-align: center;
      margin-bottom: 1rem;
      font-weight: bold;
      color: #333;
    }

    .content {
      margin-left: 250px;
      padding: 20px;
      width: 100%;
      transition: margin-left 0.3s ease;
    }

    .toggled .sidebar {
      margin-left: -250px;
    }

    .toggled .content {
      margin-left: 0;
    }

    .toggle-btn {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      margin: 10px;
    }
  </style>
</head>
<body>

  <div class="wrapper toggled" id="wrapper">
    <div class="sidebar">
      <h4></h4>
      <a href="http://localhost/toko_appnew/public/index.php?page=produk">Produk</a>
      <a href="http://localhost/toko_appnew/public/index.php?page=transaksi">Transaksi</a>
    </div>

    <div class="content">
      <button class="toggle-btn" onclick="toggleSidebar()" style="margin-left: -4px;">☰</button>
  <h2>Daftar Transaksi</h2>
  <button class="btn btn-primary mb-3" onclick="openTambah()">Tambah Transaksi</button>
  <form method="GET" class="row g-2 mb-4">
  <input type="hidden" name="page" value="transaksi">
  <div class="col-md-4">
    <input type="text" class="form-control" name="search" placeholder="Cari kode transaksi / nama barang" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
  </div>
  <div class="col-md-3">
    <input type="date" class="form-control" name="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
  </div>
  <div class="col-md-3">
    <input type="date" class="form-control" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
  </div>
  <div class="col-md-2">
    <button type="submit" class="btn btn-primary w-70">Filter</button>
    <button type="button" class="btn btn-success w-70" onclick="cetakLaporan()">Cetak</button>
  </div>
</form>


  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>No</th><th>Kode Transaksi</th><th>No Transaksi</th><th>Tanggal</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; while($row = $data->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['kode_transaksi']) ?></td>
        <td><?= $row['id'] ?></td>
        <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></td>
        <td>
          <button class="btn btn-sm btn-info" onclick="openDetail(<?= $row['id'] ?>)">Detail</button>
          <button class="btn btn-sm btn-warning" onclick="openEdit(<?= $row['id'] ?>)">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="confirmHapus(<?= $row['id'] ?>)">Hapus</button>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div class="modal fade" id="transaksiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="modalContent"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Fungsi untuk membuka form tambah transaksi
    function openTambah() {
      const url = "http://localhost/toko_appnew/public/index.php?page=transaksi&action=tambah"; // Ubah ke http
      const windowName = "Tambah Transaksi";
      const windowSize = "width=800,height=600";

      window.open(url, windowName, windowSize);
    }

    // Fungsi untuk membuka form edit transaksi
    function openEdit(id) {
      const url = "http://localhost/toko_appnew/public/index.php?page=transaksi&action=edit&id=" + id; // URL untuk edit
      const windowName = "Edit Transaksi";
      const windowSize = "width=800,height=600";

      window.open(url, windowName, windowSize);  // Membuka jendela baru untuk form edit
    }

    // Fungsi untuk membuka form detail transaksi
    function openDetail(id) {
      fetch('index.php?page=transaksi&action=detail&id=' + id)
        .then(res => res.text())
        .then(html => {
          document.getElementById('modalContent').innerHTML = html;
          new bootstrap.Modal(document.getElementById('transaksiModal')).show();
        });
    }

    // Fungsi untuk mengonfirmasi hapus transaksi
    function confirmHapus(id) {
      const isConfirmed = confirm("Apakah Anda yakin ingin menghapus transaksi ini?");
      if (isConfirmed) {
        window.location.href = 'index.php?page=transaksi&action=hapus&id=' + id;
      }
    }
  </script>

<script>
    function toggleSidebar() {
      document.getElementById('wrapper').classList.toggle('toggled');
    }
  </script>

<script>
  function cetakLaporan() {
    const search = document.querySelector('[name="search"]').value;
    const startDate = document.querySelector('[name="start_date"]').value;
    const endDate = document.querySelector('[name="end_date"]').value;

    const url = `http://localhost/toko_appnew/views/transaksi/laporan_transaksi.php?search=${encodeURIComponent(search)}&start_date=${startDate}&end_date=${endDate}`;
    window.open(url, "_blank", "width=1000,height=600");
  }
</script>
</body>
</html>
