<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'omr');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$code_subject = $_GET['code_subject'];

$stmt = $conn->prepare("SELECT * FROM subject WHERE code_subject = ?");
$stmt->bind_param("s", $code_subject); 
$stmt->execute();
$result = $stmt->get_result();

$subjects = []; 

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($subjects, $row);
    }
    echo json_encode($subjects);
} else {
    echo json_encode(['message' => 'No subjects found for this user.']);
}

$stmt->close();
$conn->close();
?>
