<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin']) && !isset($_SESSION['username'])) {
    header("Location:login.php?Logindulu");
    exit;
} 
$sql = "SELECT * FROM produk ORDER BY tanggal_terbit DESC";
$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }
        .produk-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .produk-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
        }
        .produk-item img {
            max-width: 100%;
            border-radius: 5px;
        }
        .produk-item h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .produk-item p {
            margin: 5px 0;
        }
        .status {
            font-weight: bold;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 5px;
        }
        .available {
            color: green;
            border: 1px solid green;
        }
        .sold-out {
            color: red;
            border: 1px solid red;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Daftar Produk</h1>

<div class="produk-container">
    <?php while ($produk = mysqli_fetch_assoc($query)) { ?>

    <div class="produk-item">

        <img src="gambar_produk/<?= $produk['gambar'] ?>" alt="<?= $produk['nama_produk'] ?>">

        <p>
            <span class="status <?= ($produk['stok'] > 0) ? 'available' : 'sold-out' ?>">
                <?= ($produk['stok'] > 0) ? 'Available' : 'Sold Out' ?>
            </span>
        </p>

        <h3><?= $produk['nama_produk'] ?></h3>

        <p>Harga: <strong>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></strong></p>
    </div>
    <?php } ?>
</div>

</body>
</html>
