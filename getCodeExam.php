<?php
header("Access-Control-Allow-Origin: *"); // อนุญาตให้โดเมนอื่นเรียกใช้งาน API

$servername = "localhost";
$username_db = "root"; // ชื่อผู้ใช้ของฐานข้อมูล
$password_db = ""; // รหัสผ่านของฐานข้อมูล
$dbname = "omr"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่า username จาก parameter ของ GET request
$username = $_GET['username'];

// สร้างคำสั่ง SQL สำหรับการดึง exam.id_exam, exam.name_exam, และ subject.name_subject จากตาราง exam และ subject
$sql = "SELECT exam.id_exam, exam.name_exam, subject.name_subject 
        FROM exam 
        JOIN subject ON exam.code_subject = subject.code_subject
        WHERE username = ?";

// เตรียมคำสั่ง SQL สำหรับการทำงานโดยใช้ prepared statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username); // "s" หมายถึง string
$stmt->execute();

// ดึงผลลัพธ์
$result = $stmt->get_result();

$subjects = array(); // เก็บข้อมูล subject ทั้งหมดในรูปแบบของ Array

if ($result->num_rows > 0) {
    // วนลูปผ่านผลลัพธ์และเพิ่มข้อมูล subject เข้าไปใน Array
    while($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}

// แปลง Array เป็นรูปแบบ JSON และส่งออก
echo json_encode($subjects);

// ปิดคำสั่ง SQL
$stmt->close();

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
