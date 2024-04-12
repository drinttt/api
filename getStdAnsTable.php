<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "omr"; 

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าพารามิเตอร์จาก URL
$id_exam = isset($_GET['id_exam']) ? $_GET['id_exam'] : '';
$id_student = isset($_GET['id_student']) ? $_GET['id_student'] : '';

// สร้างคำสั่ง SQL และดึงข้อมูล
$sql = "SELECT * FROM student s JOIN student_answer sa ON s.id_exam = sa.id_exam AND s.id_student = sa.id_student WHERE s.id_exam = ? AND s.id_student = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id_exam, $id_student);

$stmt->execute();
$result = $stmt->get_result();

$answers = array();
while($row = $result->fetch_assoc()) {
    $answers[] = $row;
}

// แปลงข้อมูลเป็น JSON และส่งกลับ
echo json_encode($answers);

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>
