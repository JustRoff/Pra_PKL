<?php 
session_start(); 
include "koneksi.php";  

if (!isset($_SESSION['id_user'])) {     
    header("Location: login.php?Logindulu");     
    exit; 
}  

$id_user = $_SESSION['id_user'];

// ✅ Cek apakah ada produk yang dipilih dari form checkout atau dari session
if (isset($_POST['checkout_items']) && !empty($_POST['checkout_items'])) {
    $selected_items = $_POST['checkout_items'];
    // Sanitasi untuk keamanan - pastikan semua nilai adalah angka
    $selected_items = array_map('intval', $selected_items);
    
    // Simpan ke session untuk digunakan nanti
    $_SESSION['checkout_items'] = $selected_items;
    
    $selected_ids = implode(',', $selected_items);
} elseif (isset($_SESSION['checkout_items']) && !empty($_SESSION['checkout_items'])) {
    // Ambil dari session jika tidak ada POST data
    $selected_items = $_SESSION['checkout_items'];
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

// Variabel untuk menyimpan alamat yang dipilih dan ongkir
$alamat_terpilih = '';
$ongkir = 0;
$pulau_terpilih = '';

if (isset($_POST['alamat_id'])) {
    $alamat_id = $_POST['alamat_id'];
    $sql_alamat = "SELECT * FROM alamat WHERE id_alamat = '$alamat_id' AND id_user = '$id_user'";
    $result_alamat = mysqli_query($koneksi, $sql_alamat);
    if ($data_alamat = mysqli_fetch_assoc($result_alamat)) {
        $alamat_terpilih = $data_alamat['nama_alamat'] . " - " . $data_alamat['deskripsi'];
        $pulau_terpilih = strtolower($data_alamat['Pulau']);
        
        // Simpan alamat yang dipilih ke session
        $_SESSION['selected_alamat_id'] = $alamat_id;
        
        // ✅ Hitung ongkir berdasarkan pulau
        $ongkir_rates = [
            'jawa' => 10000,
            'sumatra' => 15000,
            'sulawesi' => 20000,
            'kalimantan' => 25000,
            'bali' => 30000,
            'nusa tenggara' => 35000,
            'maluku' => 40000,
            'papua' => 45000
        ];
        
        $ongkir = isset($ongkir_rates[$pulau_terpilih]) ? $ongkir_rates[$pulau_terpilih] : 0;
    }
} elseif (isset($_SESSION['selected_alamat_id'])) {
    // Ambil alamat yang sudah dipilih sebelumnya dari session
    $alamat_id = $_SESSION['selected_alamat_id'];
    $sql_alamat = "SELECT * FROM alamat WHERE id_alamat = '$alamat_id' AND id_user = '$id_user'";
    $result_alamat = mysqli_query($koneksi, $sql_alamat);
    if ($data_alamat = mysqli_fetch_assoc($result_alamat)) {
        $alamat_terpilih = $data_alamat['nama_alamat'] . " - " . $data_alamat['deskripsi'];
        $pulau_terpilih = strtolower($data_alamat['Pulau']);
        
        $ongkir_rates = [
            'jawa' => 10000,
            'sumatra' => 15000,
            'sulawesi' => 20000,
            'kalimantan' => 25000,
            'bali' => 30000,
            'nusa tenggara' => 35000,
            'maluku' => 40000,
            'papua' => 45000
        ];
        
        $ongkir = isset($ongkir_rates[$pulau_terpilih]) ? $ongkir_rates[$pulau_terpilih] : 0;
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
                AND produk.id_produk IN ($selected_ids)";

$query_produk = mysqli_query($koneksi, $sql_produk);

// ✅ Hitung total keseluruhan dan jumlah barang
$subtotal_keseluruhan = 0;
$total_barang = 0;
$produk_checkout = [];
while ($row = mysqli_fetch_assoc($query_produk)) {
    $produk_checkout[] = $row;
    $subtotal_keseluruhan += $row['subtotal'];
    $total_barang += $row['jumlah_item'];
}

// ✅ Total akhir = subtotal + ongkir
$total_akhir = $subtotal_keseluruhan + $ongkir;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Alamat Pengiriman</title>
    <link rel="stylesheet" href="css/transaksi.css">
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
                    <br><strong>Pulau:</strong> <?php echo ucwords($pulau_terpilih); ?>
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

            <!-- ✅ Ringkasan Pembayaran -->
            <div class="payment-summary">
                <h3>🧾 Ringkasan Pembayaran</h3>
                
                <div class="summary-item">
                    <span class="summary-label">Subtotal Produk:</span>
                    <span class="summary-value">IDR <?= number_format($subtotal_keseluruhan, 0, ',', '.') ?></span>
                </div>
                
                <div class="summary-item">
                    <span class="summary-label">Total Barang:</span>
                    <span class="summary-value"><?= $total_barang ?> item</span>
                </div>
                
                <div class="summary-item">
                    <span class="summary-label">Ongkos Kirim<?= $pulau_terpilih ? ' ('.ucwords($pulau_terpilih).')' : '' ?>:</span>
                    <span class="summary-value">
                        <?php if ($ongkir > 0): ?>
                            IDR <?= number_format($ongkir, 0, ',', '.') ?>
                        <?php else: ?>
                            <em>Pilih alamat untuk melihat ongkir</em>
                        <?php endif; ?>
                    </span>
                </div>
                
                <div class="summary-item total-final">
                    <span class="summary-label">TOTAL PEMBAYARAN:</span>
                    <span class="summary-value">IDR <?= number_format($total_akhir, 0, ',', '.') ?></span>
                </div>
            </div>

            <!-- ✅ Tombol lanjut ke pembayaran -->
            <?php if (!empty($alamat_terpilih)): ?>
                <form method="POST" action="proses_checkout.php">
                    <!-- Kirim semua data yang diperlukan -->
                    <input type="hidden" name="alamat_id" value="<?= $_POST['alamat_id'] ?? '' ?>">
                    <input type="hidden" name="subtotal" value="<?= $subtotal_keseluruhan ?>">
                    <input type="hidden" name="ongkir" value="<?= $ongkir ?>">
                    <input type="hidden" name="total_akhir" value="<?= $total_akhir ?>">
                    <input type="hidden" name="total_barang" value="<?= $total_barang ?>">
                    
                    <?php foreach ($selected_items as $item_id): ?>
                        <input type="hidden" name="checkout_items[]" value="<?= $item_id ?>">
                    <?php endforeach; ?>
                    
                    <button type="submit" class="btn-lanjut-bayar">
                        💳 Lanjut ke Pembayaran - IDR <?= number_format($total_akhir, 0, ',', '.') ?>
                    </button>
                </form>
            <?php else: ?>
                <button type="button" class="btn-lanjut-bayar" disabled>
                    ⚠️ Pilih Alamat Terlebih Dahulu
                </button>
            <?php endif; ?>

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
                                <span style="float: right; background-color: #17a2b8; color: white; padding: 2px 8px; border-radius: 3px; font-size: 12px;">
                                    <?php echo ucwords($alamat['Pulau']); ?>
                                </span>
                            </div>
                            
                            <div class="alamat-detail">
                                <?php echo htmlspecialchars($alamat['deskripsi']); ?>
                            </div>
                            
                            <!-- ✅ Tampilkan ongkir di modal -->
                            <div style="margin-top: 8px; color: #28a745; font-weight: bold; font-size: 14px;">
                                Ongkir: IDR <?php 
                                    $pulau_modal = strtolower($alamat['Pulau']);
                                    $ongkir_modal = isset($ongkir_rates[$pulau_modal]) ? $ongkir_rates[$pulau_modal] : 0;
                                    echo number_format($ongkir_modal, 0, ',', '.');
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    
                <?php else: ?>
                    <div class="no-alamat">
                        <h4>Belum Ada Alamat</h4>
                        <p>Anda belum memiliki alamat pengiriman. Silakan tambah alamat terlebih dahulu.</p>
                        <a href="alamat.php?return=transaksi.php" class="btn-tambah-alamat">Tambah Alamat Baru</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="modal-footer">
                <a href="alamat.php?return=transaksi.php" class="btn-tambah-modal">+ Tambah Alamat</a>
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
