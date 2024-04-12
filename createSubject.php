<?php
header("Access-Control-Allow-Origin: *");
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

// รับค่า subject จากข้อมูลที่ส่งมา
$name_subject = $_POST['name_subject'];
$id_subject = $_POST['id_subject'];
$year = $_POST['year'];
$term = $_POST['term'];

$username = $_GET['username'];

// สร้าง ID ใหม่โดยใช้ uniqid() และ substr() เพื่อเลือกเพียงส่วนที่ต้องการ
$code_subject = substr(uniqid(), -6);

// เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง subject
// $sql = "INSERT INTO exam (id_exam, name_exam, code_subject, qty_exam, points) VALUES ('$id_exam', '$name_exam', '$code_subject', $qty_exam, $points)";
$sql = "INSERT INTO subject (code_subject, username, id_subject, name_subject, year, term) VALUES ('$code_subject', '$username','$id_subject', '$name_subject', '$year', $term)";

if ($conn->query($sql) === TRUE) {
  $response = array("success" => true, "message" => "Subject created successfully");
  echo json_encode($response);
} else {
  $response = array("success" => false, "message" => "Error creating subject: " . $conn->error);
  echo json_encode($response);
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
