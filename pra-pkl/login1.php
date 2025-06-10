<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R&A Figure - Log In</title>
    <link rel="stylesheet" href="css/login-style.css">
</head>
<body>
    <header>
        <img src="img/logo/logo.png" alt="R&A Figure Logo" class="logo">
        <nav>
            <div class="profile_icon">
                <a href="about.php">About us</a>
                <a href="DaftarProduk.php">Products</a>
                <a href="profile.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <div class="login-box">
            <h2>Log In</h2>
            <form action="proses_login.php" method="post">
                <label>Username</label>
                <input type="text" name="username" id="" placeholder="Username" required>

                <label>Password (Must include at least one uppercase letter, one lowercase letter, one number and one special character)</label>
                <input type="password" name="password" id="" placeholder="Password" required>

                <button type="submit">Login</button>

                <div class="forgot">
                    <a href="#">Forgot your email or password?</a>
                </div>
            </form>

            <hr>

            <div class="register">
                <p>Don’t have an account?</p>
                <a href="register.php"><button>Registration</button></a>
            </div>
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
