<?php
include "koneksi.php";


$username = $_POST['username'];
$password = $_POST['password'];
$Date_Of_Birth = $_POST['Date_Of_Birth'];
$email = $_POST['email'];

$sql = "insert into users(username,password,Date_Of_Birth,email) values ('$username',md5('$password'),'$Date_Of_Birth','$email')";
$query = mysqli_query($koneksi,$sql);

if ($query) {
    header("location:login.php?Tambah=S");
    exit;
} else {
    header("location:login.php?Tambah=G");
    exit;
}
?>