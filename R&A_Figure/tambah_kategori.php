<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?AndaBukanAdmin");
    exit;
}

$sql_kategori = "SELECT * FROM kategori";
$query_kategori = mysqli_query($koneksi,$sql_kategori);

$sql_manufacturer = "SELECT * FROM manufacturer";
$query_manufacturer = mysqli_query($koneksi,$sql_manufacturer);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: none;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
        }

        .modal h2 {
            margin-top: 0;
            color: #333;
        }

        .modal .form-group {
            margin-bottom: 15px;
        }

        .modal label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .modal input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .modal button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-save {
            background-color: #28a745;
            color: white;
        }

        .btn-save:hover {
            background-color: #218838;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <header>
        <a href="homepage.php"><img src="img/logo/logo.png" alt="R&A Logo" srcset="" class="logo" ></a>
        <nav>
            <div class="profile-icon">    
                <a href="dashboard.php">Add Product</a>
                <a href="Daftarkategori.php">Products</a>
                <a href="admin.php"><img src="img/user/user.png" alt="Profile Icon" class="profile"></a>
            </div>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h1>Table kategori</h1>
            <form action="tambahkategori.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="" placeholder="nama kategori">
                </div>
                <button type="submit">Tambah</button>
            </form>
        </div>

        <div class="form-container">
            <h1>Table Manufacturer</h1>
            <form action="tambahmanufacturer.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Nama Manufacturer</label>
                    <input type="text" name="nama_manufacturer" id="" placeholder="nama manufacturer">
                </div>
                <button type="submit">Tambah</button>
            </form>
        </div>

        <br>

        <table border="1">
            <tr>
                <th>ID Kategori</th>
                <th>Nama kategori</th>
                <th>Aksi</th>
            </tr>

        <?php while($kategori=mysqli_fetch_assoc($query_kategori)) { ?>
        <tr>
            <td><?=$kategori['id_kategori']?></td>
            <td><?=$kategori['nama_kategori']?></td>
            <td>
                <a href="hapuskategori.php?id_kategori=<?=$kategori['id_kategori']?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')"><button class="delete">Hapus</button></a>
                <button class="edit" onclick="openEditModal('kategori', '<?=$kategori['id_kategori']?>', '<?=$kategori['nama_kategori']?>')">Edit</button>
            </td>
        </tr>
        <?php } ?>
        </table> 

        <table border="1">
            <tr>
                <th>ID Manufacturer</th>
                <th>Nama Manufacturer</th>
                <th>Aksi</th>
            </tr>

        <?php 
        // Reset query manufacturer
        $sql_manufacturer = "SELECT * FROM manufacturer";
        $query_manufacturer = mysqli_query($koneksi,$sql_manufacturer);
        while($manufacturer=mysqli_fetch_assoc($query_manufacturer)) { ?>
        <tr>
            <td><?=$manufacturer['id_manufacturer']?></td>
            <td><?=$manufacturer['nama_manufacturer']?></td>
            <td>
                <a href="hapusmanufacturer.php?id_manufacturer=<?=$manufacturer['id_manufacturer']?>" onclick="return confirm('Apakah Anda yakin ingin menghapus manufacturer ini?')"><button class="delete">Hapus</button></a>
                <button class="edit" onclick="openEditModal('manufacturer', '<?=$manufacturer['id_manufacturer']?>', '<?=$manufacturer['nama_manufacturer']?>')">Edit</button>
            </td>
        </tr>
        <?php } ?>
        </table> 
    </main>

    <!-- Modal Edit -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Edit</h2>
            <form id="editForm" method="POST">
                <div class="form-group">
                    <label for="editName" id="labelName">Nama</label>
                    <input type="text" id="editName" name="nama" required>
                    <input type="hidden" id="editId" name="id">
                    <input type="hidden" id="editType" name="type">
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>

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
        // Modal functionality
        const modal = document.getElementById('editModal');
        const closeBtn = document.querySelector('.close');

        function openEditModal(type, id, name) {
            const modalTitle = document.getElementById('modalTitle');
            const labelName = document.getElementById('labelName');
            const editName = document.getElementById('editName');
            const editId = document.getElementById('editId');
            const editType = document.getElementById('editType');
            const editForm = document.getElementById('editForm');

            // Set modal content based on type
            if (type === 'kategori') {
                modalTitle.textContent = 'Edit Kategori';
                labelName.textContent = 'Nama Kategori';
                editForm.action = 'editkategori.php';
            } else if (type === 'manufacturer') {
                modalTitle.textContent = 'Edit Manufacturer';
                labelName.textContent = 'Nama Manufacturer';
                editForm.action = 'editmanufacturer.php';
            }

            // Set form values
            editName.value = name;
            editId.value = id;
            editType.value = type;

            // Show modal
            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        // Close modal when clicking the X
        closeBtn.onclick = closeModal;

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        }

    </script>

</body>
</html>