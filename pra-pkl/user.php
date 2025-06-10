<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location:login1.php " . $_SERVER['HTTP_REFERER'] . "?AndaBelumLogin");
    // header("location:login1.php?=AndaBukanAdmin");
    exit;
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="css/user_style.css">
</head>
<body>
    <header>
        <img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" >
        <nav>
            <div class="profile-icon">    
                <a href="DaftarProduk.php" style="font-size: 17px;">Products</a>
                <a href="keranjang.php" style="font-size: 17px;">Cart</a>
                <a href="profile.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <h1>My Account Gweh</h1>
        <div class="user-menu">
            <a href="DaftarProduk.php">Product Store <span>▶</span></a>
            <a href="keranjang.php">Cart <span>▶</span></a>
            <a href="profile.php">User Info <span>▶</span></a>
            <a href="pembayaran.php">Payment <span>▶</span></a>
            <a href="Logout.php">Logout <span>▶</span></a>
        </div>
    </main>

    <footer>
        <div class="footer-left">
            <p>Official Social Media Account</p>
            <div class="social-icons">
                <img src="img/footer/twitter.png" alt="X">
                <img src="img/footer/youtube.png" alt="YouTube">
                <img src="img/footer/instagram.png" alt="Instagram">
            </div>
        </div>
        <div class="footer-right">
            <a href="about.php">About Us</a>
            <a href="DaftarProduk.php">R&A Figure Store</a>
        </div>
    </footer>
</body>
</html>