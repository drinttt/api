<?php
header('Access-Control-Allow-Origin: *'); // อนุญาต CORS
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization'); // อนุญาตหัวข้อเหล่านี้
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // อนุญาตเมธอดที่คุณต้องการใช้


// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli('localhost', 'root', '', 'omr');

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่ารหัสวิชาจากการร้องขอ
$code_subject = $_GET['code_subject'];

// คำสั่ง SQL สำหรับค้นหาข้อมูลวิชาจากรหัสวิชา
$sql = "SELECT * FROM subjects WHERE code_subject = '$code_subject'";

// ประมวลผลคำสั่ง SQL
$result = $conn->query($sql);

// เตรียมข้อมูลเพื่อส่งกลับให้กับผู้ร้องขอ
$response = array();

if ($result->num_rows > 0) {
    // วนลูปเพื่อเก็บข้อมูลที่ได้จากฐานข้อมูล
    while($row = $result->fetch_assoc()) {
        // เพิ่มข้อมูลลงในอาร์เรย์เพื่อส่งกลับ
        $response[] = $row;
    }
} else {
    // ถ้าไม่พบข้อมูล
    $response['success'] = false;
    $response['message'] = 'Subject not found';
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();

// ส่งข้อมูลกลับให้กับผู้ร้องขอในรูปแบบ JSON
echo json_encode($response);

?>
