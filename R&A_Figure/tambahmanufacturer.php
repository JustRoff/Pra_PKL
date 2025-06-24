<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$nama_manufacturer = $_POST['nama_manufacturer'];

$sql = "INSERT INTO manufacturer(nama_manufacturer) values ('$nama_manufacturer') ";

$query = mysqli_query($koneksi,$sql);

if ($query) {
    header("location:tambah_kategori.php?Tambah=S");
    exit;
} else {
    header("location:tambah_kategori.php?Tambah=G");
    exit;
}
?>