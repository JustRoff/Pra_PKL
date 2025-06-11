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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .transaction-list {
            padding: 20px;
        }

        .transaction-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .transaction-item:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .transaction-summary {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .transaction-info {
            flex: 1;
        }

        .transaction-date {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 5px;
        }

        .product-preview {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .more-products {
            color: #007bff;
            font-size: 0.9em;
        }

        .transaction-total {
            text-align: right;
        }

        .total-price {
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745;
        }

        .status {
            font-size: 0.8em;
            padding: 4px 8px;
            border-radius: 12px;
            margin-top: 5px;
            display: inline-block;
        }

        .status.belum-dikirim {
            background: #fff3cd;
            color: #856404;
        }

        .status.dikirim {
            background: #d4edda;
            color: #155724;
        }

        .transaction-details {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: white;
            border-top: 1px solid #e9ecef;
        }

        .transaction-details.active {
            max-height: 500px;
        }

        .details-content {
            padding: 20px;
        }

        .product-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 0.8em;
            color: #666;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .product-price {
            color: #666;
            font-size: 0.9em;
        }

        .product-quantity {
            text-align: right;
            font-weight: bold;
        }

        .no-transactions {
            text-align: center;
            padding: 50px 20px;
            color: #666;
        }

        .no-transactions img {
            width: 100px;
            opacity: 0.5;
            margin-bottom: 20px;
        }

        .arrow-icon {
            transition: transform 0.3s ease;
            color: #666;
        }

        .transaction-item.active .arrow-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
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