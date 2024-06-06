<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "omr"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_exam = isset($_GET['id_exam']) ? $_GET['id_exam'] : '';
$id_student = isset($_GET['id_student']) ? $_GET['id_student'] : '';

$sql = "SELECT * FROM student s JOIN student_answer sa ON s.id_exam = sa.id_exam AND s.id_student = sa.id_student WHERE s.id_exam = ? AND s.id_student = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id_exam, $id_student);

$stmt->execute();
$result = $stmt->get_result();

$answers = array();
while($row = $result->fetch_assoc()) {
    $answers[] = $row;
}

echo json_encode($answers);

$stmt->close();
$conn->close();
?>
