<?php
// logout.php
session_start();
// Xóa toàn bộ dữ liệu session
$_SESSION = array();
session_destroy();
// Chuyển hướng về trang đăng nhập
header("location: login.php");
exit;
?>
