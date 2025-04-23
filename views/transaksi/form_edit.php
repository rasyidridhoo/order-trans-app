<form action="index.php?page=transaksi&action=update&id=<?= $transaksi['id'] ?>" method="POST">
  <div class="mb-3">
    <label for="kode_transaksi" class="form-label">Kode Transaksi</label>
    <input type="text" class="form-control" name="kode_transaksi" value="<?= $transaksi['kode_transaksi'] ?>" required>
  </div>

  <div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal Transaksi</label>
    <input type="datetime-local" class="form-control" name="tanggal" value="<?= date('Y-m-d\TH:i', strtotime($transaksi['tanggal'])) ?>" required>
  </div>

  <button type="button" class="btn btn-secondary" id="tambah-barang">Tambah Barang</button>  <br><br>

  <div id="produk-list">
    <?php foreach ($produkDetail as $index => $item) { ?>
      <div class="produk-row mb-3" id="row-<?= $index + 1 ?>">
        <label class="form-label">Pilih Produk</label>
        <select class="form-select produk" name="produk[]" required>
          <option value="">-- Pilih Produk --</option>
          <?php
          $produkData = $this->produk->getAll();
          while ($produk = $produkData->fetch_assoc()) {
            $selected = $item['id_produk'] == $produk['id'] ? "selected" : "";
            echo "<option value='{$produk['id']}' $selected>" .
                 htmlspecialchars($produk['produk']) . " ({$produk['stok']}) - Rp " .
                 number_format($produk['harga'], 0, ',', '.') .
                 "</option>";
          }
          ?>
        </select>
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity[]" class="form-control quantity" value="<?= $item['quantity'] ?>" min="1" required>
        <button type="button" class="btn btn-danger btn-sm remove-row">x</button>
      </div>
    <?php } ?>
  </div>

  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>


<script>
  let rowCount = 1; // Untuk mengatur ID baris yang unik

// Menambah baris produk baru
document.getElementById('tambah-barang').addEventListener('click', function() {
  rowCount++;
  const produkList = document.getElementById('produk-list');
  const newRow = document.createElement('div');
  newRow.classList.add('produk-row', 'mb-3');
  newRow.id = 'row-' + rowCount;

  // HTML untuk baris baru
  newRow.innerHTML = `
    <label for="produk[]" class="form-label">Pilih Produk</label>
    <select class="form-select produk" name="produk[]" required>
      <option value="">-- Pilih Produk --</option>
      <?php
      // Ambil data produk dari database
      $produkData = $this->produk->getAll();
      while ($produk = $produkData->fetch_assoc()) {
        echo "<option value='{$produk['id']}' data-stok='{$produk['stok']}'>
                {$produk['produk']} ({$produk['stok']}) - Rp " . number_format($produk['harga'], 0, ',', '.') . "
              </option>";
      }
      ?>
    </select>
    <label for="quantity[]" class="form-label">Quantity</label>
    <input type="number" name="quantity[]" class="form-control quantity" min="1" required>
    <button type="button" class="btn btn-danger btn-sm remove-row">x</button>
  `;

  // Menambahkan baris baru ke produk list
  produkList.appendChild(newRow);

  // Menampilkan tombol hapus (x) di baris baru
  newRow.querySelector('.remove-row').style.display = 'inline-block';
});

// Menghapus baris produk yang ditambahkan
document.addEventListener('click', function(event) {
  if (event.target.classList.contains('remove-row')) {
    const row = event.target.closest('.produk-row');
    row.remove();
  }
});



</script>
