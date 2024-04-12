<?php
// // ตั้งค่า header สำหรับการตอบกลับแบบ JSON
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *'); // ปรับให้เหมาะสมกับการตั้งค่า CORS ของคุณ

// // สร้างตัวแปรสำหรับข้อมูลการเชื่อมต่อฐานข้อมูล
// $host = 'localhost'; // หรือ IP ของเซิร์ฟเวอร์ฐานข้อมูลของคุณ
// $dbname = 'omr';
// $username = 'root';
// $password = '';

// // เชื่อมต่อฐานข้อมูล
// $conn = new mysqli($host, $username, $password, $dbname);

// // ตรวจสอบการเชื่อมต่อ
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // รับ ID ของการสอบจาก query string
// $id_exam = isset($_GET['id_exam']) ? $_GET['id_exam'] : '';

// // คำสั่ง SQL สำหรับดึงข้อมูลการสอบจาก ID
// $sql = "SELECT * FROM exam WHERE id_exam = '$id_exam'";

// // ประมวลผลคำสั่ง SQL
// $result = $conn->query($sql);

// // สร้างตัวแปร array สำหรับเก็บข้อมูลการสอบ
// $examData = array();

// // ตรวจสอบว่าพบข้อมูลหรือไม่
// if ($result->num_rows > 0) {
//     // วนลูปผ่านทุกแถวและเพิ่มข้อมูลลงใน array
//     while($row = $result->fetch_assoc()) {
//         $examData[] = $row;
//     }
//     echo json_encode($examData); // แปลงข้อมูลเป็น JSON และส่งกลับ
// } else {
//     echo json_encode(array('message' => 'No exam found with the given ID'));
// }

// // ปิดการเชื่อมต่อฐานข้อมูล
// $conn->close();

// header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root"; // ชื่อผู้ใช้ของฐานข้อมูล
$password = ""; // รหัสผ่านของฐานข้อมูล
$dbname = "omr"; // ชื่อฐานข้อมูล

// รับค่า username จาก HTTP GET Request
$userInput = isset($_GET['id_exam']) ? $_GET['id_exam'] : '';

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL โดยใช้ค่า userInput ที่ได้รับมา (ตรวจสอบให้แน่ใจว่าหลีกเลี่ยง SQL Injection)
$sql = "SELECT * FROM exam WHERE id_exam = '".$conn->real_escape_string($userInput)."'";

$result = $conn->query($sql);

$exams = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $exams[] = $row;
    }
}

echo json_encode($exams);

$conn->close();
?>
