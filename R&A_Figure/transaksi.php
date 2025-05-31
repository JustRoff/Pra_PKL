<?php 
session_start(); 
include "koneksi.php";  

if (!isset($_SESSION['id_user'])) {     
    header("Location: login.php?Logindulu");     
    exit; 
}  

$id_user = $_SESSION['id_user'];  

// ✅ Cek apakah ada produk yang dipilih dari form checkout
if (isset($_POST['checkout_items']) && !empty($_POST['checkout_items'])) {
    $selected_items = $_POST['checkout_items'];
    // Sanitasi untuk keamanan - pastikan semua nilai adalah angka
    $selected_items = array_map('intval', $selected_items);
    $selected_ids = implode(',', $selected_items);
} else {
    // Jika tidak ada item yang dipilih, redirect kembali ke keranjang
    header("Location: keranjang.php?error=no_items_selected");
    exit;
}

// Query alamat tetap sama
$sql = "SELECT * FROM alamat WHERE id_user = '$id_user'"; 
$query = mysqli_query($koneksi, $sql); 
$jumlah_alamat = mysqli_num_rows($query);

// Variabel untuk menyimpan alamat yang dipilih
$alamat_terpilih = '';
if (isset($_POST['alamat_id'])) {
    $alamat_id = $_POST['alamat_id'];
    $sql_alamat = "SELECT * FROM alamat WHERE id_alamat = '$alamat_id' AND id_user = '$id_user'";
    $result_alamat = mysqli_query($koneksi, $sql_alamat);
    if ($data_alamat = mysqli_fetch_assoc($result_alamat)) {
        $alamat_terpilih = $data_alamat['nama_alamat'] . " - " . $data_alamat['deskripsi'];
    }
}

// ✅ Query produk hanya untuk item yang dipilih
$sql_produk = "SELECT keranjang.id_keranjang,
                      keranjang.subtotal,
                      keranjang.jumlah_item,
                      produk.nama_produk as nama_produk,
                      produk.harga as harga,
                      produk.gambar as gambar
                      FROM keranjang
                JOIN produk ON keranjang.id_produk = produk.id_produk
                WHERE keranjang.id_user = '$id_user' 
                AND keranjang.id_keranjang IN ($selected_ids)";

$query_produk = mysqli_query($koneksi, $sql_produk);

