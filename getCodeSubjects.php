<?php
header("Access-Control-Allow-Origin: *"); // อนุญาตให้โดเมนอื่นเรียกใช้งาน API
// ตัวอย่างการเชื่อมต่อกับฐานข้อมูล MySQL
$servername = "localhost";
$username = "root"; // ชื่อผู้ใช้ของฐานข้อมูล
$password = ""; // รหัสผ่านของฐานข้อมูล
$dbname = "omr"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL สำหรับการดึง code_subject และ name_subject จากตาราง subject
$sql = "SELECT code_subject, name_subject FROM subject";

$result = $conn->query($sql);

$subjects = array(); // เก็บข้อมูล subject ทั้งหมดในรูปแบบของ Array

if ($result->num_rows > 0) {
    // วนลูปผ่านผลลัพธ์และเพิ่มข้อมูล subject เข้าไปใน Array
    while($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}

// แปลง Array เป็นรูปแบบ JSON และส่งออก
echo json_encode($subjects);

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
