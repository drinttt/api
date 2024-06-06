<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "omr";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_student = isset($_GET['id_student']) ? $_GET['id_student'] : '';

$sql = "SELECT id_student, st_name FROM student WHERE id_student = '".$id_student."'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row);
    }
} else {
    echo json_encode(array("message" => "No records found."));
}

$conn->close();
?>
