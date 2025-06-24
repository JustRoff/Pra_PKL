<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$id_kategori = $_POST['id']; 
$nama_kategori = $_POST['nama']; 

$sql = "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori'";
$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: tambah_kategori.php?Edit=S");
} else {
    header("Location: tambah_kategori.php?Edit=G");
}
exit;
?>
