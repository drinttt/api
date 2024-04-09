<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id_exam) && !empty($data->id_student) && isset($data->no_student_answer) && isset($data->student_answer)) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "omr";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE student_answer SET student_answer = ? WHERE id_exam = ? AND id_student = ? AND no_student_answer = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $data->student_answer, $data->id_exam, $data->id_student, $data->no_student_answer);

        if ($stmt->execute()) {
            echo json_encode(array("message" => "Student answer was updated successfully."));
        } else {
            echo json_encode(array("message" => "Unable to update student answer."));
        }
        $stmt->close();
    } else {
        echo json_encode(array("message" => "Unable to prepare the statement."));
    }

    $conn->close();
} else {
    echo json_encode(array("message" => "Incomplete data."));
}
?>
