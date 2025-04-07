<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_admin']) && !isset($_SESSION['username'])) {
    header("Location:login.php?Logindulu");
    exit;
}

$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : "";
$selected_categories = isset($_GET['categories']) ? $_GET['categories'] : [];
$selected_manufacturers = isset($_GET['manufacturers']) ? $_GET['manufacturers'] : [];

// Query untuk mengambil produk
$sql_produk = "SELECT * FROM produk WHERE 1=1";

$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : null;

if (!empty($keywords)) {
    $sql_produk .= " AND nama_produk LIKE '%$keywords%'";
}

if (!empty($selected_categories)) {
    $category_filter = implode("','", $selected_categories);
    $sql_produk .= " AND kategori IN ('$category_filter')";
}

if (!empty($selected_manufacturers)) {
    $manufacturer_filter = implode("','", $selected_manufacturers);
    $sql_produk .= " AND manufacturer IN ('$manufacturer_filter')";
}

if (!empty($min_price)) {
    $sql_produk .= " AND harga >= $min_price";
}

if (!empty($max_price)) {
    $sql_produk .= " AND harga <= $max_price";
}


$sql_produk .= " ORDER BY tanggal_terbit DESC";
$query = mysqli_query($koneksi, $sql_produk);
$jumlah_hasil = mysqli_num_rows($query);

// Query untuk mengambil daftar kategori
$sql_kategori = "SELECT DISTINCT kategori FROM produk";
$category_query = mysqli_query($koneksi, $sql_kategori);
$categories = [];
while ($row = mysqli_fetch_assoc($category_query)) {
    $categories[] = $row['kategori'];
}

// Query untuk mengambil daftar manufacturer
$sql_manufacturer = "SELECT DISTINCT manufacturer from produk";
$manufacturer_query = mysqli_query($koneksi, $sql_manufacturer);
$manufacturers= [];
while ($row = mysqli_fetch_assoc($manufacturer_query)) {
    $manufacturers[] = $row['manufacturer'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <script src="script/script.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1 style="text-align:center;">Daftar Produk</h1>
<form method="get">
    <div class="search-bar">
        <div class="search-controls">
            <!-- Search Keyword -->
            <input type="search" name="keywords" class="search-input" placeholder="Cari Karakter/Series Kesukaan mu" value="<?= htmlspecialchars($keywords) ?>">
            <input type="submit" value="Search" id="searchBtn" class="search-disabled">

            <!-- Tombol Reset -->
            <a href="produk.php" class="rounded-button btn-gray" style="text-decoration: none;">Reset Filter</a>
        </div>

        <!-- Tombol Modal -->
        <button type="button" class="rounded-button btn-orange" onclick="document.getElementById('KategoriModal').style.display='block'">Search by Category</button>
        <button type="button" class="rounded-button btn-orange" onclick="document.getElementById('ManufacturerModal').style.display='block'">Search by Manufacturer</button>
    </div>

        <!-- Filter Harga -->
        <div class="price-filter">
            <label>Harga Min:</label>
            <input type="text" name="min_price" class="search-input"  id="minPrice" placeholder="Min" value="<?= isset($_GET['min_price']) ? number_format($_GET['min_price'], 0, ',', '.') : '' ?>">
            <label>Harga Max:</label>
            <input type="text" name="max_price" class="search-input"  id="maxPrice" placeholder="Max" value="<?= isset($_GET['min_price']) ? number_format($_GET['min_price'], 0, ',', '.') : '' ?>">
        </div>

    <!-- Modal Kategori -->
    <div id="KategoriModal" class="filter-modal">
        <h3>Pilih Kategori</h3>
        <?php foreach ($categories as $category) : ?>
            <label>
                <input type="checkbox" name="categories[]" value="<?= $category ?>" <?= in_array($category, $selected_categories) ? 'checked' : '' ?>>
                <?= $category ?>
            </label><br>
        <?php endforeach; ?>
        <br>
        <button type="submit" class="rounded-button btn-orange">Filter</button>
        <button type="button" class="rounded-button btn-gray" onclick="document.getElementById('KategoriModal').style.display='none'">Close</button>
    </div>

    <!-- Modal Manufacturer -->
    <div id="ManufacturerModal" class="filter-modal">
        <h3>Pilih Manufacturer</h3>
        <?php foreach ($manufacturers as $manufacturer) : ?>
            <label>
                <input type="checkbox" name="manufacturers[]" value="<?= $manufacturer ?>" <?= in_array($manufacturer, $selected_manufacturers) ? 'checked' : '' ?>>
                <?= $manufacturer ?>
            </label><br>
        <?php endforeach; ?>
        <br>
        <button type="submit" class="rounded-button btn-orange">Filter</button>
        <button type="button" class="rounded-button btn-gray" onclick="document.getElementById('ManufacturerModal').style.display='none'">Close</button>
    </div>
</form> <br>

<div class="produk-container">
    <?php if ($jumlah_hasil > 0) { ?>
        <?php while ($produk = mysqli_fetch_assoc($query)) { ?>
            <div class="produk-item">
                <img src="gambar_produk/<?= $produk['gambar'] ?>" alt="<?= $produk['nama_produk'] ?>">
                <p><span class="status <?= ($produk['stok'] > 0) ? 'available' : 'sold-out' ?>">
                    <?= ($produk['stok'] > 0) ? 'Available' : 'Sold Out' ?></span>
                </p>
                <h3><?= $produk['nama_produk'] ?></h3>
                <p>Harga: <strong>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></strong></p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <img src="img_properties\Tobangado.jpg" alt="Tobangado">
        <p style="text-align: center; font-size: 18px; color: red;">Maaf, sepertinya barang yang kamu cari tidak ada.</p>
    <?php } ?>

    <a href="dashboard.php"><button>dashboard</button></a>
</div>
</body>
</html>
