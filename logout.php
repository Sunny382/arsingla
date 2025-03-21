<?php
session_start();
$redirect_url = "downloads.php"; 

if (isset($_SERVER['HTTP_REFERER'])) {
    $redirect_url = $_SERVER['HTTP_REFERER']; 
}

session_destroy();
header("Location: $redirect_url");
exit();
?>
