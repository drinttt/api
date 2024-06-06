<?php
header("Access-Control-Allow-Origin: *");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omr";

$userInput = isset($_GET['username']) ? $_GET['username'] : '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT code_subject, name_subject FROM subject WHERE username = '".$conn->real_escape_string($userInput)."'";

$result = $conn->query($sql);

$subjects = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}

echo json_encode($subjects);

$conn->close();
?>
