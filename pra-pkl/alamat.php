<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi User - Indonesia Only</title>
    <link rel="stylesheet" href="css/alamat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
</head>
<body>
    <header>
        <img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" >
        <nav>
            <div class="profile-icon">    
                <a href="DaftarProduk.php">Products</a>
                <a href="keranjang.php">Cart</a>
                <a href="cek_profil.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <a href="transaksi.php" class="btn-kembali">← Kembali ke Keranjang</a>
        <h1>Tambah Lokasi</h1>
        
        <form method="POST" action="proses_alamat.php">
            <label for="">Nama alamat</label>
            <input type="text" name="nama_alamat" id="" required>        
            <!-- Search Location -->
            <label for="locationSearch">Cari Patokan Terdekat di Indonesia:</label>
            <div class="search-container">
                <input type="text" id="locationSearch">
                <div class="search-results" id="searchResults"></div>
            </div>
                    
            <!-- Coordinate Display -->
            <div class="coordinates-display" id="coordinatesDisplay">
                <strong>Koordinat Terpilih (Indonesia):</strong><br>
                Latitude: <span id="displayLat">Belum dipilih</span><br>
                Longitude: <span id="displayLng">Belum dipilih</span><br>
                <small>Pulu: <span id="displayProvince">-</span></small>
            </div>
            
            <!-- Hidden inputs for form submission -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            
            <div class="button-group">
                <button type="button" onclick="getCurrentLocation()">Gunakan Lokasi Saya</button>
                <button type="button" class="google-maps-btn" onclick="openGoogleMaps()" id="googleMapsBtn" disabled>
                    Buka di Google Maps
                </button>
                <button type="button" onclick="clearLocation()">Bersihkan</button>
            </div>
            
            <!-- Interactive Map -->
            <div class="map-container">
                <div id="map"></div>
            </div>

            <label for="">Deskripsi</label>
            <input type="text" name="deskripsi" id="" placeholder="Max 225 char" max="225" required>
            
            <input type="submit" value="Simpan Lokasi">
        </form>
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

    <!-- Leaflet JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script src="script/alamat.js?<?=time() ?>"></script>

</body>
</html>