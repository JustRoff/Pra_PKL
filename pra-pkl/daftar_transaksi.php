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
    <title>Admin - Transaksi</title>
    <link rel="stylesheet" href="css/dftr_trnsk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <a href="homepage.php"><img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" ></a>
        <nav>
            <div class="profile-icon">    
                <a href="dashboard.php">Add Product</a>
                <a href="DaftarProduk.php">Products</a>
                <a href="admin.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
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