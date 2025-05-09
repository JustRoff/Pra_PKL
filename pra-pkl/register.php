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
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Courier New', Courier, monospace;
            background: #fff;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 10px;
            border-bottom: 4px solid black;
        }

        .logo {
            /* height: 30px; */
            /* width: 30px; */
            padding-left: 20px;
            width: 200px;
            height: 65px
        }

        /*nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }*/

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: black;
            font-size: 17px;
        }

        .profile {
            height: 32px;
            /* border-radius: 50%; */
            vertical-align: middle;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            text-align: left;
            margin-top: 10px;
            font-size: 14px;
        }

        form input {
            margin-top: 5px;
            padding: 8px;
            border: 1px solid orange;
            border-radius: 2px;
        }

        form button {
            margin-top: 20px;
            padding: 10px;
            background: orange;
            border: none;
            color: white;
            border-radius: 20px;
            cursor: pointer;
        }

        .forgot {
            margin-top: 10px;
            font-size: 12px;
        }

        hr {
            margin: 30px 0;
            border: none;
            border-top: 1px solid lightgray;
        }

        .register p {
            margin-bottom: 10px;
        }

        .register button {
            padding: 10px 20px;
            background: orange;
            border: none;
            color: white;
            border-radius: 20px;
            cursor: pointer;
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