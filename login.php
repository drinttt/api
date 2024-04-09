<?php

header('Access-Control-Allow-Origin: *'); // อนุญาต CORS
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization'); // อนุญาตหัวข้อเหล่านี้
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // อนุญาตเมธอดที่คุณต้องการใช้


$conn = new mysqli('localhost', 'root', '', 'omr');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password']; // ควรใช้การ hash และ/หรือ salt สำหรับ production

$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // พบผู้ใช้
    echo json_encode(['success' => true, 'message' => 'Login successful']);
} else {
    // ไม่พบผู้ใช้
    echo json_encode(['success' => false, 'message' => 'Login failed']);
}

$conn->close();
?>
