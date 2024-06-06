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

$code_subject = $_POST['code_subject'];
$name_exam = $_POST['name_exam'];
$qty_exam = $_POST['qty_exam'];

$id_exam = substr(uniqid(), -6);

$sql = "INSERT INTO exam (id_exam, name_exam, code_subject, qty_exam) VALUES ('$id_exam', '$name_exam', '$code_subject', $qty_exam)";

if ($conn->query($sql) === TRUE) {
  $response = array("success" => true, "message" => "Exam created successfully");
  echo json_encode($response);
} else {
  $response = array("success" => false, "message" => "Error creating exam: " . $conn->error);
  echo json_encode($response);
}

$conn->close();

?>