// ✅ Hitung total keseluruhan
$total_keseluruhan = 0;
$produk_checkout = [];
while ($row = mysqli_fetch_assoc($query_produk)) {
    $produk_checkout[] = $row;
    $total_keseluruhan += $row['subtotal'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Alamat Pengiriman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* ✅ Style untuk produk checkout */
        .produk-checkout {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .produk-checkout .gambar-produk {
            flex-shrink: 0;
        }

        .produk-checkout img {
            border-radius: 5px;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .produk-checkout .detail-produk {
            flex: 1;
        }

        .produk-checkout h4 {
            color: #333;
            margin: 0 0 15px 0;
            font-size: 18px;
        }

        .produk-checkout .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .produk-checkout .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .produk-checkout .info-label {
            font-weight: bold;
            color: #555;
            min-width: 120px;
        }

        .produk-checkout .info-value {
            color: #333;
            text-align: right;
        }

        .produk-checkout .subtotal-value {
            color: #28a745;
            font-weight: bold;
            font-size: 18px;
        }

        /* ✅ Style untuk total keseluruhan */
        .total-section {
            background-color: #e8f5e8;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .total-section h3 {
            color: #28a745;
            margin: 0 0 10px 0;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        /* Tombol Pilih Alamat */
        .btn-pilih-alamat {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-pilih-alamat:hover {
            background-color: #0056b3;
        }

        /* Alamat yang dipilih */
        .alamat-terpilih {
            margin: 15px 0;
            padding: 15px;
            background-color: #e9f7ef;
            border: 1px solid #27ae60;
            border-radius: 5px;
            color: #2c3e50;
        }

        /* Modal styles tetap sama seperti sebelumnya */
        .modal-overlay {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            position: relative;
            animation: slideIn 0.3s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            max-height: 80vh;
            overflow: hidden;
        }

        @keyframes slideIn {
            from { 
                transform: translateY(-50px);
                opacity: 0;
            }
            to { 
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 20px 30px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            position: relative;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close:hover {
            color: #000;
        }

        .modal-body {
            padding: 20px 30px;
            max-height: 50vh;
            overflow-y: auto;
        }

        .alamat-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .alamat-item:hover {
            border-color: #007bff;
            box-shadow: 0 2px 8px rgba(0,123,255,0.2);
        }

        .alamat-item.selected {
            border-color: #28a745;
            background-color: #f8fff9;
        }

        .alamat-nama {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .alamat-detail {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }

        .alamat-telepon {
            color: #007bff;
            font-size: 14px;
            margin-top: 5px;
        }

        .label-default {
            background-color: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .modal-footer {
            padding: 15px 30px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            text-align: right;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        .no-alamat {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }

        .btn-tambah-alamat {
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 5px;
            display: inline-block;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-tambah-alamat:hover {
            background-color: #218838;
            text-decoration: none;
            color: white;
        }

        .btn-tambah-modal {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-left: 10px;
            transition: background-color 0.3s;
        }

        .btn-tambah-modal:hover {
            background-color: #218838;
            text-decoration: none;
            color: white;
        }

        /* ✅ Tombol kembali */
        .btn-kembali {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .btn-kembali:hover {
            background-color: #545b62;
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- ✅ Tombol kembali ke keranjang -->
        <a href="keranjang.php" class="btn-kembali">← Kembali ke Keranjang</a>
        
        <h1>Checkout - Pilih Alamat Pengiriman</h1>
        
        <!-- Form untuk menampilkan alamat yang dipilih -->
        <form method="POST" action="">
            <input type="hidden" id="selected_alamat_id" name="alamat_id" value="">
            
            <!-- ✅ Simpan data produk yang dipilih -->
            <?php foreach ($selected_items as $item_id): ?>
                <input type="hidden" name="checkout_items[]" value="<?= $item_id ?>">
            <?php endforeach; ?>
            
            <!-- Tombol untuk membuka modal -->
            <button type="button" class="btn-pilih-alamat" onclick="openModal('alamatModal')">
                <?php echo $jumlah_alamat > 0 ? 'Pilih Alamat' : 'Tambah Alamat'; ?>
            </button>

            <!-- Menampilkan alamat yang dipilih -->
            <?php if (!empty($alamat_terpilih)): ?>
                <div class="alamat-terpilih">
                    <strong>Alamat Pengiriman:</strong><br>
                    <?php echo htmlspecialchars($alamat_terpilih); ?>
                </div>
            <?php endif; ?>
        </form>

        <!-- ✅ Menampilkan produk yang dipilih -->
        <h2>Produk yang akan dibeli:</h2>
        <?php if (!empty($produk_checkout)): ?>
            <?php foreach($produk_checkout as $produk): ?>
                <div class="produk-checkout">
                    <div class="gambar-produk">
                        <img src="gambar_produk/<?= $produk['gambar'] ?>" alt="<?= htmlspecialchars($produk['nama_produk']) ?>">
                    </div>
                    <div class="detail-produk">
                        <h4><?= htmlspecialchars($produk['nama_produk']) ?></h4>
                        
                        <div class="info-item">
                            <span class="info-label">Harga Satuan:</span>
                            <span class="info-value">IDR <?= number_format($produk['harga'], 0, ',', '.') ?></span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">Jumlah Beli:</span>
                            <span class="info-value"><?= $produk['jumlah_item'] ?> pcs</span>
                        </div>
                        
                        <div class="info-item">
                            <span class="info-label">Subtotal:</span>
                            <span class="info-value subtotal-value">IDR <?= number_format($produk['subtotal'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- ✅ Total keseluruhan -->
            <div class="total-section">
                <h3>Total Pembayaran</h3>
                <div class="total-amount">IDR <?= number_format($total_keseluruhan, 0, ',', '.') ?></div>
            </div>
        <?php else: ?>
            <p>Tidak ada produk yang dipilih.</p>
            <a href="keranjang.php">Kembali ke Keranjang</a>
        <?php endif; ?>
    </div>

    <!-- Modal Pilih Alamat -->
    <div id="alamatModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Pilih Alamat Pengiriman</h3>
                <span class="close" onclick="closeModal('alamatModal')">&times;</span>
            </div>
            
            <div class="modal-body">
                <?php if ($jumlah_alamat > 0): ?>
                    <?php 
                    // Reset pointer query
                    mysqli_data_seek($query, 0);
                    while ($alamat = mysqli_fetch_assoc($query)): 
                    ?>
                        <div class="alamat-item" onclick="selectAlamat(<?php echo $alamat['id_alamat']; ?>, this)">
                            <div class="alamat-nama">
                                <?php echo htmlspecialchars($alamat['nama_alamat']); ?>
                            </div>
                            
                            <div class="alamat-detail">
                                <?php echo htmlspecialchars($alamat['deskripsi']); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    
                <?php else: ?>
                    <div class="no-alamat">
                        <h4>Belum Ada Alamat</h4>
                        <p>Anda belum memiliki alamat pengiriman. Silakan tambah alamat terlebih dahulu.</p>
                        <a href="alamat.php" class="btn-tambah-alamat">Tambah Alamat Baru</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="modal-footer">
                <a href="alamat.php" class="btn-tambah-modal">+ Tambah Alamat</a>
                <button type="button" class="btn btn-secondary" onclick="closeModal('alamatModal')">
                    Batal
                </button>
                <button type="button" class="btn btn-primary" onclick="confirmSelection()" id="btnConfirm" disabled>
                    Pilih Alamat Ini
                </button>
            </div>
        </div>
    </div>

<script src="script/transaksi.js?<?=time() ?>"></script>
</body>
</html>