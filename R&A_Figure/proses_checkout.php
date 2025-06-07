<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}



$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'] ?? '';

// Ambil nilai dari POST dan session
$from_page = $_POST['from'] ?? 'keranjang';
$email = $_POST['email'] ?? '';
$alamat_id = $_POST['alamat_id'] ?? '';

// Data checkout item
$checkout_items = $_POST['checkout_items'] ?? [];
$checkout_items = array_map('intval', $checkout_items);
$selected_ids = implode(',', $checkout_items);

// Total dari form
$subtotal = $_POST['subtotal'] ?? 0;
$ongkir = $_POST['ongkir'] ?? 0;
$total_akhir = $_POST['total_akhir'] ?? 0;
$total_barang = $_POST['total_barang'] ?? 0;

// Ambil detail alamat untuk tambahan informasi
$sql_alamat = "SELECT * FROM alamat WHERE id_alamat = '$alamat_id' AND id_user = '$id_user'";
$result_alamat = mysqli_query($koneksi, $sql_alamat);
$alamat_terpilih = '';
$pulau_terpilih = '';

if ($data_alamat = mysqli_fetch_assoc($result_alamat)) {
    $alamat_terpilih = $data_alamat['nama_alamat'] . " - " . $data_alamat['deskripsi'];
    $pulau_terpilih = $data_alamat['Pulau'];
}

// Simpan ke session
$_SESSION['checkout'] = array(
    'nama_pemesan' => $nama,
    'email' => $email,
    'alamat_id' => $alamat_id,
    'alamat_detail' => $alamat_terpilih,
    'pulau' => $pulau_terpilih,
    'checkout_items' => $checkout_items,
    'subtotal' => $subtotal,
    'ongkir' => $ongkir,
    'total_akhir' => $total_akhir,
    'total_barang' => $total_barang
);

// Redirect ke halaman upload bukti pembayaran
header("Location: upload_bukti.php?from=" . urlencode($from_page) . "&nama=" . urlencode($nama));
exit;
?>
