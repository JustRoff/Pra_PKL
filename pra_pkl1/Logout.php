<?php
session_start();
session_unset();
session_destroy();
header("location:login1.php?logout=sukses");
exit;
?>