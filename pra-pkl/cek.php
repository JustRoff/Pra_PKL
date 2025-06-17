<div class="form-container">
  <h2>Table Produk</h2>
  <form method="POST" enctype="multipart/form-data">
    
    <div class="form-group">
      <label for="nama">Nama Produk</label>
      <input type="text" name="nama" id="nama">
    </div>

    <div class="form-group">
      <label for="kategori">Kategori</label>
      <select name="kategori" id="kategori">
        <option>Pilih Kategori</option>
        <!-- lainnya -->
      </select>
    </div>

    <div class="form-group">
      <label for="manufacturer">Manufacturer</label>
      <input type="text" name="manufacturer" id="manufacturer">
    </div>

    <div class="form-group">
      <label for="tanggal">Tanggal Terbit</label>
      <input type="date" name="tanggal" id="tanggal">
    </div>

    <div class="form-group">
      <label for="harga">Harga</label>
      <input type="number" name="harga" id="harga">
    </div>

    <div class="form-group">
      <label for="stok">Stok</label>
      <input type="number" name="stok" id="stok">
    </div>

    <div class="form-group">
      <label for="rating">Rating</label>
      <input type="number" step="0.1" name="rating" id="rating">
    </div>

    <div class="form-group">
      <label for="deskripsi">Deskripsi</label>
      <textarea name="deskripsi" id="deskripsi"></textarea>
    </div>

    <div class="form-group">
      <label for="gambar">Gambar</label>
      <input type="file" name="gambar" id="gambar">
    </div>

    <button type="submit" class="submit-button">Tambah Produk</button>
  </form>
</div>
