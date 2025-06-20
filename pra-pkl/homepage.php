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
    <title>Homepage</title>
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <a href="homepage.php"><img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" ></a>
        <nav>
            <div class="profile-icon">    
                <a href="DaftarProduk.php">Products</a>
                <a href="about.php">About</a>
                <a href="cek_profil.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
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
            <a href="homepage.php">R&A Figure Store</a>
        </div>
    </footer>


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