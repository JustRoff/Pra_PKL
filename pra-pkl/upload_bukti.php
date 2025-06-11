<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['checkout'])) {
    header("Location: keranjang.php");
    exit;
}

$data = $_SESSION['checkout'];
$subtotal = $data['subtotal'] ?? 0;
$ongkir = $data['ongkir'] ?? 0;
$total_akhir = $data['total_akhir'] ?? 0;
$total_barang = $data['total_barang'] ?? 0;

$checkout_items = $data['checkout_items'] ?? [];
$produk_dibeli = [];

if (!empty($checkout_items)) {
    // Sanitize dan gabungkan ID produk
    $ids = implode(',', array_map('intval', $checkout_items));
    
    // ✅ Query yang diperbaiki dengan JOIN ke keranjang untuk mendapatkan jumlah
    $query = "SELECT p.nama_produk, p.gambar, k.jumlah_item, p.harga, k.subtotal
              FROM produk p 
              JOIN keranjang k ON p.id_produk = k.id_produk 
              WHERE p.id_produk IN ($ids) AND k.id_user = '{$_SESSION['id_user']}'";
    
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $produk_dibeli[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Transaksi</title>
    <link rel="stylesheet" href="css/bukti.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" >
        <nav>
            <div class="profile-icon">    
                <a href="DaftarProduk.php">Products</a>
                <a href="keranjang.php">Cart</a>
                <a href="cek_profil.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <div class="checkout-container">
        <h2>Upload Bukti Pembayaran</h2>

        <div class="product-list">
            <strong style="color: #495057; font-size: 16px;">📦 Produk yang akan dibeli:</strong>
            <?php if (!empty($produk_dibeli)): ?>
                <div style="margin-top: 15px;">
                <?php foreach ($produk_dibeli as $produk): ?>
                    <div class="product-item">
                        <img src="gambar_produk/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['nama_produk']) ?>" style="max-width: 120px;">
                        <div class="product-name">
                            <?= htmlspecialchars($produk['nama_produk']) ?>
                        </div>
                        <div class="product-details">
                            <div class="product-qty">
                                Qty: <?= $produk['jumlah_item'] ?> pcs
                            </div>
                            <div class="product-price">
                                @ Rp<?= number_format($produk['harga'], 0, ',', '.') ?>
                            </div>
                            <div style="color: #dc3545; font-weight: bold; margin-top: 2px;">
                                Subtotal: Rp<?= number_format($produk['subtotal'], 0, ',', '.') ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #6c757d; margin-top: 10px;">Tidak ada barang dalam keranjang.</p>
            <?php endif; ?>
        </div>

        <!-- ✅ Ringkasan pembayaran dengan style yang lebih baik -->
        <div style="background-color: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-bottom: 25px;">
            <div class="summary-row">
                <span>💰 Subtotal Produk</span>
                <span>Rp<?= number_format($subtotal, 0, ',', '.') ?></span>
            </div>
            <div class="summary-row">
                <span>🚚 Ongkos Kirim</span>
                <span>Rp<?= number_format($ongkir, 0, ',', '.') ?></span>
            </div>
            <div class="summary-row">
                <span>Qty total</span>
                <span><?=$total_barang?></span>
            </div>
            <div class="summary-row total">
                <span>💳 Total Pembayaran</span>
                <span>Rp<?= number_format($total_akhir, 0, ',', '.') ?></span>
            </div>
        </div>

        <form action="proses_pembayran.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="tanggal_pemesanan">

            <label for="provider">Pilih Provider Pembayaran:</label>
            <select name="provider" id="provider" onchange="showPaymentInfo()" required>
                <option value="">-- Pilih Provider --</option>
                <option value="DANA">DANA</option>
                <option value="Mandiri">Bank Mandiri</option>
                <option value="BCA">Bank BCA</option>
                <option value="BNI">Bank BNI</option>
            </select>

            <!-- ✅ Info pembayaran yang akan muncul dinamis -->
            <div id="payment-info" class="payment-info">
                <h4 id="payment-title"></h4>
                <div id="account-info"></div>
                <div class="payment-note">
                    <strong>⚠️ Penting:</strong> Transfer sesuai dengan nominal yang tertera di atas. Screenshot bukti transfer dan upload di bawah ini.
                </div>
            </div>

            <label for="bukti">Upload Bukti Pembayaran:</label>
            <input type="file" name="bukti_pembayaran" id="bukti" accept="image/*" required>
            
            <div style="font-size: 12px; color:rgb(255, 0, 0); margin-top: 5px; margin-bottom: 15px;">
                * Format yang didukung: JPG, PNG, GIF (Max: 5MB)
            </div>

            <button type="submit" class="btn">Kirim Bukti Pembayaran</button>
        </form>
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
        function showPaymentInfo() {
            const provider = document.getElementById('provider').value;
            const paymentInfo = document.getElementById('payment-info');
            const paymentTitle = document.getElementById('payment-title');
            const accountInfo = document.getElementById('account-info');
            
            // Data rekening/nomor untuk setiap provider
            const paymentData = {
                'DANA': {
                    title: 'Transfer ke DANA',
                    number: '0821-3799-5812',
                    type: 'Nomor DANA'
                },
                'Mandiri': {
                    title: 'Transfer ke Bank Mandiri',
                    number: '2007112297070',
                    type: 'No. Rekening Mandiri'
                },
                'BCA': {
                    title: 'Transfer ke Bank BCA',
                    number: '0800966355',
                    type: 'No. Rekening BCA'
                },
                'BNI': {
                    title: 'Transfer ke Bank BNI',
                    number: '89954220911',
                    type: 'No. Rekening BNI'
                }
            };
            
            if (provider && paymentData[provider]) {
                const data = paymentData[provider];
                
                paymentTitle.textContent = data.title;
                accountInfo.innerHTML = `
                    <div style="margin-bottom: 10px;">
                        <strong>${data.type}:</strong>
                    </div>
                    <div class="account-number">
                        ${data.number}
                        <button type="button" class="copy-btn" onclick="copyToClipboard('${data.number}')">
                            📋 Copy
                        </button>
                    </div>
                `;
                
                paymentInfo.style.display = 'block';
            } else {
                paymentInfo.style.display = 'none';
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Berikan feedback visual
                const copyBtn = event.target;
                const originalText = copyBtn.textContent;
                copyBtn.textContent = '✅ Copied!';
                copyBtn.style.background = '#28a745';
                
                setTimeout(function() {
                    copyBtn.textContent = originalText;
                    copyBtn.style.background = '#2196f3';
                }, 2000);
            }).catch(function(err) {
                alert('Gagal menyalin: ' + text);
            });
        }
    </script>

</body>
</html>