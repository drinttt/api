<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'omr';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_exam = isset($_GET['id_exam']) ? $_GET['id_exam'] : die();

$stmt = $conn->prepare("SELECT subject.*, exam.*, student.* FROM subject INNER JOIN exam ON subject.code_subject = exam.code_subject INNER JOIN student ON exam.id_exam = student.id_exam WHERE exam.id_exam = ?");
$stmt->bind_param("s", $id_exam);
$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
