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

$username = $_GET['username']; // รับ username จาก query string
// var_dump($username);

$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$users = [];


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($users, $row);
    }
    echo json_encode($users);
} else {
    echo json_encode(['message' => 'No users found for this user.']);
}

$stmt->close();
$conn->close();
?>
