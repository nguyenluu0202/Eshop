<?php
session_start(); // Bắt đầu session

// Xóa tất cả session
session_unset(); 
session_destroy(); 

// Chuyển hướng về trang login
header("Location: register_login.php");
exit();
?>
