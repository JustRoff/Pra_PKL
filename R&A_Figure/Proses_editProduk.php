<?php
include "koneksi.php";
// session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location:login.php?Logindulu");
//     exit;
// }

$id_produk        = $_GET['id_produk'];
$nama_produk      = $_GET['nama_produk'];
$kategori         = $_GET['kategori'];
$manufacturer     = $_GET['manufacturer'];
$tanggal_terbit   = $_GET['tanggal_terbit'];
$harga            = $_GET['harga'];
$stok             = $_GET['stok'];
$rating           = $_GET['rating'];
$id_admin         = $_GET['id_admin'];

$sql = "UPDATE produk SET 
            nama_produk='$nama_produk',kategori='$kategori',manufacturer='$manufacturer',tanggal_terbit='$tanggal_terbit',
            harga='$harga',stok='$stok',rating='$rating',id_admin='$id_admin'WHERE id_produk='$id_produk'";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("location:tableProduk.php?Edit=S");
    exit;
} else {
    header("location:tableProduk.php?Edit=G");
    exit;
}
?>
