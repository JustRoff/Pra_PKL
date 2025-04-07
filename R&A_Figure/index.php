<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="dashboard.php">P</a><br>

    <a href="logout.php" onclick="return confirm('Apakah admin <?= $_SESSION['admin'] ?> ingin logout?')">
    <button>Logout</button>
</a>
<br><br>
<a href="produk.php"><button>Produk</button></a>

</body>
</html>