<?php
// config.php
$servername = "localhost";
$db_username = "root";
$db_password = "456123";
$dbname = "hocbong";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
