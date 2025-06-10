<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>R&A Figure</title>
  <link rel="stylesheet" href="css/homepage.css">
</head>
<body>
  <header>
    <h1>R&A Figure</h1>
    <nav>
      <a href="about.php">About us</a>
      <a href="DaftarProduk.php">Products</a>
      <a href="#">Cart 🛒</a>
    </nav>
  </header>

  <div class="carousel-container">
    <button class="carousel-button prev">❮</button>
    <button class="carousel-button next">❯</button>
    <div class="carousel" id="carousel">
      <img src="img/sample product/carousel/crsl1.webp" alt="Banner 1">
      <img src="img/sample product/carousel/crsl2.webp" alt="Banner 2">
      <img src="img/sample product/carousel/crsl3.webp" alt="Banner 3">
    </div>
  </div>

  <div class="search-section">
    <input type="text" placeholder="Search products...">
    <button>Search</button>
    <select>
      <option>Category</option>
    </select>
  </div>

  <div class="banner-section">
    <h2>Figure Categories</h2>
    <div class="banner-grid">
      <img src="img/sample product/banner/ねんどろいど.png" alt="Nendoroid">
      <img src="img/sample product/banner/figma.png" alt="Figma">
      <img src="img/sample product/banner/17.png" alt="Scale 1/7">
      <img src="img/sample product/banner/18.png" alt="Scale 1/8-1/6">
    </div>
  </div>

  <div class="product-section">
    <div class="product-card">
      <img src="img/sample product/products/Hina.webp" alt="Product 1">
      <p><strong>Nendoroid Hina</strong><br>Rp816,000</p>
    </div>
    <div class="product-card">
      <img src="img/sample product/products/Asahi.webp" alt="Product 2">
      <p><strong>Nendoroid Asahi</strong><br>Rp740,000</p>
    </div>
    <div class="product-card">
      <img src="img/sample product/products/Kirby.webp" alt="Product 3">
      <p><strong>Nendoroid Kirby</strong><br>Rp630,500</p>
    </div>
    <!-- Add more products here -->
  </div>

  <div class="see-more">
    <button>See More</button>
  </div>

  <script>
    const carousel = document.getElementById('carousel');
    const prev = document.querySelector('.carousel-button.prev');
    const next = document.querySelector('.carousel-button.next');

    let index = 0;

    function updateCarousel() {
      carousel.style.transform = `translateX(-${index * 100}%)`;
    }

    prev.addEventListener('click', () => {
      index = (index - 1 + carousel.children.length) % carousel.children.length;
      updateCarousel();
    });

    next.addEventListener('click', () => {
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
