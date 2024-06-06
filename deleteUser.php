<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->username)) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "omr";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->begin_transaction();

    $sql_delete_data = "DELETE user, subject, exam, exam_answer_key, student_answer, student
                        FROM user
                        LEFT JOIN subject ON user.username = subject.username
                        LEFT JOIN exam ON subject.code_subject = exam.code_subject
                        LEFT JOIN exam_answer_key ON exam.id_exam = exam_answer_key.id_exam
                        LEFT JOIN student_answer ON exam.id_exam = student_answer.id_exam
                        LEFT JOIN student ON exam.id_exam = student.id_exam
                        WHERE user.username = ?";
    $stmt_delete_data = $conn->prepare($sql_delete_data);
    $stmt_delete_data->bind_param("s", $data->username);

    $success = $stmt_delete_data->execute();

    if ($success) {
        $conn->commit();
        echo json_encode(array("message" => "Data deleted successfully."));
    } else {
        $conn->rollback();
        echo json_encode(array("message" => "Error deleting data."));
    }

    $stmt_delete_data->close();
    $conn->close();
} else {
    echo json_encode(array("message" => "Data is incomplete."));
}
?>
