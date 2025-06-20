<?php
session_start();

if ($_SESSION['role'] === 'admin') {
    header("location: admin.php");
    exit();
} elseif ($_SESSION['role'] === 'user') {
    header("location: user.php");
    exit();
} else {
    header("location: login1.php?=SilahkanLoginDulu");
}

?>