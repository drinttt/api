<?php
header("Access-Control-Allow-Origin: *");
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "omr";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name_subject = $_POST['name_subject'];
$id_subject = $_POST['id_subject'];
$year = $_POST['year'];
$term = $_POST['term'];

$username = $_GET['username'];

$code_subject = substr(uniqid(), -6);

$sql = "INSERT INTO subject (code_subject, username, id_subject, name_subject, year, term) VALUES ('$code_subject', '$username','$id_subject', '$name_subject', '$year', $term)";

if ($conn->query($sql) === TRUE) {
  $response = array("success" => true, "message" => "Subject created successfully");
  echo json_encode($response);
} else {
  $response = array("success" => false, "message" => "Error creating subject: " . $conn->error);
  echo json_encode($response);
}

$conn->close();
?>
