<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <a href="homepage.php"><img src="img/logo/logo.png" alt="R&A Figure Logo" class="logo"></a>
        <nav>
            <div class="profile-icon">
                <a href="about.php">About us</a>
                <a href="DaftarProduk.php">Products</a>
                <a href="login1.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <div class="login-box">
            <h2>Registration</h2>
            <form action="proses_register.php" method="post">
                <label for="">Username</label>
                <input type="text" name="username" id=""><br>

                <label for="">Password</label>
                <input type="password" name="password" id=""><br>

                <label for="">Tanggal Lahir</label>
                <input type="date" name="Date_Of_Birth" id=""><br>

                <label for="">Email</label>
                <input type="email" name="email" id=""><br><br>

                <button type="submit">Register</button>
            </form>

            <hr>

            <div class="register">
                <p>Already have an account?</p>
                <a href="login1.php"><button>Login</button></a>
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
            <a href="DaftarProduk.php">R&A Figure Store</a>
        </div>
    </footer>
</body>
</html>