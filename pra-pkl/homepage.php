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
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Courier New', Courier, monospace;
    }
    header {
      position: sticky;
      top: 0;
      background: white;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .carousel-container {
      position: relative;
      background: #333;
      padding: 20px;
      overflow: hidden;
    }
    .carousel {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }
    .carousel img {
      min-width: 100%;
      height: auto;
      border-radius: 8px;
    }
    .carousel-button {
      position: absolute;
      top: 10px;
      background: white;
      border: none;
      padding: 10px;
      cursor: pointer;
      border-radius: 50%;
      z-index: 10;
    }
    .carousel-button.prev {
      left: 10px;
    }
    .carousel-button.next {
      right: 10px;
    }
    .search-section {
      text-align: center;
      padding: 20px;
    }
    .search-section input, .search-section select, .search-section button {
      padding: 10px;
      font-size: 16px;
      margin: 5px;
    }
    .banner-section {
      padding: 20px;
      text-align: center;
    }
    .banner-grid {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
    }
    .banner-grid img {
      width: 300px;
      height: auto;
      border-radius: 10px;
    }
    .product-section {
      padding: 20px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      justify-items: center;
    }
    .product-card {
      width: 200px;
      text-align: center;
    }
    .product-card img {
      width: 100%;
      border-radius: 8px;
    }
    .see-more {
      text-align: center;
      margin: 20px;
    }
    .see-more button {
      padding: 10px 30px;
      background: orange;
      border: none;
      border-radius: 20px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
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
