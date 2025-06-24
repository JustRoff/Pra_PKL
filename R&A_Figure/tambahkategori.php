<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$nama_kategori = $_POST['nama_kategori'];

$sql = "INSERT INTO kategori(nama_kategori) values ('$nama_kategori') ";

$query = mysqli_query($koneksi,$sql);

if ($query) {
    header("location:tambah_kategori.php?Tambah=S");
    exit;
} else {
    header("location:tambah_kategori.php?Tambah=G");
    exit;
}
?>