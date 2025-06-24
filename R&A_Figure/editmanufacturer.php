<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$id_manufacturer = $_POST['id']; 
$nama_manufacturer = $_POST['nama']; 

$sql = "UPDATE manufacturer SET nama_manufacturer='$nama_manufacturer' WHERE id_manufacturer='$id_manufacturer'";
$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: tambah_kategori.php?Edit=S");
} else {
    header("Location: tambah_kategori.php?Edit=G");
}
exit;
