<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$sql = "SELECT produk.id_produk,
        produk.nama_produk,
        produk.kategori,
        produk.manufacturer,
        produk.tanggal_terbit,
        produk.harga,
        produk.stok,
        produk.rating,
        produk.gambar,
        admin.username AS nama
        from produk
        join admin on produk.id_admin=admin.id_admin";
$query =mysqli_query($koneksi,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wid_produkth=device-wid_produkth, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Table Produk</h1>
    <form action="tambahProduk.php" method="post" enctype="multipart/form-data">
        <label for="">Nama Produk</label>
        <input type="text" name="nama_produk" id=""><br>
        
        <label for="">Kategori</label>
        <select name="kategori" id="">
            <option value="" disabled selected>Pilih Kategori</option>
            <option value="Nendoroid">Nendoroid</option>
            <option value="Figma">Figma</option>
            <option value="1/12">1/12</option>
            <option value="1/8">1/8</option>
            <option value="1/7">1/7</option>
            <option value="1/6">1/6</option>
        </select><br>

        <label for="">manufacturer</label>
        <input type="text" name="manufacturer" id=""><br>
        
        <label for="">Tanggal Terbit</label>
        <input type="date" name="tanggal_terbit" id=""><br>
        
        <label for="">Harga</label>
        <input type="number" name="harga" id=""><br>

        <label for="">Stok</label>
        <input type="number" name="stok" id=""><br>
        
        <label for="">Rating</label>
        <input type="number" name="rating" id="" min="0" max="5"><br>

        <label for="">Gambar</label>
        <input type="file" name="gambar" id="gambarInput" onchange="previewGambar()" required><br><br>

        <img id="gambarPreview" src="" alt="Preview Gambar" width="200" style="display:none; border: 1px solid #ccc; padding:5px;"><br><br>

        <input type="submit" value="Tambah">
    </form><br>
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
            <th>Admin</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>

 <?php       while($produk=mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?=$produk['id_produk']?></td>
        <td><?=$produk['nama_produk']?></td>
        <td><?=$produk['kategori']?></td>
        <td><?=$produk['manufacturer']?></td>
        <td><?=$produk['tanggal_terbit']?></td>
        <td><?=number_format($produk['harga'],0,',','.')?></td>
        <td><?=$produk['stok']?></td>
        <td><?=$produk['rating']?></td>
        <td><?=$produk['nama']?></td>
        <td><img src="gambar_produk/<?=$produk['gambar']?>" alt="contoh" width="100"></td>
        <td>
            <a href="hapusProduk.php?id_produk=<?=$produk['id_produk']?>"onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a> |
            <a href="editProduk.php?id_produk=<?=$produk['id_produk']?>">Edit</a> 
        </td>
    </tr>
    <?php } ?>
    </table> <br>

    <a href="logout.php" onclick="return confirm('Apakah admin <?= $_SESSION['id_admin'] ?> ingin logout?')">
  <button>Logout</button>
</a>


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