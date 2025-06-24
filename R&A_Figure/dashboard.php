<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$sql = "SELECT produk.id_produk,
        produk.nama_produk,
        produk.tanggal_terbit,
        produk.harga,
        produk.stok,
        produk.rating,
        produk.gambar,
        produk.deskripsi,
        kategori.nama_kategori AS kategori,
        manufacturer.nama_manufacturer AS manufacturer,
        admin.username AS nama
        from produk
        join admin on produk.id_admin=admin.id_admin
        join kategori on produk.id_kategori=kategori.id_kategori
        join manufacturer on produk.id_manufacturer=manufacturer.id_manufacturer";
$query = mysqli_query($koneksi,$sql);

$sql_kategori = "SELECT * FROM kategori";
$query_kategori = mysqli_query($koneksi,$sql_kategori);

$sql_manufacturer = "SELECT * FROM manufacturer";
$query_manufacturer = mysqli_query($koneksi,$sql_manufacturer);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wid_produkth=device-wid_produkth, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/dashboard.css">
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
            <h1>Table Produk</h1>
            <form action="tambahProduk.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Nama Produk</label>
                    <input type="text" name="nama_produk" id="" placeholder="nama produk">
                </div>

                <div class="form-group">
                    <label for="">Kategori</label>
                    <select name="kategori" id="">
                        <option value="" disabled selected>Pilih Kategori</option>
                <?php while ($row = mysqli_fetch_assoc($query_kategori) ) {    ?>
                    <option value="<?=$row['id_kategori']?>"><?=$row['nama_kategori']?></option>
                <?php } ?>
                    </select>
                </div>
                    
                <div class="form-group">
                    <label for="">Manufacturer</label>
                    <select name="manufacturer" id="">
                        <option value="" disabled selected>Pilih manufactur</option>
                <?php while ($row1 = mysqli_fetch_assoc($query_manufacturer) ) {    ?>
                    <option value="<?=$row1['id_manufacturer']?>"><?=$row1['nama_manufacturer']?></option>
                <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit" id="">
                </div>

                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="number" name="harga" id="" placeholder="harga">
                </div>

                <div class="form-group">
                    <label for="">Stok</label>
                    <input type="number" name="stok" id="" placeholder="stok">
                </div>

                <div class="form-group">
                    <label for="">Rating</label>
                    <input type="number" name="rating" id="" min="0" max="5" placeholder="rating (max 5)">
                </div>

                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <textarea name="deskripsi" id="" cols="30" rows="10" placeholder="tulis deskripsi barang"></textarea>
                </div>

                <div class="form-group">
                    <label for="">Gambar</label>
                    <input type="file" name="gambar" id="gambarInput" onchange="previewGambar()" required>

                    <img id="gambarPreview" src="" alt="Preview Gambar" width="200" style="display:none; border: 1px solid #ccc; padding:5px;">
                </div>

                <button type="submit">Tambah</button>
                
            </form>
        </div>

        <br>

        <table border="1">
            <tr>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Manufacturer</th>
                <th>Tanggal Terbit</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Rating</th>
                <th>Deskripsi</th>
                <th>Admin</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>

        <?php while($produk=mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?=$produk['id_produk']?></td>
            <td><?=$produk['nama_produk']?></td>
            <td><?=$produk['kategori']?></td>
            <td><?=$produk['manufacturer']?></td>
            <td><?=$produk['tanggal_terbit']?></td>
            <td><?=number_format($produk['harga'],0,',','.')?></td>
            <td><?=$produk['stok']?></td>
            <td><?=$produk['rating']?></td>
            <td>
                <?php
                $deskripsi = strip_tags($produk['deskripsi']);
                if (strlen($deskripsi) > 100) {
                    echo substr($deskripsi, 0, 100) . '... ';
                    echo '<a href="produk.php?id_produk=' . $produk['id_produk'] . '">See more</a>';
                } else {
                    echo $deskripsi;
                }
                ?>
            </td>
            <td><?=$produk['nama']?></td>
            <td><img src="gambar_produk/<?=$produk['gambar']?>" alt="contoh" width="100"></td>
            <td>
                <a href="hapusProduk.php?id_produk=<?=$produk['id_produk']?>"onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"><button class="delete">Hapus</button></a>
                <a href="editProduk.php?id_produk=<?=$produk['id_produk']?>"><button class="edit">Edit</button></a>
            </td>
        </tr>
        <?php } ?>
        </table> 
        <!-- <a href="logout.php" onclick="return confirm('Apakah admin <?= $_SESSION['id_admin'] ?> ingin logout?')">
    <button>Logout</button>
    </a> -->
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

        reader.readAsDataURL(file); // Baca file dan ubah jadi URL base64
    }
}
</script>

</body>
</html>
