<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Produk</title>
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
      <h2>Data Produk</h2>
  <button class="btn btn-primary mb-3" onclick="openTambah()">Tambah Produk</button>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th><th>Produk</th><th>Stok</th><th>Harga</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while($row = $data->fetch_assoc()) {
        echo "<tr>
                <td>$no</td>
                <td>{$row['produk']}</td>
                <td>{$row['stok']}</td>
                <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                <td>
                  <button class='btn btn-sm btn-info' onclick='openDetail({$row['id']})'>Detail</button>
                  <button class='btn btn-sm btn-warning' onclick='openEdit({$row['id']})'>Edit</button>
                  <button class='btn btn-sm btn-danger' onclick='confirmHapus({$row['id']})'>Hapus</button>
                </td>
              </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="produkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="modalContent"></div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('wrapper').classList.toggle('toggled');
    }
  </script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script>
    function openTambah() {
      fetch('index.php?action=tambah')
        .then(res => res.text())
        .then(html => {
          document.getElementById('modalContent').innerHTML = html;
          new bootstrap.Modal(document.getElementById('produkModal')).show();
        });
    }

    function openEdit(id) {
      fetch('index.php?action=edit&id=' + id)
        .then(res => res.text())
        .then(html => {
          document.getElementById('modalContent').innerHTML = html;
          new bootstrap.Modal(document.getElementById('produkModal')).show();
        });
    }

    function openDetail(id) {
      fetch('index.php?action=detail&id=' + id)
        .then(res => res.text())
        .then(html => {
          document.getElementById('modalContent').innerHTML = html;
          new bootstrap.Modal(document.getElementById('produkModal')).show();
        });
    }

    function confirmHapus(id) {
      const isConfirmed = confirm("Apakah Anda yakin ingin menghapus produk ini?");
      if (isConfirmed) {
        window.location.href = 'index.php?action=hapus&id=' + id;
      }
    }
  </script>

</body>
</html>
