<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}
$id_produk        = $_POST['id_produk'];
$nama_produk      = $_POST['nama_produk'];
$kategori         = $_POST['kategori'];
$manufacturer     = $_POST['manufacturer'];
$tanggal_terbit   = $_POST['tanggal_terbit'];
$harga            = $_POST['harga'];
$stok             = $_POST['stok'];
$rating           = $_POST['rating'];
$id_admin         = $_SESSION['id_admin'];
$gambar_lama      = $_POST['gambar_lama'];

if ($_FILES['gambar']['name'] != "") {
    $gambar_baru = $_FILES['gambar']['name'];
    $gambar_tmp  = $_FILES['gambar']['tmp_name'];
    $folder_tujuan = "gambar_produk/";

    move_uploaded_file($gambar_tmp, $folder_tujuan . $gambar_baru);

    if (file_exists("gambar_produk/" . $gambar_lama)) {
        unlink("gambar_produk/" . $gambar_lama);
     }
} else {
    $gambar_baru = $gambar_lama;
}

$sql = "UPDATE produk SET nama_produk='$nama_produk',kategori='$kategori',manufacturer='$manufacturer',tanggal_terbit='$tanggal_terbit',
        harga='$harga',stok='$stok',rating='$rating',id_admin='$id_admin',gambar='$gambar_baru' WHERE id_produk='$id_produk'";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("location:dashboard.php?Edit=S");
    exit;
} else {
    header("location:dashboard.php?Edit=G");
    exit;
}
?>
