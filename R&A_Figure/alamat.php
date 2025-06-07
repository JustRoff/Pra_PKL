<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi User - Indonesia Only</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
    
    <style>
        .map-container {
            width: 100%;
            height: 450px;
            margin: 20px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
        }
        form {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px 0;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        .btn-kembali {
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .btn-kembali:hover {
            background-color: #5a6268;
        }
        .google-maps-btn {
            background-color: #4285f4;
        }
        .google-maps-btn:hover {
            background-color: #3367d6;
        }
        .google-maps-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .info {
            background-color: #e7f3ff;
            border: 1px solid #bee5eb;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
        }
        .search-container {
            position: relative;
            margin-bottom: 15px;
        }
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 4px 4px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        .search-result-item {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .search-result-item:hover {
            background-color: #f5f5f5;
        }
        .search-result-item:last-child {
            border-bottom: none;
        }
        .coordinates-display {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            font-family: monospace;
        }
        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
        }
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        .map-instructions {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            font-size: 14px;
        }
        #map {
            height: 100%;
            width: 100%;
        }
        .bounds-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            color: #856404;
        }
    </style>
</head>
<body>
    <?php
    // Cek dari mana user datang
    $return_url = isset($_GET['return']) ? $_GET['return'] : 'index.php';
    ?>
    
    <!-- Tombol kembali dinamis -->
    <a href="<?php echo htmlspecialchars($return_url); ?>" class="btn-kembali">← Kembali</a>
    
    <h1>Tambah Lokasi</h1>
    
    <form method="POST" action="proses_alamat.php">
        <input type="hidden" name="return_url" value="<?php echo isset($_GET['return']) ? htmlspecialchars($_GET['return']) : ''; ?>">
        <!-- Hidden field untuk menyimpan return URL -->
        <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($return_url); ?>">
        
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
            <small>Pulau: <span id="displayProvince">-</span></small>
        </div>
        
        <!-- Hidden inputs for form submission -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="hidden" name="pulau" id="pulau">
        
        <div class="button-group">
            <button type="button" onclick="getCurrentLocation()">📍 Gunakan Lokasi Saya</button>
            <button type="button" class="google-maps-btn" onclick="openGoogleMaps()" id="googleMapsBtn" disabled>
                🗺️ Buka di Google Maps
            </button>
            <button type="button" onclick="clearLocation()">🗑️ Bersihkan</button>
        </div>
        
        <!-- Interactive Map -->
        <div class="map-container">
            <div id="map"></div>
        </div>

        <label for="">Deskripsi</label>
        <input type="text" name="deskripsi" id="" placeholder="Max 225 char" max="225" required>
        
        <input type="submit" value="💾 Simpan Lokasi">
    </form>

    <!-- Leaflet JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script src="script/alamat.js"></script>

</body>
</html>