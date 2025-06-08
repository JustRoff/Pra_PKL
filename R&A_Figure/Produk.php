<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin']) && !isset($_SESSION['id_user'])) {
    header("Location:login.php?Logindulu");
    exit;
}

$id_produk = $_GET['id_produk'];

$sql1 = "SELECT * FROM produk WHERE id_produk='$id_produk'";
$query1 = mysqli_query($koneksi, $sql1);

// Query untuk mengambil 5 produk random, tapi tidak termasuk produk yang sedang dilihat dan hanya yang masih ada stok
$sql2 = "SELECT * FROM produk WHERE id_produk != '$id_produk' AND stok > 0 ORDER BY RAND() LIMIT 5";
$query2 = mysqli_query($koneksi, $sql2);

while($produk = mysqli_fetch_assoc($query1)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produk['nama_produk'] ?> - Product Detail</title>
    <link rel="stylesheet" href="css/produk.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Styling untuk section produk lainnya */
        .other-products {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        
        .other-products h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-family: Arial, sans-serif;
        }
        
        /* Container untuk produk random */
        .random-products {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        /* Styling produk item - menggunakan style yang sama dengan style.css */
        .random-products .produk-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
        }
        
        .random-products .produk-item img {
            max-width: 100%;
            border-radius: 5px;
        }
        
        .random-products .produk-item h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        
        .random-products .status {
            font-weight: bold;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 5px;
        }
        
        .random-products .available {
            color: green;
            border: 1px solid green;
        }
        
        .random-products .sold-out {
            color: red;
            border: 1px solid red;
        }
        
        /* Container untuk tombol see more */
        .see-more-container {
            text-align: center;
            margin-top: 20px;
        }
        
        /* Styling tombol see more - mengikuti gaya rounded-button */
        .see-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: orange;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
        }
        
        .see-more-btn:hover {
            background-color: darkorange;
            color: white;
        }
        
        .arrow-icon {
            font-size: 16px;
            transition: transform 0.3s ease;
        }
        
        .see-more-btn:hover .arrow-icon {
            transform: translateX(3px);
        }
        
        /* Navigation buttons */
        .navigation-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .nav-btn {
            background-color: gray;
            color: white;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
        }
        
        .nav-btn:hover {
            background-color: #555;
            color: white;
        }
        
        /* Responsif untuk mobile */
        @media (max-width: 768px) {
            .random-products {
                flex-direction: column;
                align-items: center;
            }
            
            .navigation-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
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
      <button type="submit" class="btn-orange">Add to Cart</button>
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

<!-- Section untuk produk lainnya -->
<div class="other-products">
    <h2>You Might Also Like</h2>
    
    <?php if (mysqli_num_rows($query2) > 0): ?>
        <div class="random-products">
            <?php while ($other_produk = mysqli_fetch_assoc($query2)): ?>
                <a href="produk.php?id_produk=<?= $other_produk['id_produk'] ?>" style="text-decoration: none; color: inherit;">
                    <div class="produk-item">
                        <img src="gambar_produk/<?= $other_produk['gambar'] ?>" alt="<?= $other_produk['nama_produk'] ?>">
                        <p><span class="status <?= ($other_produk['stok'] > 0) ? 'available' : 'sold-out' ?>">
                            <?= ($other_produk['stok'] > 0) ? 'Available' : 'Sold Out' ?>
                        </span></p>
                        <h3><?= $other_produk['nama_produk'] ?></h3>
                        <p>Harga: <strong>Rp <?= number_format($other_produk['harga'], 0, ',', '.') ?></strong></p>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
        
        <!-- Tombol See More -->
        <div class="see-more-container">
            <a href="DaftarProduk.php" class="see-more-btn">
                <span>See More Products</span>
                <span class="arrow-icon">→</span>
            </a>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: #666;">No other products available at the moment.</p>
    <?php endif; ?>
</div>

<!-- Navigation buttons -->
<div class="navigation-buttons">
    <a href="DaftarProduk.php" class="nav-btn">All Products</a>
</div>

</body>
</html>
<?php } ?>
