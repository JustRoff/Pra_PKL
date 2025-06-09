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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" >
        <nav>
            <div class="profile-icon">    
                <a href="DaftarProduk.php">Products</a>
                <a href="keranjang.php">Cart</a>
                <a href="profile.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <h1>My Account</h1>
        <div class="user-menu">
            <a href="DaftarProduk.php">Product Store <span>▶</span></a>
            <a href="keranjang.php">Cart <span>▶</span></a>
            <a href="profile.php">User Info <span>▶</span></a>
            <a href="transaksi.php">Payment <span>▶</span></a>
            <a href="Logout.php">Logout <span>▶</span></a>
        </div>
    </main>

    <footer>
        <div class="footer-left">
            <p>Official Social Media Account</p>
            <div class="social-icons">
                <a href="https://x.com/" class="text-light fs-4"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://www.youtube.com/" class="text-light fs-4"><i class="fa-brands fa-youtube"></i></a>
                <a href="https://www.instagram.com/" class="text-light fs-4"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-right">
            <a href="about.php">About Us</a>
            <a href="DaftarProduk.php">R&A Figure Store</a>
        </div>
    </footer>
</body>
</html>