<div class="modal-header">
  <h5 class="modal-title">Detail Produk</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
  <p><strong>Nama Produk:</strong> <?= $row['produk'] ?></p>
  <p><strong>Stok:</strong> <?= $row['stok'] ?></p>
  <p><strong>Harga:</strong> Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
