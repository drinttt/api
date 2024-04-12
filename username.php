<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Example MySQL database connection
$servername = "localhost";
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "omr"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_GET['username']; // รับ username จาก query string
// var_dump($username);

// ใช้ prepared statement เพื่อป้องกัน SQL Injection3
$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username); // "s" หมายถึง string
$stmt->execute();
$result = $stmt->get_result();

$users = []; // สร้าง array สำหรับเก็บข้อมูลวิชาทั้งหมด


if ($result->num_rows > 0) {
    // วนลูปผ่านผลลัพธ์ทั้งหมดและเก็บเข้าไปใน array
    while($row = $result->fetch_assoc()) {
        array_push($users, $row);
    }
    echo json_encode($users); // ส่งข้อมูลวิชาทั้งหมดกลับเป็น JSON
} else {
    echo json_encode(['message' => 'No users found for this user.']);
}

$stmt->close();
$conn->close();
?>
