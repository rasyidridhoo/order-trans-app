<form action="index.php?page=transaksi&action=simpan" method="POST">
<button type="button" class="btn btn-secondary" id="tambah-barang">Tambah Barang</button>
<br>
<br>
  <div id="produk-list">
    <!-- Row pertama (default) -->
    <div class="produk-row mb-3" id="row-1">
      <label for="produk[]" class="form-label">Pilih Produk</label>
      <select class="form-select produk" name="produk[]" required>
        <option value="">-- Pilih Produk --</option>
        <?php
        // Ambil data produk dari database
        $produkData = $this->produk->getAll();
        while ($produk = $produkData->fetch_assoc()) {
          echo "<option value='{$produk['id']}' data-stok='{$produk['stok']}'>{$produk['produk']} ({$produk['stok']}) - Rp " . number_format($produk['harga'], 0, ',', '.') . "</option>";
        }
        ?>
      </select>
      <label for="quantity[]" class="form-label">Quantity</label>
      <input type="number" name="quantity[]" class="form-control quantity" min="1" required>
      <button type="button" class="btn btn-danger btn-sm remove-row" style="display:none;">x</button>
    </div>
  </div>
  <br>
  <br>
  <button type="submit" class="btn btn-primary">Simpan</button>
  
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
                {$produk['produk']} - Rp " . number_format($produk['harga'], 0, ',', '.') . "
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