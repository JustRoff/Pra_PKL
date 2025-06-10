<?php
include "koneksi.php";
session_start();

// Cek apakah admin sudah login (sesuaikan dengan sistem login admin Anda)
if (!isset($_SESSION['id_admin'])) {
    header("Location: admin_login.php?AndaBelumLogin");
    exit;
}

// Proses update status jika ada request
if (isset($_POST['update_status'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $status_baru = $_POST['status_baru'];
    
    $update_sql = "UPDATE transaksi SET status = ? WHERE id_transaksi = ?";
    $update_stmt = mysqli_prepare($koneksi, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "si", $status_baru, $id_transaksi);
    
    if (mysqli_stmt_execute($update_stmt)) {
        $success_message = "Status transaksi berhasil diupdate!";
    } else {
        $error_message = "Gagal mengupdate status transaksi!";
    }
}

// Filter berdasarkan status
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil semua transaksi dengan detail user dan produk
$sql = "SELECT 
    t.id_transaksi,
    t.id_user,
    t.id_produk,
    t.id_alamat,
    t.id_keranjang,
    t.tanggal_pemesanan,
    t.jumlah_produk,
    t.total_harga,
    t.ongkir,
    t.status,
    p.nama_produk,
    p.harga,
    p.gambar,
    u.username,
    u.email
FROM transaksi t
LEFT JOIN produk p ON t.id_produk = p.id_produk
LEFT JOIN users u ON t.id_user = u.id_user
WHERE 1=1";

$params = [];
$types = "";

if ($status_filter != 'all') {
    $sql .= " AND t.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if (!empty($search)) {
    $sql .= " AND (u.username LIKE ? OR p.nama_produk LIKE ? OR t.id_transaksi LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

$sql .= " ORDER BY t.tanggal_pemesanan DESC";

$stmt = mysqli_prepare($koneksi, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Kelompokkan transaksi berdasarkan tanggal pemesanan yang sama (checkout bersamaan)
$transactions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $key = $row['id_user'] . '_' . $row['tanggal_pemesanan']; // Kelompokkan berdasarkan user dan waktu pemesanan
    if (!isset($transactions[$key])) {
        $transactions[$key] = [
            'id_user' => $row['id_user'],
            'username' => $row['username'],
            'email' => $row['email'],
            'tanggal' => $row['tanggal_pemesanan'],
            'status' => $row['status'],
            'ongkir' => $row['ongkir'],
            'id_alamat' => $row['id_alamat'],
            'produk' => [],
            'total_keseluruhan' => 0
        ];
    }
    $transactions[$key]['produk'][] = $row;
    $transactions[$key]['total_keseluruhan'] += $row['total_harga'];
}

// Hitung statistik
$stats_sql = "SELECT 
    COUNT(*) as total_transaksi,
    SUM(CASE WHEN status = 'Belum Dikirim' THEN 1 ELSE 0 END) as belum_dikirim,
    SUM(CASE WHEN status = 'Dikirim' THEN 1 ELSE 0 END) as dikirim,
    SUM(total_harga + ongkir) as total_pendapatan
FROM transaksi";
$stats_result = mysqli_query($koneksi, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Transaksi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid;
        }

        .stat-card.total { border-left-color: #667eea; }
        .stat-card.pending { border-left-color: #ffc107; }
        .stat-card.shipped { border-left-color: #28a745; }
        .stat-card.revenue { border-left-color: #17a2b8; }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .controls {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }

        .filter-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            background: #f8f9fa;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .filter-btn.active {
            background: #667eea;
            color: white;
        }

        .filter-btn:hover {
            background: #e9ecef;
        }

        .filter-btn.active:hover {
            background: #5a67d8;
        }

        .transactions-grid {
            display: grid;
            gap: 1.5rem;
        }

        .transaction-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .transaction-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .transaction-header {
            padding: 1.5rem;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: start;
        }

        .transaction-info h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .transaction-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
            color: #666;
            flex-wrap: wrap;
        }

        .transaction-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.belum-dikirim {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.dikirim {
            background: #d4edda;
            color: #155724;
        }

        .status-select {
            padding: 0.5rem;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .update-btn {
            padding: 0.5rem 1rem;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .update-btn:hover {
            background: #218838;
        }

        .transaction-products {
            padding: 1.5rem;
        }

        .product-item {
            display: grid;
            grid-template-columns: 60px 1fr auto auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem 0;
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
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-details h4 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .product-price {
            color: #666;
            font-size: 0.9rem;
        }

        .product-quantity {
            font-weight: 600;
            text-align: center;
        }

        .product-total {
            font-weight: 600;
            color: #28a745;
            text-align: right;
        }

        .transaction-summary {
            background: #f8f9fa;
            padding: 1.5rem;
            border-top: 1px solid #e9ecef;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .summary-row.total {
            font-weight: bold;
            font-size: 1.1rem;
            color: #28a745;
            border-top: 1px solid #e9ecef;
            padding-top: 0.5rem;
            margin-top: 1rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .no-transactions {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }

        .no-transactions .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-buttons {
                justify-content: center;
            }
            
            .transaction-header {
                grid-template-columns: 1fr;
            }
            
            .transaction-actions {
                justify-content: center;
                margin-top: 1rem;
            }
            
            .product-item {
                grid-template-columns: 60px 1fr;
                gap: 1rem;
            }
            
            .product-quantity,
            .product-total {
                grid-column: 2;
                text-align: left;
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛍️ Kelola Transaksi</h1>
        <p>Dashboard admin untuk mengelola semua transaksi pelanggan</p>
    </div>

    <div class="container">
        <!-- Statistik -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-number"><?php echo number_format($stats['total_transaksi']); ?></div>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-card pending">
                <div class="stat-number"><?php echo number_format($stats['belum_dikirim']); ?></div>
                <div class="stat-label">Belum Dikirim</div>
            </div>
            <div class="stat-card shipped">
                <div class="stat-number"><?php echo number_format($stats['dikirim']); ?></div>
                <div class="stat-label">Sudah Dikirim</div>
            </div>
            <div class="stat-card revenue">
                <div class="stat-number">Rp <?php echo number_format($stats['total_pendapatan'], 0, ',', '.'); ?></div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($success_message)): ?>
            <div class="alert success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Controls -->
        <div class="controls">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="🔍 Cari berdasarkan username, produk, atau ID transaksi..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="filter-buttons">
                <a href="?status=all&search=<?php echo urlencode($search); ?>" class="filter-btn <?php echo $status_filter == 'all' ? 'active' : ''; ?>">Semua</a>
                <a href="?status=Belum Dikirim&search=<?php echo urlencode($search); ?>" class="filter-btn <?php echo $status_filter == 'Belum Dikirim' ? 'active' : ''; ?>">Belum Dikirim</a>
                <a href="?status=Dikirim&search=<?php echo urlencode($search); ?>" class="filter-btn <?php echo $status_filter == 'Dikirim' ? 'active' : ''; ?>">Dikirim</a>
            </div>
        </div>

        <!-- Transactions -->
        <div class="transactions-grid">
            <?php if (empty($transactions)): ?>
                <div class="no-transactions">
                    <div class="icon">📦</div>
                    <h3>Tidak ada transaksi ditemukan</h3>
                    <p>Belum ada transaksi yang sesuai dengan filter yang dipilih</p>
                </div>
            <?php else: ?>
                <?php foreach ($transactions as $key => $transaction): ?>
                    <div class="transaction-card">
                        <div class="transaction-header">
                            <div class="transaction-info">
                                <h3>👤 <?php echo htmlspecialchars($transaction['username']); ?></h3>
                                <div class="transaction-meta">
                                    <span>📧 <?php echo htmlspecialchars($transaction['email']); ?></span>
                                    <span>📅 <?php echo date('d M Y H:i', strtotime($transaction['tanggal'])); ?></span>
                                    <span>📍 Alamat ID: <?php echo $transaction['id_alamat']; ?></span>
                                </div>
                            </div>
                            <div class="transaction-actions">
                                <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $transaction['status'])); ?>">
                                    <?php echo $transaction['status']; ?>
                                </span>
                            </div>
                        </div>

                        <div class="transaction-products">
                            <?php foreach ($transaction['produk'] as $produk): ?>
                                <div class="product-item">
                                    <div class="product-image">
                                        <?php if (!empty($produk['gambar'])): ?>
                                            <img src="gambar_produk/<?php echo htmlspecialchars($produk['gambar']); ?>" alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>">
                                        <?php else: ?>
                                            📦
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-details">
                                        <h4><?php echo htmlspecialchars($produk['nama_produk']); ?></h4>
                                        <div class="product-price">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
                                    </div>
                                    <div class="product-quantity">
                                        Qty: <?php echo $produk['jumlah_produk']; ?>
                                    </div>
                                    <div class="product-total">
                                        Rp <?php echo number_format($produk['total_harga'], 0, ',', '.'); ?>
                                    </div>
                                </div>

                                <!-- Form update status untuk setiap produk -->
                                <form method="POST" style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px; display: flex; gap: 1rem; align-items: center;">
                                    <input type="hidden" name="id_transaksi" value="<?php echo $produk['id_transaksi']; ?>">
                                    <label style="font-weight: 600;">Update Status:</label>
                                    <select name="status_baru" class="status-select">
                                        <option value="Belum Dikirim" <?php echo $produk['status'] == 'Belum Dikirim' ? 'selected' : ''; ?>>Belum Dikirim</option>
                                        <option value="Dikirim" <?php echo $produk['status'] == 'Dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                                    </select>
                                    <button type="submit" name="update_status" class="update-btn">💾 Update</button>
                                </form>
                            <?php endforeach; ?>
                        </div>

                        <div class="transaction-summary">
                            <div class="summary-row">
                                <span>Subtotal Produk:</span>
                                <span>Rp <?php echo number_format($transaction['total_keseluruhan'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="summary-row">
                                <span>Ongkos Kirim:</span>
                                <span>Rp <?php echo number_format($transaction['ongkir'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="summary-row total">
                                <span>Total Keseluruhan:</span>
                                <span>Rp <?php echo number_format($transaction['total_keseluruhan'] + $transaction['ongkir'], 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchValue = this.value;
                const currentStatus = new URLSearchParams(window.location.search).get('status') || 'all';
                window.location.href = `?status=${currentStatus}&search=${encodeURIComponent(searchValue)}`;
            }
        });

        // Auto-refresh every 30 seconds for real-time updates
        setTimeout(function() {
            location.reload();
        }, 30000);

        // Confirm before updating status
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const statusSelect = this.querySelector('select[name="status_baru"]');
                const currentStatus = statusSelect.dataset.current || '';
                const newStatus = statusSelect.value;
                
                if (currentStatus !== newStatus) {
                    if (!confirm(`Apakah Anda yakin ingin mengubah status transaksi menjadi "${newStatus}"?`)) {
                        e.preventDefault();
                    }
                }
            });
        });
    </script>
</body>
</html>