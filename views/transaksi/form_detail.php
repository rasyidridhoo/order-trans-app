<div class="modal-header">
  <h5 class="modal-title">Detail Transaksi</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
  <p><strong>Kode Transaksi:</strong> <?= $transaksi['kode_transaksi'] ?></p>
  <p><strong>No Transaksi:</strong> <?= $transaksi['id'] ?></p>
  <p><strong>Tanggal:</strong> <?= $transaksi['tanggal'] ?></p>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      while($item = $items->fetch_assoc()):
        $sub = $item['quantity'] * $item['harga'];
        $total += $sub;
      ?>
      <tr>
        <td><?= $item['produk'] ?></td>
        <td><?= $item['quantity'] ?></td>
        <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
        <td>Rp <?= number_format($sub, 0, ',', '.') ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="text-end">Total</th>
        <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
      </tr>
    </tfoot>
  </table>
</div>
