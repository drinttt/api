<?php
// header("Access-Control-Allow-Origin: *");
// // ทำการเชื่อมต่อฐานข้อมูล
// $servername = "localhost";
// $username = "root"; // ชื่อผู้ใช้ของฐานข้อมูล
// $password = ""; // รหัสผ่านของฐานข้อมูล
// $dbname = "omr"; // ชื่อฐานข้อมูล

// // สร้างการเชื่อมต่อ
// $conn = new mysqli($servername, $username, $password, $dbname);

// // ตรวจสอบการเชื่อมต่อ
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }

// // รับค่า exam จากข้อมูลที่ส่งมา
// $code_subject = $_POST['code_subject'];
// $name_exam = $_POST['name_exam'];
// $qty_exam = $_POST['qty_exam'];
// // $points = $_POST['points'];

// // สร้าง ID ใหม่โดยใช้ uniqid() และ substr() เพื่อเลือกเพียงส่วนที่ต้องการ
// $id_exam = substr(uniqid(), -6);

// // เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง exam
// // $sql = "INSERT INTO exam (id_exam, name_exam, code_subject, qty_exam, points) VALUES ('$id_exam', '$name_exam', '$code_subject', $qty_exam, $points)";
// $sql = "INSERT INTO exam (id_exam, name_exam, code_subject, qty_exam) VALUES ('$id_exam', '$name_exam', '$code_subject', $qty_exam)";

// if ($conn->query($sql) === TRUE) {
//   $response = array("success" => true, "message" => "Exam created successfully");
//   echo json_encode($response);
// } else {
//   $response = array("success" => false, "message" => "Error creating exam: " . $conn->error);
//   echo json_encode($response);
// }

// // ปิดการเชื่อมต่อฐานข้อมูล
// $conn->close();

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

// รับค่า exam จากข้อมูลที่ส่งมา
$code_subject = $_POST['code_subject'];
$name_exam = $_POST['name_exam'];
$qty_exam = $_POST['qty_exam'];
// $points = $_POST['points'];

// สร้าง ID ใหม่โดยใช้ uniqid() และ substr() เพื่อเลือกเพียงส่วนที่ต้องการ
$id_exam = substr(uniqid(), -6);

// เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง exam
// $sql = "INSERT INTO exam (id_exam, name_exam, code_subject, qty_exam, points) VALUES ('$id_exam', '$name_exam', '$code_subject', $qty_exam, $points)";
$sql = "INSERT INTO exam (id_exam, name_exam, code_subject, qty_exam) VALUES ('$id_exam', '$name_exam', '$code_subject', $qty_exam)";

if ($conn->query($sql) === TRUE) {
  $response = array("success" => true, "message" => "Exam created successfully");
  echo json_encode($response);
} else {
  $response = array("success" => false, "message" => "Error creating exam: " . $conn->error);
  echo json_encode($response);
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

?>
