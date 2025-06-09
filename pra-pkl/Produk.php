<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin']) && !isset($_SESSION['id_user'])) {
    header("location:login1.php?Logindulu");
    exit;
}

$id_produk = $_GET['id_produk'];

$sql = "SELECT * FROM produk WHERE id_produk = '$id_produk' ";
$query = mysqli_query($koneksi,$sql);

while ($produk = mysqli_fetch_assoc($query)) {

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Terpilih</title>
    <link rel="stylesheet" href="css/ProdukIn.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" >
        <nav>
            <div class="profile-icon">    
                <a href="DaftarProduk.php">Products</a>
                <a href="keranjang.php">Cart</a>
                <a href="cek_profil.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <div class="produk-container">
            <div class="produk-img">
                <img src="gambar_produk/<?= $produk['gambar'] ?>" alt="<?= $produk['nama_produk'] ?>" srcset="">
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
    </main>

    <footer>
        <div class="footer-left">
            <p>Official Social Media Account</p>
            <div class="social-icons">
                <a href="https://x.com/" class="x-icon"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://www.youtube.com/" class="yt-icon"><i class="fa-brands fa-youtube"></i></a>
                <a href="https://www.instagram.com/" class="ig-icon"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-right">
            <a href="about.php">About Us</a>
            <a href="homepage.php">R&A Figure Store</a>
        </div>
    </footer>
</body>
</html>

<?php } ?>