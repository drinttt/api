<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Example MySQL database connection
$servername = "localhost";
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "omr"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_exam = $_GET['id_exam']; // รับ id_exam จาก query string
// var_dump($id_exam);

// ใช้ prepared statement เพื่อป้องกัน SQL Injection3
$sql = "SELECT * FROM exam WHERE id_exam = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_exam); // "s" หมายถึง string
$stmt->execute();
$result = $stmt->get_result();

$exams = []; // สร้าง array สำหรับเก็บข้อมูลวิชาทั้งหมด


if ($result->num_rows > 0) {
    // วนลูปผ่านผลลัพธ์ทั้งหมดและเก็บเข้าไปใน array
    while($row = $result->fetch_assoc()) {
        array_push($exams, $row);
    }
    echo json_encode($exams); // ส่งข้อมูลวิชาทั้งหมดกลับเป็น JSON
} else {
    echo json_encode(['message' => 'No exams found for this user.']);
}

$stmt->close();
$conn->close();
// header("Content-Type: application/json");
// header("Access-Control-Allow-Origin: *");

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "omr";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $id_exam = isset($_GET['id_exam']) ? $_GET['id_exam'] : '';

// if (!empty($id_exam)) {
//     $stmt = $conn->prepare("SELECT * FROM exam WHERE id_exam = ?");
//     $stmt->bind_param("i", $id_exam);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $exam = $result->fetch_assoc();
//     echo json_encode($exam);
// } else {
//     echo json_encode(["error" => "No ID provided"]);
// }

// $conn->close();
// ?>
