<?php
header("Access-Control-Allow-Origin: *");

$servername = "localhost";
$username_db = "root"; 
$password_db = ""; 
$dbname = "omr"; 

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_GET['username'];

$sql = "SELECT exam.id_exam, exam.name_exam, subject.name_subject 
        FROM exam 
        JOIN subject ON exam.code_subject = subject.code_subject
        WHERE username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

$subjects = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}

echo json_encode($subjects);

$stmt->close();

$conn->close();
?>
