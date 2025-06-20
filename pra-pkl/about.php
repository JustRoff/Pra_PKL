<?php
include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <a href="homepage.php"><img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" ></a>
        <nav>
            <div class="profile-icon">    
                <!-- <a href="dashboard.php"><strong>Add Product</strong></a> -->
                <a href="DaftarProduk.php"><strong>Products</strong></a>
                <a href="cek_profil.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <h1>Haloo....</h1>
        <div class="deskripsi">
            <p>Selamat datang di R&A Figure Store.</p>
            <p>Kami harap anda menemukan apa yang anda cari.</p>
            <br>
            <p>R&A Figure Store adalah sebuah toko merchandise</p>
            <p>yang memfokuskan penjualan figure, seperti nendoroid.</p>
            <br>
            <p>Dah itu aja.... Selamat berbelanja kawan...</p>
        </div>
        <h3>Awas khilaf !!</h3>


        <!-- <h3 class="adm">Berikut adalah sosok admin</h3>
        <div class="container">
            <div class="admin_person">
                <img src="pic_admin/JustRoff.jpg" alt="Admin 1">    
                <p>Rofi Dwi Saputra</p>
                <p>a.k.a</p>
                <p>JustRoff</p>
            </div>

            <div class="admin_person">
                <img src="pic_admin/KaitoNight.jpg" alt="Admin 2">
                <p>Muhammad Alif Nurul Insan</p>
                <p>a.k.a</p>
                <p>KaitoNight</p>
            </div>
        </div> -->
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
            <a href="about.php">About us</a>
            <a href="DaftarProduk.php">R&A Figure Store</a>
        </div>
    </footer>
</body>
</html>