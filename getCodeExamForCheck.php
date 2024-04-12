<?php
header("Access-Control-Allow-Origin: *"); // อนุญาตให้โดเมนอื่นเรียกใช้งาน API

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

// รับค่า username จาก parameter ของ GET request
$username = $_GET['username'];

// สร้างคำสั่ง SQL สำหรับการดึง id_exam และ code_subject โดยมีเงื่อนไขว่า id_exam ต้องพบในตาราง exam_answer_key และเชื่อมโยง code_subject จากตาราง subject
$sql = "SELECT DISTINCT e.id_exam, e.name_exam, s.name_subject 
        FROM exam e
        JOIN exam_answer_key eak ON e.id_exam = eak.id_exam
        JOIN subject s ON e.code_subject = s.code_subject
        WHERE s.username = ?";

// เตรียมคำสั่ง SQL สำหรับการทำงานโดยใช้ prepared statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username); // "s" หมายถึง string
$stmt->execute();

// ดึงผลลัพธ์
$result = $stmt->get_result();

$exams = array(); // เก็บข้อมูล exams ทั้งหมดในรูปแบบของ Array

if ($result->num_rows > 0) {
    // วนลูปผ่านผลลัพธ์และเพิ่มข้อมูล exams เข้าไปใน Array
    while($row = $result->fetch_assoc()) {
        $exams[] = $row;
    }
}

// แปลง Array เป็นรูปแบบ JSON และส่งออก
echo json_encode($exams);

// ปิดคำสั่ง SQL
$stmt->close();

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
