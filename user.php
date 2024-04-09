<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'omr');
$username = $_GET['username']; // รับ username จาก query string

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc(); // ดึงข้อมูลโปรไฟล์
    echo json_encode($profile);
} else {
    echo json_encode(['message' => 'Profile not found.']);
}

$conn->close();
?>
