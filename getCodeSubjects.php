<?php
header("Access-Control-Allow-Origin: *");

$servername = "localhost";
$username = "root"; // ชื่อผู้ใช้ของฐานข้อมูล
$password = ""; // รหัสผ่านของฐานข้อมูล
$dbname = "omr"; // ชื่อฐานข้อมูล

// รับค่า username จาก HTTP GET Request
$userInput = isset($_GET['username']) ? $_GET['username'] : '';

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL โดยใช้ค่า userInput ที่ได้รับมา (ตรวจสอบให้แน่ใจว่าหลีกเลี่ยง SQL Injection)
$sql = "SELECT code_subject, name_subject FROM subject WHERE username = '".$conn->real_escape_string($userInput)."'";

$result = $conn->query($sql);

$subjects = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}

echo json_encode($subjects);

$conn->close();
?>
