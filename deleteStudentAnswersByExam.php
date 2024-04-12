<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Max-Age: 3600");
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id_exam)) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "omr";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM student_answer WHERE id_exam = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $data->id_exam);

        if ($stmt->execute()) {
            echo json_encode(array("message" => "Student answers deleted successfully."));
        } else {
            echo json_encode(array("message" => "Unable to delete student answers."));
        }
        $stmt->close();
    } else {
        echo json_encode(array("message" => "Unable to prepare the statement."));
    }

    $conn->close();
} else {
    echo json_encode(array("message" => "Data is incomplete."));
}
?>
