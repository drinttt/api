<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');

$conn = new mysqli('localhost', 'root', '', 'omr');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username_ad'];
$password = $data['password_ad'];

// ตรวจสอบในตาราง user ก่อน
$sql = "SELECT * FROM admin WHERE username_ad = '$username' AND password_ad = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(['success' => true, 'message' => 'User login successful', 'type' => 'admin']);
} else {
    // ถ้าไม่พบในตาราง user ตรวจสอบในตาราง admin
    // $sql = "SELECT * FROM admin WHERE username_ad = '$username' AND password_ad = '$password'";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     echo json_encode(['success' => true, 'message' => 'Admin login successful', 'type' => 'admin']);
    // } else {
        echo json_encode(['success' => false, 'message' => 'Login failed']);
    // }
}

$conn->close();
?>
