<?php
include "koneksi.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="css_admin.css">
</head>
<body>
    <h2>Tambah Produk</h2>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <form method="post">
        <input type="text" name="name" placeholder="Nama Produk" required><br>
        <input type="text" name="price" placeholder="Harga" required><br>
        <textarea name="description" placeholder="Deskripsi" required></textarea><br>
        <button type="submit">Tambah</button>
    </form>
</body>
</html>
