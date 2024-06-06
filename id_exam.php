<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "omr"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_exam = $_GET['id_exam'];

$sql = "SELECT * FROM exam WHERE id_exam = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_exam); 
$stmt->execute();
$result = $stmt->get_result();

$exams = [];


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($exams, $row);
    }
    echo json_encode($exams);
} else {
    echo json_encode(['message' => 'No exams found for this user.']);
}

$stmt->close();
$conn->close();
?>
