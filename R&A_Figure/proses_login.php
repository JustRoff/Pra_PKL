<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql_admin = "SELECT * FROM admin WHERE username = '$username' AND password = MD5('$password')";
$query_admin = mysqli_query($koneksi, $sql_admin);

$sql_users = "SELECT * FROM users WHERE username = '$username' AND password = MD5('$password')";
$query_users = mysqli_query($koneksi, $sql_users);

if (mysqli_num_rows($query_admin)) {
    $admin = mysqli_fetch_assoc($query_admin);
    $_SESSION['id_admin'] = $admin['id_admin'];
    $_SESSION['id_user'] = $admin['username'];
    header("Location: index.php?Login=S");
    exit;
}

elseif (mysqli_num_rows($query_users)) {
    $user = mysqli_fetch_assoc($query_users);
    $_SESSION['id_user'] = $user['id_user']; 
    $_SESSION['username'] = $user['username']; 
    header("Location: index.php?Login=S");
    exit;
}

else {
    header("Location: login.php?Login=G");
    exit;
}
?>
