<?php
include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        body {
            background-color: #fff;
        }

        header {
            position: sticky;
            top: 0;
            background-color: white;
            border-bottom: 4px solid #222;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            z-index: 1000;
        }

        .logo {
            width: 200px;
            height: 65px;
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #222;
            font-size: 14px;
        }

        .user-icon {
            height: 32px;
            vertical-align: middle;
            margin-left: 15px;
        }

        main {
            padding: 100px 30px 80px;
            text-align: center;
        }

        main h1 {
            margin-bottom: 40px;
            font-size: 28px;
        }

        .admin-menu {
            display: grid;
            grid-template-columns: repeat(2, 200px);
            gap: 20px;
            justify-content: center;
        }

        .admin-menu a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #999;
            text-decoration: none;
            color: #222;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .admin-menu a:hover {
            color: black;
            background-color: #f0f0f0;
        }

        footer {
            margin-top: 80px;
            border-top: 3px solid orange;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .footer-left p {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .social-icons img {
            height: 24px;
            margin-right: 10px;
        }

        .footer-right {
            display: flex;
            gap: 20px; /* Jarak antar link */
            justify-content: flex-end; /* Sejajarkan ke kanan */
            align-items: center;
        }

        .footer-right a {
            text-decoration: none; /* Hilangkan underline */
            color: #222;
            font-size: 15px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <header>
        <img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" >
        <nav>
            <div class="profile-icon">    
                <a href="dashboard.php" style="font-size: 17px;"><strong>Add Product</strong></a>
                <a href="DaftarProduk.php" style="font-size: 17px;"><strong>Products</strong></a>
                <img src="img/user/user.png" alt="User Icon" class="user-icon">
            </div>
        </nav>
    </header>

    <main>
        <h1>Haloo....</h1>

        <p>Selamat datang di R&A Figure Store. Kami harap anda menemukan apa yang anda cari.</p>
        <p>R&A Figure Store adalah sebuah toko merchandise yang memfokuskan penjualan figure, seperti nendoroid.</p>
        <p>Dah itu aja.... Selamat berbelanja kawan...</p>
        <br>
        <h3>Awas khilaf !!</h3>
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
            <a href="about.php">About us</a>
            <a href="DaftarProduk.php">R&A Figure Store</a>
        </div>
    </footer>
</body>
</html>