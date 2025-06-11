<?php 
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login1.php?Logindulu");
    exit;
}

$jumlah_item = $_POST['jumlah_item'];
$id_produk = $_POST['id_produk'];
$id_user = $_SESSION['id_user'];

$sql_produk = "Select * from produk where id_produk='$id_produk' ";
$query_produk = mysqli_query($koneksi,$sql_produk);

if(mysqli_num_rows($query_produk)==1) {
    $produk = mysqli_fetch_assoc($query_produk);
    $harga = $produk['harga'];
    $subtotal = $harga * $jumlah_item;

    $sql_keranjang = "INSERT INTO keranjang (jumlah_item, id_produk, id_user, subtotal) values ('$jumlah_item', '$id_produk', '$id_user', '$subtotal')" ;
    $query_keranjang = mysqli_query($koneksi,$sql_keranjang);

    if ($query_keranjang) {
        header("Location: produk.php?id_produk=$id_produk&sukses=added_to_cart");
    } else {
        header("Location: produk.php?id_produk=$id_produk&error=insert_failed");
    }
} else {
    header("Location: produk.php?id_produk=$id_produk&error=product_not_found");
}
?>