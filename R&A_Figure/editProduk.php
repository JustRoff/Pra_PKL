<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$id_produk= $_GET['id_produk'];

$sql = "Select * from produk where id_produk='$id_produk' ";
$query = mysqli_query($koneksi,$sql);

while($produk=mysqli_fetch_assoc($query)) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Form Edit</h1>

<form action="Proses_editProduk.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">

  <label for="">Nama Produk</label>
  <input type="text" name="nama_produk" value="<?= $produk['nama_produk'] ?>" required><br>

  <label for="">Kategori</label>
  <select name="kategori" required>
    <option value="" disabled <?= ($produk['kategori'] == '') ? 'selected' : '' ?>>Pilih Kategori</option>
    <option value="Nendoroid" <?= ($produk['kategori'] == 'Nendoroid') ? 'selected' : '' ?>>Nendoroid</option>
    <option value="Figma" <?= ($produk['kategori'] == 'Figma') ? 'selected' : '' ?>>Figma</option>
    <option value="1/12" <?= ($produk['kategori'] == '1/12') ? 'selected' : '' ?>>1/12</option>
    <option value="1/8" <?= ($produk['kategori'] == '1/8') ? 'selected' : '' ?>>1/8</option>
    <option value="1/7" <?= ($produk['kategori'] == '1/7') ? 'selected' : '' ?>>1/7</option>
    <option value="1/6" <?= ($produk['kategori'] == '1/6') ? 'selected' : '' ?>>1/6</option>
  </select><br>

  <label for="">Manufacturer</label>
  <input type="text" name="manufacturer" value="<?= $produk['manufacturer'] ?>" required><br>

  <label for="">Tanggal Terbit</label>
  <input type="date" name="tanggal_terbit" vaue="<?= $produk['tanggal_terbit'] ?>" required><br>

  <label for="">Harga</label>
  <input type="number" name="harga" value="<?= $produk['harga'] ?>" required><br>

  <label for="">Stok</label>
  <input type="number" name="stok" value="<?= $produk['stok'] ?>" required><br>

  <label for="">Rating</label>
  <input type="number" name="rating" value="<?= $produk['rating'] ?>" min="0" max="5" required><br>

  <label>Gambar Lama</label><br>
  <img src="gambar_produk/<?= $produk['gambar'] ?>" width="200" alt="Gambar Lama"><br><br>

  <label>Gambar Baru (jika ingin diganti)</label><br>
  <input type="file" name="gambar" id="gambarInput" onchange="previewGambar()"><br><br>

  <img id="gambarPreview" src="" alt="Preview Gambar Baru" width="200" style="display:none; border: 1px solid #ccc; padding:5px;"><br><br>

  <input type="submit" value="Simpan">
</form>

<script>
    function previewGambar() {
        const input = document.getElementById('gambarInput');
        const preview = document.getElementById('gambarPreview');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            }
            reader.readAsDataURL(file);
        }
    }
    </script>

</body>
</html>

<?php } ?>