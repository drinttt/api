<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "omr";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];

$sql = "INSERT INTO user (username, password, name, surname, email) VALUES ('$username', '$password', '$name', '$surname', '$email')";

if ($conn->query($sql) === TRUE) {
  $response = array("success" => true, "message" => "successfully");
  echo json_encode($response);
} else {
  $response = array("success" => false, "message" => "Error" . $conn->error);
  echo json_encode($response);
}

$conn->close();
?>
