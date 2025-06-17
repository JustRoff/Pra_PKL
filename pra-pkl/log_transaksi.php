<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login1.php?AndaBelumLogin");
    exit;
}

$id_user = $_SESSION['id_user'];

// Query untuk mengambil transaksi user dengan detail produk
$sql = "SELECT 
    t.id_transaksi,
    t.tanggal_pemesanan,
    t.total_harga,
    t.status,
    t.jumlah_produk,
    t.ongkir,
    p.nama_produk,
    p.harga,
    p.gambar
FROM transaksi t
LEFT JOIN produk p ON t.id_produk = p.id_produk
WHERE t.id_user = ?
ORDER BY t.tanggal_pemesanan DESC";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Kelompokkan transaksi berdasarkan tanggal pemesanan yang sama (checkout bersamaan)
$transactions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $key = $row['tanggal_pemesanan']; // Kelompokkan berdasarkan waktu pemesanan yang sama
    if (!isset($transactions[$key])) {
        $transactions[$key] = [
            'tanggal' => $row['tanggal_pemesanan'],
            'status' => $row['status'],
            'ongkir' => $row['ongkir'],
            'produk' => [],
            'total_keseluruhan' => 0
        ];
    }
    $transactions[$key]['produk'][] = $row;
    $transactions[$key]['total_keseluruhan'] += $row['total_harga']; // Jumlahkan total harga semua produk
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian</title>
    <link rel="stylesheet" href="css/log_transaksi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <header>
        <a href="homepage.php"><img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" ></a>
        <nav>
            <div class="profile-icon">    
                <a href="DaftarProduk.php">Products</a>
                <a href="keranjang.php">Cart</a>
                <a href="cek_profil.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="header">
                <h1>Riwayat Pembelian</h1>
                <p>Lihat semua produk yang pernah Anda beli</p>
            </div>

            <div class="transaction-list">
                <?php if (empty($transactions)): ?>
                    <div class="no-transactions">
                        <div style="font-size: 3em; margin-bottom: 20px;">🛍️</div>
                        <h3>Belum Ada Transaksi</h3>
                        <p>Anda belum melakukan pembelian apapun</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($transactions as $key => $transaction): ?>
                        <div class="transaction-item" onclick="toggleDetails('<?php echo $key; ?>')">
                            <div class="transaction-summary">
                                <div class="transaction-info">
                                    <div class="transaction-date">
                                        <?php echo date('d F Y', strtotime($transaction['tanggal'])); ?>
                                    </div>
                                    <div class="product-preview">
                                        <?php 
                                        $firstProduct = $transaction['produk'][0]['nama_produk'];
                                        echo $firstProduct;
                                        ?>
                                    </div>
                                    <?php if (count($transaction['produk']) > 1): ?>
                                        <div class="more-products">
                                            +<?php echo count($transaction['produk']) - 1; ?> produk lainnya
                                        </div>
                                    <?php endif; ?>
                                    <span class="status <?php echo $transaction['status'] == 'Dikirim' ? 'dikirim' : 'belum-dikirim'; ?>">
                                        <?php echo $transaction['status']; ?>
                                    </span>
                                </div>
                                <div class="transaction-total">
                                    <div class="total-price">
                                        Rp <?php echo number_format($transaction['total_keseluruhan'] + $transaction['ongkir'], 0, ',', '.'); ?>
                                    </div>
                                    <div class="arrow-icon">▼</div>
                                </div>
                            </div>
                            
                            <div class="transaction-details" id="details-<?php echo $key; ?>">
                                <div class="details-content">
                                    <h4 style="margin-bottom: 15px; color: #333;">Detail Produk:</h4>
                                    <?php foreach ($transaction['produk'] as $produk): ?>
                                        <div class="product-item">
                                            <div class="product-image">
                                                <?php if (!empty($produk['gambar'])): ?>
                                                    <img src="gambar_produk/<?php echo $produk['gambar']; ?>" alt="<?php echo $produk['nama_produk']; ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                                <?php else: ?>
                                                    📦
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-details">
                                                <div class="product-name"><?php echo $produk['nama_produk']; ?></div>
                                                <div class="product-price">
                                                    Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                                                </div>
                                            </div>
                                            <div class="product-quantity">
                                                Qty: <?php echo $produk['jumlah_produk']; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <!-- Ringkasan Total -->
                                    <div style="border-top: 2px solid #e9ecef; margin-top: 15px; padding-top: 15px;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                            <span>Subtotal Produk:</span>
                                            <span>Rp <?php echo number_format($transaction['total_keseluruhan'], 0, ',', '.'); ?></span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                            <span>Ongkos Kirim:</span>
                                            <span>Rp <?php echo number_format($transaction['ongkir'], 0, ',', '.'); ?></span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1em; color: #28a745;">
                                            <span>Total Keseluruhan:</span>
                                            <span>Rp <?php echo number_format($transaction['total_keseluruhan'] + $transaction['ongkir'], 0, ',', '.'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-left">
            <p>Official Social Media Account</p>
            <div class="social-icons">
                <a href="https://x.com/" class="x-icon"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://www.youtube.com/" class="yt-icon"><i class="fa-brands fa-youtube"></i></a>
                <a href="https://www.instagram.com/" class="ig-icon"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-right">
            <a href="about.php">About Us</a>
            <a href="homepage.php">R&A Figure Store</a>
        </div>
    </footer>

    <script>
        function toggleDetails(transactionId) {
            const details = document.getElementById('details-' + transactionId);
            const item = details.closest('.transaction-item');
            
            // Close all other details
            document.querySelectorAll('.transaction-details').forEach(detail => {
                if (detail !== details) {
                    detail.classList.remove('active');
                    detail.closest('.transaction-item').classList.remove('active');
                }
            });
            
            // Toggle current details
            details.classList.toggle('active');
            item.classList.toggle('active');
        }

        // Close details when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.transaction-item')) {
                document.querySelectorAll('.transaction-details').forEach(detail => {
                    detail.classList.remove('active');
                    detail.closest('.transaction-item').classList.remove('active');
                });
            }
        });
    </script>
</body>
</html>