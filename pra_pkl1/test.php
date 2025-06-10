<?php
// koneksi database
include 'koneksi.php';

$id_produk = $_GET['id_produk'];
$sql = "SELECT * FROM produk WHERE id_produk ='$id_produk' ";
$query = mysqli_query($koneksi, $sql);

while ($produk = mysqli_fetch_assoc($query)) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title><?php echo $data['nama']; ?> | R&A Figure</title> -->
    <title>Produk</title>
  <style>
    body {
      font-family: monospace;
      background-color: #fff;
      margin: 0;
      padding: 0;
    }
    header, footer {
      background-color: #f5f5f5;
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header img {
      height: 40px;
    }
    .content {
      max-width: 1000px;
      margin: 0 auto;
      padding: 30px;
    }
    .product-container {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
    }
    .product-image {
      flex: 1;
    }
    .product-image img {
      max-width: 100%;
      border: 1px solid #ccc;
    }
    .product-info {
      flex: 1;
    }
    .product-info h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }
    .product-info .price {
      font-size: 20px;
      margin: 10px 0;
    }
    .btn {
      background-color: orange;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }
    .section {
      margin-top: 40px;
    }
    .section h2 {
      font-size: 20px;
      border-bottom: 1px dashed #000;
      padding-bottom: 5px;
    }
    .section ul {
      list-style: none;
      padding: 0;
    }
    .section ul li {
      margin-bottom: 5px;
    }
    footer {
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>
<body>

<header>
  <img src="img/logo.png" alt="R&A Figure">
  <nav>
    <a href="#">About us</a> |
    <a href="#">Products</a> |
    <a href="#">Cart</a>
  </nav>
</header>

<div class="content">
  <div class="product-container">
    <div class="product-image">
      <img src="gambar_produk/<?php echo $produk['gambar']; ?>" alt="<?php echo $produk['nama_produk']; ?>">
    </div>
    <div class="product-info">
      <h1><?php echo $produk['nama_produk']; ?></h1>
      <p class="price">Rp<?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
      <p><strong>Available Now</strong></p>

      <form action="proses_keranjang.php" method="POST">
        <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
        <input type="number" name="jumlah" value="1" min="1">
        <br>
        <button type="submit" class="btn">Add to Cart</button>
      </form>
      <p style="margin-top: 10px;">Log in to add into your list and make purchase</p>
    </div>
  </div>

  <div class="section">
    <h2>Product Description</h2>
    <p><?php echo nl2br($produk['deskripsi']); ?></p>
  </div>

  <div class="section">
    <h2>Product Specification</h2>
    <ul>
      <li>Series: <?php echo $produk['seri']; ?></li>
      <li>Specification: <?php echo $data['spesifikasi']; ?></li>
      <li>Sculptor: <?php echo $data['pematung']; ?></li>
      <li>Production Cooperation: <?php echo $data['kerjasama']; ?></li>
      <li>Design / Illustration: <?php echo $data['desain']; ?></li>
      <li>Manufacturer: <?php echo $data['produsen']; ?></li>
      <li>Distributed by: R&A Figure Store</li>
    </ul>
  </div>
</div>

<footer>
  <div>
    Official Social Media Accounts<br>
    <img src="img/x.png" height="20"> <img src="img/youtube.png" height="20"> <img src="img/ig.png" height="20">
  </div>
  <p>&copy; 2025 R&A Figure. All Rights Reserved.</p>
</footer>

</body>
</html>

<?php } ?>