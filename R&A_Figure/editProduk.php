<?php
include "koneksi.php";
// session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location:login.php?Logindulu");
//     exit;
// }

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

<form action="Proses_editProduk.php" method="get">
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
  <input type="date" name="tanggal_terbit" value="<?= $produk['tanggal_terbit'] ?>" required><br>

  <label for="">Harga</label>
  <input type="number" name="harga" value="<?= $produk['harga'] ?>" required><br>

  <label for="">Stok</label>
  <input type="number" name="stok" value="<?= $produk['stok'] ?>" required><br>

  <label for="">Rating</label>
  <input type="number" name="rating" value="<?= $produk['rating'] ?>" min="0" max="5" required><br>

  <label for="">ID Admin</label>
  <select name="id_admin" required>
    <option value="" disabled <?= ($produk['id_admin'] == '') ? 'selected' : '' ?>>Pilih Admin Yang Menambah</option>
    <option value="1" <?= ($produk['id_admin'] == 1) ? 'selected' : '' ?>>Rofi</option>
    <option value="2" <?= ($produk['id_admin'] == 2) ? 'selected' : '' ?>>Alip</option>
  </select><br><br>

  <input type="submit" value="Simpan">
</form>

</body>
</html>

<?php } ?>