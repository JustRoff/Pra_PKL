<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}
$id_manufacturer = $_GET['id_manufacturer'];

$sql = "Delete from manufacturer where id_manufacturer='$id_manufacturer' ";
$query = mysqli_query($koneksi,$sql);

if ($query) {
    header("Location: tambah_kategori.php?Hapus=S");
} else {
    header("Location: tambah_kategori.php?Hapus=G");
}
exit;
?>