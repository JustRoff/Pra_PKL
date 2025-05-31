<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanUser");
    exit;
}

$nama_alamat     = $_POST['nama_alamat'];
$latitude        = $_POST['latitude'];
$longitude       = $_POST['longitude'];
$deskripsi       = $_POST['deskripsi'];
$id_user         = $_SESSION['id_user'];

$sql = "INSERT INTO alamat(nama_alamat, latitude, longitude, deskripsi, id_user) 
        VALUES ('$nama_alamat', '$latitude', '$longitude', '$deskripsi', '$id_user')";

$query = mysqli_query($koneksi, $sql);
if ($query) {
    header("location:transaksi.php?TambahLokasi=S");
    exit;
} else {
    header("location:transaksi.php?TambahLokasi=G");
    exit;
}
?>