<?php

// header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "omr";

$userInput = isset($_GET['id_exam']) ? $_GET['id_exam'] : '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL โดยใช้ค่า userInput ที่ได้รับมา
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
