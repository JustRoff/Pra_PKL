<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql_admin = "Select * from admin where username='$username' and password = md5('$password') ";
$query_admin = mysqli_query($koneksi,$sql_admin);

$sql_users = "Select * from users where username='$username' and password = md5('$password') ";
$query_users = mysqli_query($koneksi,$sql_users);

if (mysqli_num_rows($query_admin)) {
    $admin = mysqli_fetch_assoc($query_admin);
    $_SESSION['id_admin'] = $admin['id_admin'];
    header("location:index.php?Login=S");
    exit;
} elseif (mysqli_num_rows($query_users)) {
    $_SESSION['username'] = $username;
    header("location:index.php?Login=S");
    exit;
} else {
    header("Location:login.php?Login=G");
    exit;
}
?>