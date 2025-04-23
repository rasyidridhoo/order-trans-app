<form action="index.php?action=simpan" method="POST">
  <div class="modal-header">
    <h5 class="modal-title">Tambah Produk</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  </div>
  <div class="modal-body">
    <div class="mb-3">
      <label for="produk" class="form-label">Nama Produk</label>
      <input type="text" class="form-control" id="produk" name="produk" required>
    </div>
    <div class="mb-3">
      <label for="stok" class="form-label">Stok</label>
      <input type="number" class="form-control" id="stok" name="stok" required>
    </div>
    <div class="mb-3">
      <label for="harga" class="form-label">Harga</label>
      <input type="number" class="form-control" id="harga" name="harga" required>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>
</form>
