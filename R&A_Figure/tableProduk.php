<?php
include "koneksi.php";
// session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location:login.php?Logindulu");
//     exit;
// }

$sql = "SELECT * from produk";
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
    <form action="tambahProduk.php" method="get">
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
        <input type="number" name="rating" id=""><br>

        <label for="">ID Admin</label>
        <select name="id_admin" id="">
            <option value="" disabled selected>Pilih Admin Yang Menambah</option>
            <option value="1">Rofi</option>
            <option value="2">Alip</option>
        </select><br><br>

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
            <th>ID Admin</th>
            <th>Aksi</th>
        </tr>

 <?php       while($produk=mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?=$produk['id_produk']?></td>
        <td><?=$produk['nama_produk']?></td>
        <td><?=$produk['kategori']?></td>
        <td><?=$produk['manufacturer']?></td>
        <td><?=$produk['tanggal_terbit']?></td>
        <td><?=$produk['harga']?></td>
        <td><?=$produk['stok']?></td>
        <td><?=$produk['rating']?></td>
        <td><?=$produk['id_admin']?></td>
        <td>
            <a href="hapusProduk.php?id_produk=<?=$produk['id_produk']?>"onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a> |
            <a href="editProduk.php?id_produk=<?=$produk['id_produk']?>">Edit</a> 
        </td>
    </tr>
    <?php } ?>
    </table> <br>

    <a href="logout.php"><button>logout</button></a>
</body>
</html>

