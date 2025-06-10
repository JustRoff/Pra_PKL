<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="css/homepage.css">
</head>
<body>
    <header>
        <img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" >
        <nav>
            <div class="profile-icon">    
                <a href="dashboard.php" style="font-size: 17px;">Add Product</a>
                <a href="DaftarProduk.php" style="font-size: 17px;">Products</a>
                <a href="admin.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <div class="carousel-container">
            <button class="carousel-button prev"> ❮ </button>
            <button class="carousel-button next"> ❯ </button>

            <div class="carousel" id="carousel">
                <img src="img/sample product/carousel/crsl1.webp" alt="Banner 1">
                <img src="img/sample product/carousel/crsl2.webp" alt="Banner 2">
                <img src="img/sample product/carousel/crsl3.webp" alt="Banner 3">
            </div>
        </div>

        <div class="search-section">
            <input type="text" name="" id="" placeholder="Search products...">
            <button>Search</button>
            <select name="" id="">
                <option value="">Category</option>
            </select>
        </div>

        <div class="banner-section">
            <h2>Figure Categories</h2>
            <div class="banner-grid">
                <img src="img/sample product/banner/ねんどろいど.png" alt="Nendoroid">
                <img src="img/sample product/banner/figma.png" alt="Figma">
                <img src="img/sample product/banner/17.png" alt="1/7">
                <img src="img/sample product/banner/18.png" alt="1/8">
            </div>
        </div>

        <div class="product-section">
            <div class="product-card">
                <img src="img/sample product/products/Hina.webp" alt="Hina">
                <p><strong>Nendoroid Hina</strong><br>Rp816,000</p>
            </div>

            <div class="product-card">
                <img src="img/sample product/products/Asahi.webp" alt="Asahi">
                <p><strong>Nendoroid Asahi</strong><br>Rp816,000</p>
            </div>

            <div class="product-card">
                <img src="img/sample product/products/Kirby.webp" alt="Kirby">
                <p><strong>Nendoroid Kirby</strong><br>Rp816,000</p>
            </div>

            <div class="product-card">
                <img src="img/sample product/products/Kiara.webp" alt="KIara">
                <p><strong>Nendoroid Kiara</strong><br>Rp816,000</p>
            </div>
        </div>

        <div class="see-more">
            <button>See More</button>
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
            <a href="homepage.php">R&A Figure Store</a>
        </div>
    </footer>

    <script>
        const carousel = document.getElementById('carousel');
        const prev = document.querySelector('carousel-button prev');
        const next = document.querySelector('carousel-button next');

        let index = 0;

        function updateCarousel() {
            carousel.style.transform = `translateX(-${index * 100}%)`;
        }

        prev.addEventListener('click', () => {
            index = (index - 1 + carousel.children.length) % carousel.children.length;
            updateCarousel();
        });

        prev.addEventListener('click', () => {
            index = (index + 1) % carousel.children.length;
            updateCarousel();
        });

        setInterval(() => {
            index = (index + 1) % carousel.children.length;
            updateCarousel();
        }, 5000);
    </script>
</body>
</html>