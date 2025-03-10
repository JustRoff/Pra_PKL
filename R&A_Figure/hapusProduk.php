<?php
include "koneksi.php";
// session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location:login.php?Logindulu");
//     exit;
// }

$id_produk = $_GET['id_produk'];

$sql = "Delete from produk where id_produk='$id_produk' ";
$query = mysqli_query($koneksi,$sql);

if ($query) {
    header("location:tableProduk.php?hapus=S");
    exit;
} else {
    header("location:tableProduk.php?hapus=G");
    exit;
}
?>