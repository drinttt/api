<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// รับข้อมูล JSON ที่ส่งมาจาก Vue
$data = json_decode(file_get_contents("php://input"));

// การเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "omr"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($data->id_exam) && !empty($data->id_student) && !empty($data->st_name)) {

    $query = "INSERT INTO student (id_exam, no_student, id_student, st_name) VALUES ('".$data->id_exam."', '".$data->no_student."', '".$data->id_student."', '".$data->st_name."')";

    if ($conn->query($query) === TRUE) {
        echo json_encode(array('success' => true, 'message' => 'Data Imported Successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => "Data Import Failed: " . $conn->error));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Incomplete Data'));
}

$conn->close();
?>