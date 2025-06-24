<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}
$id_kategori = $_GET['id_kategori'];

$sql = "Delete from kategori where id_kategori='$id_kategori' ";
$query = mysqli_query($koneksi,$sql);

if ($query) {
    header("Location: tambah_kategori.php?Hapus=S");
} else {
    header("Location: tambah_kategori.php?Hapus=G");
}
exit;
?>