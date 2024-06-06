<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "omr";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($data->id_exam) && !empty($data->no_answer_key) && !empty($data->answer_key)) {
    $query = "INSERT INTO exam_answer_key (id_exam, no_answer_key, answer_key) VALUES ('".$data->id_exam."', '".$data->no_answer_key."', '".$data->answer_key."')";

    if ($conn->query($query) === TRUE) {
        echo json_encode(array('success' => true, 'message' => 'Data Imported Successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => "Data Import Failed: " . $conn->error));
    }
} else {
    echo "<script>alert('Incomplete Data');</script>";
    echo json_encode(array('success' => false, 'message' => 'Incomplete Data'));
}

$conn->close();
?>
