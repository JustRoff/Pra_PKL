<?php
session_start();
include "koneksi.php";

// Query untuk mengambil 16 produk terbaru berdasarkan tanggal terbit
$query_produk = "SELECT * FROM produk ORDER BY tanggal_terbit DESC LIMIT 16";
$result_produk = mysqli_query($koneksi, $query_produk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>R&A Figure</title>
  <style>
    * {
    margin: 0;
    padding: 0;
    /* box-sizing: border-box; */
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
    padding: 10px 10px;
    z-index: 1000;
}

.logo {
    padding-left: 20px;
    width: 200px;
    height: 65px;
}

nav a {
    margin: 0 10px;
    text-decoration: none;
    color: black;
    font-size: 17px;
    font-weight: bold;
}

.profile {
    height: 32px;
    vertical-align: middle;
    /* margin-left: 15px; */
}

.profile-icon a:hover {
    color: rgb(248, 198, 33);
    background-color: transparent;
}
    
    .carousel-container {
      position: relative;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 40px 20px;
      overflow: hidden;
      margin-bottom: 30px;
    }
    
    .carousel {
      display: flex;
      transition: transform 0.5s ease-in-out;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    .carousel img {
      min-width: 100%;
      height: 400px;
      object-fit: cover;
    }
    
    .carousel-button {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255,255,255,0.9);
      border: none;
      padding: 15px;
      cursor: pointer;
      border-radius: 50%;
      z-index: 10;
      font-size: 18px;
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .carousel-button:hover {
      background: white;
      transform: translateY(-50%) scale(1.1);
    }
    
    .carousel-button.prev {
      left: 20px;
    }
    
    .carousel-button.next {
      right: 20px;
    }
    
    .search-section {
      text-align: center;
      padding: 30px 20px;
      background: white;
      margin: 20px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .search-section input, .search-section select, .search-section button {
      padding: 12px 20px;
      font-size: 16px;
      margin: 5px;
      border: 2px solid #e9ecef;
      border-radius: 25px;
      outline: none;
      transition: all 0.3s;
    }
    
    .search-section input:focus, .search-section select:focus {
      border-color: #ff6b35;
      box-shadow: 0 0 10px rgba(255,107,53,0.2);
    }
    
    .search-section button {
      background: #ff6b35;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    
    .search-section button:hover {
      background: #e55a2b;
      transform: translateY(-2px);
    }
    
    .banner-section {
      padding: 40px 20px;
      text-align: center;
      background: white;
      margin: 20px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .banner-section h2 {
      margin-bottom: 30px;
      color: #333;
      font-size: 2.5em;
      background: linear-gradient(45deg, #ff6b35, #f7931e);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .banner-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .banner-item {
      position: relative;
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .banner-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    
    .banner-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s;
    }
    
    .banner-item:hover img {
      transform: scale(1.05);
    }
    
    .banner-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(transparent, rgba(0,0,0,0.8));
      color: white;
      padding: 20px;
      text-align: center;
    }
    
    .banner-overlay h3 {
      font-size: 1.2em;
      margin-bottom: 5px;
    }
    
    .product-section {
      padding: 40px 20px;
      background: white;
      margin: 20px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .product-section h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
      font-size: 2.5em;
      background: linear-gradient(45deg, #ff6b35, #f7931e);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .product-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    @media (max-width: 1024px) {
      .product-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    
    @media (max-width: 768px) {
      .product-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    
    @media (max-width: 480px) {
      .product-grid {
        grid-template-columns: 1fr;
      }
    }
    
    .product-card {
      background: white;
      border-radius: 15px;
      padding: 15px;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      border: 1px solid #f0f0f0;
    }
    
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    
    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 10px;
      transition: transform 0.3s;
    }
    
    .product-card:hover img {
      transform: scale(1.05);
    }
    
    .product-card h3 {
      font-size: 1em;
      margin-bottom: 8px;
      color: #333;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .product-card .price {
      font-size: 1.1em;
      font-weight: bold;
      color: #ff6b35;
      margin-bottom: 10px;
    }
    
    .product-card .category {
      font-size: 0.8em;
      color: #666;
      background: #f8f9fa;
      padding: 4px 8px;
      border-radius: 12px;
      display: inline-block;
    }
    
    .see-more {
      text-align: center;
      margin: 30px 0;
    }
    
    .see-more button {
      padding: 15px 40px;
      background: linear-gradient(45deg, #ff6b35, #f7931e);
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: bold;
      color: white;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(255,107,53,0.3);
    }
    
    .see-more button:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(255,107,53,0.4);
    }
    
    .no-products {
      text-align: center;
      padding: 50px;
      color: #666;
    }
  </style>
</head>
<body>
  <header>
    <a href="homepage.php"><img src="img/logo/logo.png" alt="R&A Figure Logo" class="logo"></a>
        <nav>
            <div class="profile-icon">
                <a href="about.php">About us</a>
                <a href="DaftarProduk.php">Products</a>
                <a href="cek_profil.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
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
    <input type="text" placeholder="Search products..." id="searchInput">
    <button onclick="searchProducts()">Search</button>
    <select id="categoryFilter">
      <option value="">All Categories</option>
      <option value="Nendoroid">Nendoroid</option>
      <option value="Figma">Figma</option>
      <option value="1/7">Scale 1/7</option>
      <option value="1/6">Scale 1/6</option>
    </select>
  </div>

  <div class="banner-section">
    <h2>Figure Categories</h2>
    <div class="banner-grid">
      <a href="DaftarProduk.php?categories[]=Nendoroid" class="banner-item">
        <img src="img/sample product/banner/ねんどろいど.png" alt="Nendoroid">
        <div class="banner-overlay">
          <h3>Nendoroid</h3>
          <p>Cute chibi figures</p>
        </div>
      </a>
      <a href="DaftarProduk.php?categories[]=Figma" class="banner-item">
        <img src="img/sample product/banner/figma.png" alt="Figma">
        <div class="banner-overlay">
          <h3>Figma</h3>
          <p>Poseable action figures</p>
        </div>
      </a>
      <a href="DaftarProduk.php?categories[]=1/7" class="banner-item">
        <img src="img/sample product/banner/17.png" alt="Scale 1/7">
        <div class="banner-overlay">
          <h3>Scale 1/7</h3>
          <p>Detailed scale figures</p>
        </div>
      </a>
      <a href="DaftarProduk.php?categories[]=1/6" class="banner-item">
        <img src="img/sample product/banner/18.png" alt="Scale 1/8-1/6">
        <div class="banner-overlay">
          <h3>Scale 1/6</h3>
          <p>Premium large figures</p>
        </div>
      </a>
    </div>
  </div>

  <div class="product-section">
    <h2>Latest Products</h2>
    <div class="product-grid">
      <?php if (mysqli_num_rows($result_produk) > 0): ?>
        <?php while ($produk = mysqli_fetch_assoc($result_produk)): ?>
          <div class="product-card">
            <a href="produk.php?id_produk=<?= $produk['id_produk'] ?>" >
              <?php if (!empty($produk['gambar'])): ?>
                <img src="gambar_produk/<?php echo $produk['gambar']; ?>" alt="<?php echo $produk['nama_produk']; ?>">
              <?php else: ?>
                <img src="img/no-image.jpg" alt="No Image">
              <?php endif; ?>
              <h3><?php echo $produk['nama_produk']; ?></h3>
              <div class="price">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
              <div class="category"><?php echo $produk['kategori']; ?></div>
            </a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="no-products">
          <h3>No products available</h3>
          <p>Please check back later</p>
        </div>
      <?php endif; ?>
    </div>
    
    <div class="see-more">
      <button onclick="window.location.href='DaftarProduk.php'">See More Products</button>
    </div>
  </div>

  <script>
    const carousel = document.getElementById('carousel');
    const prev = document.querySelector('.carousel-button.prev');
    const next = document.querySelector('.carousel-button.next');

    let index = 0;

    // function updateCarousel() {
    //   carousel.style.transform = translateX(-${index * 100}%);
    // }

    prev.addEventListener('click', () => {
      index = (index - 1 + carousel.children.length) % carousel.children.length;
      updateCarousel();
    });

    next.addEventListener('click', () => {
      index = (index + 1) % carousel.children.length;
      updateCarousel();
    });

    // Auto-slide carousel
    setInterval(() => {
      index = (index + 1) % carousel.children.length;
      updateCarousel();
    }, 5000);

    // Search function
    function searchProducts() {
      const searchTerm = document.getElementById('searchInput').value;
      const category = document.getElementById('categoryFilter').value;
      
      let url = 'DaftarProduk.php?';
      if (searchTerm) {
        url += 'search=' + encodeURIComponent(searchTerm) + '&';
      }
      if (category) {
        url += 'categories[]=' + encodeURIComponent(category);
      }
      
      window.location.href = url;
    }

    // Enable search on Enter key
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        searchProducts();
      }
    });
  </script>
</body>
</html>