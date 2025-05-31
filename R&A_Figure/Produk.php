<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin']) && !isset($_SESSION['id_user'])) {
    header("Location:login.php?Logindulu");
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
    <link rel="stylesheet" href="css/produk.css">
</head>
<body>
<div class="produk-container">
  <div class="produk-img">
    <img src="gambar_produk/<?= $produk['gambar'] ?>" alt="<?= $produk['nama_produk'] ?>">
  </div>
  <div class="produk-info">
    <h1><?= $produk['nama_produk'] ?></h1>
    <div class="harga">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></div>
    <?php if ($produk['stok'] > 0): ?>
      <div class="available">Available Now</div>
      <div class="stok"><?= $produk['stok'] ?> item(s) left</div>
    <?php else: ?>
      <div class="available" style="color:red;">Out of Stock</div>
    <?php endif; ?>
    <div class="buttons">
      
    <form action="proses_keranjang.php" method="post">
      <label for="">Qty</label>
      <input type="number" name="jumlah_item" min="1" max="<?=$produk['stok']?>" id="" placeholder="0">
      <input type="hidden" name="id_produk" value="<?=$produk['id_produk']?>">
      <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
      <button type="submit"class="btn-orange">Add to Cart</button>
    </form>

    </div>
  </div>
</div>

<div class="deskripsi">
  <h2>Product Description</h2>
  <p><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>
</div>

<div class="spesifikasi">
  <h2>Product Specification</h2>
  <table>
    <tr><td>Product Name</td><td><?= $produk['nama_produk'] ?></td></tr>
    <tr><td>Manufacturer</td><td><?= $produk['manufacturer'] ?></td></tr>
    <tr><td>Category</td><td><?= $produk['kategori'] ?></td></tr>
    <tr><td>Release Date</td><td><?= $produk['tanggal_terbit'] ?></td></tr>
    <tr><td>Rating</td><td><?= $produk['rating'] ?>/5</td></tr>
  </table>
</div>
<a href="keranjang.php"><button>keranjang</button></a>
</body>
</html>
<?php } ?>