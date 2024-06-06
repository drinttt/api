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

    // เริ่ม Transaction
    $conn->begin_transaction();

    // ลบข้อมูลในตาราง student_answer
    $sql_delete_student_answer = "DELETE FROM student_answer WHERE id_exam = ?";
    $stmt_delete_student_answer = $conn->prepare($sql_delete_student_answer);
    $stmt_delete_student_answer->bind_param("s", $data->id_exam);

    // ลบข้อมูลในตาราง exam_answer_key
    $sql_delete_exam_answer_key = "DELETE FROM exam_answer_key WHERE id_exam = ?";
    $stmt_delete_exam_answer_key = $conn->prepare($sql_delete_exam_answer_key);
    $stmt_delete_exam_answer_key->bind_param("s", $data->id_exam);

    // ลบข้อมูลในตาราง student
    $sql_delete_student = "DELETE FROM student WHERE id_exam = ?";
    $stmt_delete_student = $conn->prepare($sql_delete_student);
    $stmt_delete_student->bind_param("s", $data->id_exam);

    // ลบข้อมูลในตาราง exam
    $sql_delete_exam = "DELETE FROM exam WHERE id_exam = ?";
    $stmt_delete_exam = $conn->prepare($sql_delete_exam);
    $stmt_delete_exam->bind_param("s", $data->id_exam);

    $success = true;

    // ทำการลบข้อมูลตามลำดับ
    if ($stmt_delete_student_answer->execute() && $stmt_delete_exam_answer_key->execute() && $stmt_delete_student->execute() && $stmt_delete_exam->execute()) {
        $conn->commit();
        echo json_encode(array("message" => "Data deleted successfully."));
    } else {
        $conn->rollback();
        echo json_encode(array("message" => "Error deleting data."));
    }

    // ปิดคำสั่ง SQL
    $stmt_delete_student_answer->close();
    $stmt_delete_exam_answer_key->close();
    $stmt_delete_student->close();
    $stmt_delete_exam->close();

    $conn->close();
} else {
    echo json_encode(array("message" => "Data is incomplete."));
}

?>
