<?php
include "koneksi.php";
// session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location:login.php?Logindulu");
//     exit;
// }

$nama_produk     = $_GET['nama_produk'];
$kategori        = $_GET['kategori'];
$manufacturer    = $_GET['manufacturer'];
$tanggal_terbit  = $_GET['tanggal_terbit'];
$harga           = $_GET['harga'];
$id_admin        = $_GET['id_admin'];
$stok            = $_GET['stok'];
$rating          = $_GET['rating'];

$sql = "INSERT INTO produk(nama_produk, kategori, tanggal_terbit, harga, id_admin, manufacturer, stok, rating) 
        VALUES ('$nama_produk', '$kategori', '$tanggal_terbit', '$harga', '$id_admin', '$manufacturer', '$stok', '$rating')";

$query = mysqli_query($koneksi,$sql);
if ($query) {
    header("location:tableProduk.php?Tambah=S");
    exit;
} else {
    header("location:tableProduk.php?Tambah=G");
    exit;
}
?>