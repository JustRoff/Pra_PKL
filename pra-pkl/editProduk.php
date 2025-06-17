<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$id_produk= $_GET['id_produk'];

$sql = "Select * from produk where id_produk='$id_produk' ";
$query = mysqli_query($koneksi,$sql);

while($produk=mysqli_fetch_assoc($query)) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="css/editProduk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <a href="homepage.php"><img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" ></a>
        <nav>
            <div class="profile-icon">    
                <a href="dashboard.php">Add Product</a>
                <a href="DaftarProduk.php">Products</a>
                <a href="admin.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h1>Form Edit</h1>
            <form action="Proses_editProduk.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
                    <input type="hidden" name="gambar_lama" value="<?= $produk['gambar'] ?>">
                </div>

                <div class="form-group">
                    <label for="">Nama Produk</label>
                    <input type="text" name="nama_produk" value="<?= $produk['nama_produk'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="">Kategori</label>
                    <select name="kategori" required>
                        <option value="" disabled <?= ($produk['kategori'] == '') ? 'selected' : '' ?>>Pilih Kategori</option>
                        <option value="Nendoroid" <?= ($produk['kategori'] == 'Nendoroid') ? 'selected' : '' ?>>Nendoroid</option>
                        <option value="Figma" <?= ($produk['kategori'] == 'Figma') ? 'selected' : '' ?>>Figma</option>
                        <option value="1/12" <?= ($produk['kategori'] == '1/12') ? 'selected' : '' ?>>1/12</option>
                        <option value="1/8" <?= ($produk['kategori'] == '1/8') ? 'selected' : '' ?>>1/8</option>
                        <option value="1/7" <?= ($produk['kategori'] == '1/7') ? 'selected' : '' ?>>1/7</option>
                        <option value="1/6" <?= ($produk['kategori'] == '1/6') ? 'selected' : '' ?>>1/6</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Manufacturer</label>
                    <input type="text" name="manufacturer" value="<?= $produk['manufacturer'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="">Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit" value="<?= $produk['tanggal_terbit'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="number" name="harga" value="<?= $produk['harga'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="">Stok</label>
                    <input type="number" name="stok" value="<?= $produk['stok'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="">Rating</label>
                    <input type="number" name="rating" value="<?= $produk['rating'] ?>" min="0" max="5" required>
                </div>

                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <textarea name="deskripsi" id="" cols="30" rows="10"><?= $produk['deskripsi'] ?></textarea>
                </div>

                <div class="form-group">
                    <label for="">Gambar Lama</label>
                    <img src="gambar_produk/<?= $produk['gambar'] ?>" width="200" alt="Gambar Lama">
                </div>

                <div class="form-group">
                    <label>Gambar Baru (jika ingin diganti)</label><br>
                    <input type="file" name="gambar" id="gambarInput" onchange="previewGambar()">

                    <img id="gambarPreview" src="" alt="Preview Gambar Baru" width="200" style="display:none; border: 1px solid #ccc; padding:5px;">
                </div>

                <button type="submit">Simpan</button>
            </form>
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
    function previewGambar() {
        const input = document.getElementById('gambarInput');
        const preview = document.getElementById('gambarPreview');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            }
            reader.readAsDataURL(file);
        }
    }
    </script>

</body>
</html>

<?php } ?>