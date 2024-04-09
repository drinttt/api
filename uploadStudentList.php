<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// รับข้อมูล JSON ที่ส่งมาจาก Vue
$data = json_decode(file_get_contents("php://input"));

// การเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; // ชื่อผู้ใช้ของฐานข้อมูล
$password = ""; // รหัสผ่านของฐานข้อมูล
$dbname = "omr"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($data->id_exam) && !empty($data->id_student) && !empty($data->st_name)) {
    // สร้าง Query สำหรับเพิ่มข้อมูลลงในฐานข้อมูล
    $query = "INSERT INTO student (id_exam, no_student, id_student, st_name, section) VALUES ('".$data->id_exam."', '".$data->no_student."', '".$data->id_student."', '".$data->st_name."', '".$data->section."')";

    // ประมวลผลคำสั่ง SQL
    if ($conn->query($query) === TRUE) {
        echo json_encode(array('success' => true, 'message' => 'Data Imported Successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => "Data Import Failed: " . $conn->error));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Incomplete Data'));
}

// ปิดการเชื่อมต่อ
$conn->close();
?>