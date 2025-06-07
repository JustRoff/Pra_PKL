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
$pulau           = $_POST['pulau'];
$id_user         = $_SESSION['id_user'];

$return_url      = isset($_POST['return_url']) ? $_POST['return_url'] : '';

$sql = "INSERT INTO alamat(nama_alamat, latitude, longitude, deskripsi, pulau, id_user) 
        VALUES ('$nama_alamat', '$latitude', '$longitude', '$deskripsi', '$pulau', '$id_user')";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    // ✅ TAMBAHAN: Cek apakah ada return_url dan redirect sesuai
    if (!empty($return_url) && $return_url == 'transaksi.php') {
        header("location:transaksi.php?TambahLokasi=S");
    } elseif (!empty($return_url)) {
        header("location:" . $return_url . "?TambahLokasi=S");
    } else {
        // Default redirect jika tidak ada return_url
        header("location:alamat.php?TambahLokasi=S");
    }
    exit;
} else {
        header("location:alamat.php?TambahLokasi=G");
    exit;
}
?>