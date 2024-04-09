<?php
// ปรับค่าตามการเชื่อมต่อฐานข้อมูลของคุณ
$host = "localhost"; // หรือที่อยู่ IP ของเซิร์ฟเวอร์ฐานข้อมูล
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูล
$password = ""; // รหัสผ่านฐานข้อมูล
$dbname = "omr"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// อ่านค่า id_student จากคำขอ GET
$id_student = isset($_GET['id_student']) ? $_GET['id_student'] : '';

// คำสั่ง SQL เพื่อค้นหา st_name จากตาราง student โดยใช้ id_student
$sql = "SELECT id_student, st_name FROM student WHERE id_student = '".$id_student."'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // หากพบข้อมูล
    while($row = $result->fetch_assoc()) {
        // ส่งข้อมูลกลับเป็น JSON
        echo json_encode($row);
    }
} else {
    echo json_encode(array("message" => "No records found."));
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
