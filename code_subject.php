<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'omr');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$code_subject = $_GET['code_subject']; // รับ code_subject จาก query string

// ใช้ prepared statement เพื่อป้องกัน SQL Injection
$stmt = $conn->prepare("SELECT * FROM subject WHERE code_subject = ?");
$stmt->bind_param("s", $code_subject); // "s" หมายถึง string
$stmt->execute();
$result = $stmt->get_result();

$subjects = []; // สร้าง array สำหรับเก็บข้อมูลวิชาทั้งหมด

if ($result->num_rows > 0) {
    // วนลูปผ่านผลลัพธ์ทั้งหมดและเก็บเข้าไปใน array
    while($row = $result->fetch_assoc()) {
        array_push($subjects, $row);
    }
    echo json_encode($subjects); // ส่งข้อมูลวิชาทั้งหมดกลับเป็น JSON
} else {
    echo json_encode(['message' => 'No subjects found for this user.']);
}

$stmt->close();
$conn->close();
?>
