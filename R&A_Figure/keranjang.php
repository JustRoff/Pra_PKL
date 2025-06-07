<?php 
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?Logindulu");
    exit;
}

$_SESSION['from_page'] = 'keranjang.php';
$id_user = $_SESSION['id_user'];    

$sql = "SELECT  keranjang.id_keranjang,
                keranjang.subtotal,
                keranjang.jumlah_item,
                produk.id_produk as id_produk,
                produk.nama_produk as nama_produk,
                produk.harga as harga,
                produk.gambar as gambar,
                produk.stok as stok
                from keranjang
                join produk on keranjang.id_produk=produk.id_produk
                WHERE keranjang.id_user = '$id_user' ";

$query = mysqli_query($koneksi,$sql);
$jumlah_keranjang = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/keranjang.css">
</head>
<body>
    <form action="transaksi.php" method="POST">
<?php if ($jumlah_keranjang > 0 ) { ?>
    <?php while ($keranjang = mysqli_fetch_assoc($query)) { ?>
        <div class="cart-item">
            <!-- ✅ Checkbox untuk pilih item -->
            <input type="checkbox" class="select-item" name="checkout_items[]" value="<?= $keranjang['id_produk'] ?>">

            <div class="product-image">
                <img src="gambar_produk/<?= $keranjang['gambar'] ?>" alt="<?= $keranjang['nama_produk'] ?>" width="100">
            </div>
            <div class="product-details">
                <a href="produk.php?id_produk=<?= $keranjang['id_produk'] ?>">
                    <h4><?= $keranjang['nama_produk'] ?></h4>
                </a>
                <p>IDR <?= number_format($keranjang['harga'], 0, ',', '.') ?></p>
            </div>
            <div class="product-actions">
                <div class="quantity">
                    <button class="btn-minus" type="button">-</button>
                    <input type="number"
                        class="qty"
                        min="1"
                        max="<?=$keranjang['stok']?>"
                        value="<?= $keranjang['jumlah_item'] ?>"
                        data-harga="<?= $keranjang['harga'] ?>"
                        data-id="<?= $keranjang['id_keranjang'] ?>">
                    <button class="btn-plus" type="button">+</button>
                </div>
                <div class="subtotal">
                    <strong>IDR <?= number_format($keranjang['subtotal'], 0, ',', '.') ?></strong>
                </div>
                <button class="btn-delete" type="button" data-id="<?= $keranjang['id_keranjang'] ?>">Hapus</button>
            </div>
        </div>
    <?php } ?>
    
<div id="total-bayar" style="margin-top: 20px;">
    Total Bayar: <strong id="total-text">Rp 0</strong>
</div>

    <button type="submit" style="margin-top: 20px;">Checkout Produk Terpilih</button>
<?php } else { ?>
    <p>Kamu belum belanja apapun</p>
    <a href="DaftarProduk.php">Khilaf yuk</a>
<?php } ?>
</form>
    <a href="DaftarProduk.php">nambah yuk</a>
<script src="script/keranjang.js?<?=time() ?>"></script>
</body>
</html>