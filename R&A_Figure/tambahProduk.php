<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}
$nama_produk     = $_POST['nama_produk'];
$kategori        = $_POST['kategori'];
$manufacturer    = $_POST['manufacturer'];
$tanggal_terbit  = $_POST['tanggal_terbit'];
$harga           = $_POST['harga'];
$id_admin        = $_SESSION['id_admin'];
$stok            = $_POST['stok'];
$rating          = $_POST['rating'];
$deskripsi       = $_POST['deskripsi'];

$gambar_name = $_FILES['gambar']['name'];
$gambar_tmp = $_FILES['gambar']['tmp_name'];
$folder_tujuan = "gambar_produk/";

move_uploaded_file($gambar_tmp,$folder_tujuan.$gambar_name);


$sql = "INSERT INTO produk(nama_produk, id_kategori, tanggal_terbit, harga, id_admin, id_manufacturer, stok, rating,deskrips,gambar) 
        VALUES ('$nama_produk', '$kategori', '$tanggal_terbit', '$harga', '$id_admin', '$manufacturer', '$stok', '$rating','$deskripsi','$gambar_name')";

$query = mysqli_query($koneksi,$sql);
if ($query) {
    header("location:dashboard.php?Tambah=S");
    exit;
} else {
    header("location:dashboard.php?Tambah=G");
    exit;
}
?>
