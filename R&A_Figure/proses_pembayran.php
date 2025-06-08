<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['checkout'])) {
    header("Location: keranjang.php");
    exit;
}

$data = $_SESSION['checkout'];
$id_user = $_SESSION['id_user'];


$alamat = $data['alamat_id'];
$total_harga = $data['total_akhir'];
$ongkir = $data['ongkir'];
$total_barang = $data['total_barang'];


$provider = $_POST['provider'] ?? '';
$status = 'Belum Dikirim';


$tanggal_pemesanan = date('Y-m-d H:i:s');

$gambar_name = $_FILES['bukti_pembayaran']['name'] ?? '';
$gambar_tmp = $_FILES['bukti_pembayaran']['tmp_name'] ?? '';
$folder_tujuan = "bukti_bayar/";

$file_extension = pathinfo($gambar_name, PATHINFO_EXTENSION);
$new_filename = 'bukti_' . time() . '_' . $id_user . '.' . $file_extension;


if (!empty($gambar_tmp)) {
    move_uploaded_file($gambar_tmp, $folder_tujuan . $new_filename);
} else {
    $new_filename = '';
}

// ✅ 6. Ambil data produk dari checkout_items (bukan dari 'produk')
$checkout_items = $data['checkout_items']; // Array [1,2,3]

// Query untuk mendapatkan data produk dari keranjang
$ids_str = implode(',', $checkout_items);
$query_produk = "SELECT k.id_produk, k.id_keranjang, k.jumlah_item, p.harga, k.subtotal
                 FROM keranjang k 
                 JOIN produk p ON k.id_produk = p.id_produk 
                 WHERE k.id_user = '$id_user' 
                 AND k.id_produk IN ($ids_str)";

$result_produk = mysqli_query($koneksi, $query_produk);

// ✅ 7. Loop yang benar
if ($result_produk && mysqli_num_rows($result_produk) > 0) {
    while ($produk = mysqli_fetch_assoc($result_produk)) {
        $id_produk = $produk['id_produk'];
        $id_keranjang = $produk['id_keranjang'];
        $jumlah = $produk['jumlah_item'];
        $harga_satuan = $produk['harga'];
        $subtotal = $produk['subtotal'];
        
        // ✅ Insert ke tabel transaksi
        $query_transaksi = "INSERT INTO transaksi (
            id_produk, 
            id_user, 
            id_alamat, 
            id_keranjang, 
            tanggal_pemesanan, 
            jumlah_produk,
            total_harga, 
            ongkir, 
            status
        ) VALUES (
            '$id_produk',
            '$id_user',
            '$alamat',
            '$id_keranjang',
            '$tanggal_pemesanan',
            '$jumlah',
            '$subtotal',
            '$ongkir',
            '$status'
        )";
        
        $insert_transaksi = mysqli_query($koneksi, $query_transaksi);
        
        if ($insert_transaksi) {
            // ✅ Ambil ID transaksi yang baru saja diinsert
            $id_transaksi = mysqli_insert_id($koneksi);
            
            // ✅ Insert ke tabel pembayaran
            $query_pembayaran = "INSERT INTO pembayaran (
                id_transaksi, 
                provider, 
                bukti_pembayaran
            ) VALUES (
                '$id_transaksi', 
                '$provider', 
                '$new_filename'
            )";
            
            mysqli_query($koneksi, $query_pembayaran);
            
            // ✅ Hapus dari keranjang
            $query_delete = "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'";
            mysqli_query($koneksi, $query_delete);
            
        } else {
            // ✅ Debug jika insert gagal
            echo "Error insert transaksi: " . mysqli_error($koneksi);
            exit;
        }
    }
    
    // ✅ Bersihkan session dan redirect
    unset($_SESSION['checkout']);
    echo "<script>alert('Pembayaran berhasil, pesanan diproses'); window.location='index.php';</script>";
    
} else {
    echo "<script>alert('Error: Tidak ada produk yang ditemukan'); window.location='keranjang.php';</script>";
}
?>