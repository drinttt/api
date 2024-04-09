<?php
header("Access-Control-Allow-Origin: *"); // อนุญาตการร้องขอจากทุกต้นทาง
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // อนุญาตเมธอดที่ระบุ
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // อนุญาตส่วนหัวที่ระบุ

// ตรวจสอบว่าเป็นการร้องขอ OPTIONS หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // หากเป็นการร้องขอ OPTIONS, ให้ตอบกลับและหยุดการดำเนินการต่อ
    exit;
}
// ทำการเชื่อมต่อฐานข้อมูล
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

$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];

// เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง exam
$sql = "INSERT INTO user (username, password, name, surname, email) VALUES ('$username', '$password', '$name', '$surname', '$email')";

if ($conn->query($sql) === TRUE) {
  $response = array("success" => true, "message" => "successfully");
  echo json_encode($response);
} else {
  $response = array("success" => false, "message" => "Error" . $conn->error);
  echo json_encode($response);
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
