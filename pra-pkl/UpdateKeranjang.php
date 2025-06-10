<?php
header('Content-Type: application/json');
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?Logindulu");
    exit;
}

$id_keranjang = $_POST['id_keranjang'];
$jumlah_item = $_POST['jumlah_item'];
$subtotal = $_POST['subtotal'];

$sql = "UPDATE keranjang SET jumlah_item='$jumlah_item', subtotal='$subtotal' WHERE id_keranjang='$id_keranjang' ";
$query = mysqli_query($koneksi, $sql);

if ($query) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
}

?>