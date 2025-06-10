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
    $query = "SELECT p.nama_produk, k.jumlah_item, p.harga, k.subtotal
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
<html>
<head>
    <title>Upload Bukti Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
        }
        .checkout-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        
        /* ✅ Style untuk daftar produk */
        .product-list {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .product-item:last-child {
            border-bottom: none;
        }
        .product-name {
            font-weight: 500;
            color: #495057;
        }
        .product-details {
            text-align: right;
            font-size: 14px;
        }
        .product-qty {
            color: #6c757d;
            margin-bottom: 2px;
        }
        .product-price {
            color: #28a745;
            font-weight: bold;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 16px;
            padding: 8px 0;
        }
        .summary-row.total {
            font-weight: bold;
            font-size: 18px;
            border-top: 2px solid #ddd;
            padding-top: 15px;
            margin-top: 20px;
            color: #dc3545;
        }
        form {
            margin-top: 30px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            margin-top: 15px;
            font-weight: 500;
            color: #495057;
        }
        select, input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 6px;
            border: 1px solid #ced4da;
            font-size: 14px;
        }
        select:focus, input[type="file"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,.25);
        }
        
        /* ✅ Style untuk info rekening */
        .payment-info {
            margin-top: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border-radius: 8px;
            border-left: 4px solid #2196f3;
            display: none;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .payment-info h4 {
            margin: 0 0 10px 0;
            color: #1565c0;
            font-size: 16px;
        }
        
        .account-number {
            font-size: 18px;
            font-weight: bold;
            color: #d32f2f;
            background: white;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin: 10px 0;
            letter-spacing: 1px;
            border: 2px dashed #2196f3;
        }
        
        .copy-btn {
            background: #2196f3;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-left: 10px;
            transition: background 0.3s;
        }
        
        .copy-btn:hover {
            background: #1976d2;
        }
        
        .payment-note {
            font-size: 13px;
            color: #666;
            margin-top: 10px;
            padding: 8px;
            background: rgba(255,255,255,0.7);
            border-radius: 4px;
        }
        
        .btn {
            display: inline-block;
            margin-top: 15px;
            text-align: center;
            background: #28a745;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            width: 100%;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>📋 Upload Bukti Pembayaran</h2>

    <div class="product-list">
        <strong style="color: #495057; font-size: 16px;">📦 Produk yang akan dibeli:</strong>
        <?php if (!empty($produk_dibeli)): ?>
            <div style="margin-top: 15px;">
            <?php foreach ($produk_dibeli as $produk): ?>
                <div class="product-item">
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
            <span>💳 TOTAL PEMBAYARAN</span>
            <span>Rp<?= number_format($total_akhir, 0, ',', '.') ?></span>
        </div>
    </div>

    <form action="proses_pembayran.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="tanggal_pemesanan">

        <label for="provider">🏦 Pilih Provider Pembayaran:</label>
        <select name="provider" id="provider" onchange="showPaymentInfo()" required>
            <option value="">-- Pilih Provider --</option>
            <option value="DANA">💙 DANA</option>
            <option value="Mandiri">🟡 Bank Mandiri</option>
            <option value="BCA">🔵 Bank BCA</option>
            <option value="BNI">🟠 Bank BNI</option>
        </select>

        <!-- ✅ Info pembayaran yang akan muncul dinamis -->
        <div id="payment-info" class="payment-info">
            <h4 id="payment-title"></h4>
            <div id="account-info"></div>
            <div class="payment-note">
                <strong>⚠️ Penting:</strong> Transfer sesuai dengan nominal yang tertera di atas. Screenshot bukti transfer dan upload di bawah ini.
            </div>
        </div>

        <label for="bukti">📸 Upload Bukti Pembayaran:</label>
        <input type="file" name="bukti_pembayaran" id="bukti" accept="image/*" required>
        
        <div style="font-size: 12px; color: #6c757d; margin-top: 5px; margin-bottom: 15px;">
            * Format yang didukung: JPG, PNG, GIF (Max: 5MB)
        </div>

        <button type="submit" class="btn">✅ Kirim Bukti Pembayaran</button>
    </form>
</div>

<script>
function showPaymentInfo() {
    const provider = document.getElementById('provider').value;
    const paymentInfo = document.getElementById('payment-info');
    const paymentTitle = document.getElementById('payment-title');
    const accountInfo = document.getElementById('account-info');
    
    // Data rekening/nomor untuk setiap provider
    const paymentData = {
        'DANA': {
            title: '💙 Transfer ke DANA',
            number: '0821-3799-5812',
            type: 'Nomor DANA'
        },
        'Mandiri': {
            title: '🟡 Transfer ke Bank Mandiri',
            number: '2007112297070',
            type: 'No. Rekening Mandiri'
        },
        'BCA': {
            title: '🔵 Transfer ke Bank BCA',
            number: '0800966355',
            type: 'No. Rekening BCA'
        },
        'BNI': {
            title: '🟠 Transfer ke Bank BNI',
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