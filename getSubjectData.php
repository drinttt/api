<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // ปรับการตั้งค่านี้ตามนโยบาย CORS ของคุณ

// รับข้อมูล code_subject จาก query parameter
$code_subject = isset($_GET['code_subject']) ? $_GET['code_subject'] : '';

// สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = new mysqli('localhost', 'your_username', 'your_password', 'your_database');

// ตรวจสอบว่ามีข้อผิดพลาดในการเชื่อมต่อหรือไม่
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลวิชา
$sql = "SELECT * FROM subject WHERE code_subject = '".$conn->real_escape_string($code_subject)."'";

// ทำการ query ข้อมูล
$result = $conn->query($sql);

// ตรวจสอบว่าพบข้อมูลหรือไม่
if ($result->num_rows > 0) {
    // หากพบข้อมูล, ส่งข้อมูลวิชากลับเป็น JSON
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    // หากไม่พบข้อมูล, ส่งกลับข้อความแจ้งไม่พบข้อมูล
    echo json_encode(array("message" => "No subject found with the given code"));
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
