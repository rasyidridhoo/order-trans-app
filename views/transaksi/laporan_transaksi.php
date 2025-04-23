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
SELECT 
    mt.kode_transaksi,
    mt.tanggal,
    mp.produk,
    mdt.quantity,
    mp.harga,
    (mdt.quantity * mp.harga) AS total
FROM master_transaksi mt
JOIN master_detail_transaksi mdt ON mt.id = mdt.id_transaksi
JOIN master_produk mp ON mdt.id_produk = mp.id
$where_sql
ORDER BY mt.tanggal ASC
";

$result = $conn->query($sql);
if (!$result) {
    die("Query error: " . $conn->error . "<br><br>SQL: <pre>$sql</pre>");
}


$totalSemua = 0;
?>

<style>
  @media print {
    .no-print {
      display: none;
    }
  }
</style>

<div style="margin-bottom: 20px;" class="no-print">
  <button onclick="window.print()" id="print">Cetak</button>
</div>
<h2>Laporan Transaksi</h2>
<p>
  <?php if (!empty($start_date) && !empty($end_date)): ?>
    Periode: <?= date('d-m-Y', strtotime($start_date)) ?> s/d <?= date('d-m-Y', strtotime($end_date)) ?>
  <?php else: ?>
    Semua Periode
  <?php endif; ?>
</p>

<table border="1" cellpadding="5" cellspacing="0">
  <thead>
    <tr>
      <th>No.</th>
      <th>Kode Transaksi</th>
      <th>Tanggal</th>
      <th>Produk</th>
      <th>Jumlah</th>
      <th>Harga</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; while ($row = $result->fetch_assoc()): 
        $totalSemua += $row['total'];
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['kode_transaksi']) ?></td>
      <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></td>
      <td><?= htmlspecialchars($row['produk']) ?></td>
      <td><?= $row['quantity'] ?></td>
      <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
      <td><?= number_format($row['total'], 0, ',', '.') ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="6"><strong>Total</strong></td>
      <td><strong>Rp <?= number_format($totalSemua, 0, ',', '.') ?></strong></td>
    </tr>
  </tfoot>
</table>
