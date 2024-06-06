<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


$code_subject = isset($_GET['code_subject']) ? $_GET['code_subject'] : '';

$conn = new mysqli('localhost', 'your_username', 'your_password', 'your_database');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM subject WHERE code_subject = '".$conn->real_escape_string($code_subject)."'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(array("message" => "No subject found with the given code"));
}

$conn->close();
?>
