<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Max-Age: 3600");
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->code_subject)) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "omr";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->begin_transaction();

    // ลบข้อมูลในตาราง exam
    $sql_delete_exam = "DELETE FROM exam WHERE code_subject = ?";
    $stmt_delete_exam = $conn->prepare($sql_delete_exam);
    $stmt_delete_exam->bind_param("s", $data->code_subject);

    // ลบข้อมูลในตาราง exam_answer_key, student_answer, และ student ที่เป็นลูกของ exam
    $sql_delete_exam_data = "DELETE exam_answer_key, student_answer, student
                            FROM exam
                            LEFT JOIN exam_answer_key ON exam.id_exam = exam_answer_key.id_exam
                            LEFT JOIN student_answer ON exam.id_exam = student_answer.id_exam
                            LEFT JOIN student ON exam.id_exam = student.id_exam
                            WHERE exam.code_subject = ?";
    $stmt_delete_exam_data = $conn->prepare($sql_delete_exam_data);
    $stmt_delete_exam_data->bind_param("s", $data->code_subject);

    // ลบข้อมูลในตาราง subject
    $sql_delete_subject = "DELETE FROM subject WHERE code_subject = ?";
    $stmt_delete_subject = $conn->prepare($sql_delete_subject);
    $stmt_delete_subject->bind_param("s", $data->code_subject);

    $success = true;

    // ทำการลบข้อมูลตามลำดับ
    if ($stmt_delete_exam_data->execute() && $stmt_delete_exam->execute() && $stmt_delete_subject->execute()) {
        $conn->commit();
        echo json_encode(array("message" => "Data deleted successfully."));
    } else {
        $conn->rollback();
        echo json_encode(array("message" => "Error deleting data."));
    }

    // ปิดคำสั่ง SQL
    $stmt_delete_exam_data->close();
    $stmt_delete_exam->close();
    $stmt_delete_subject->close();

    $conn->close();
} else {
    echo json_encode(array("message" => "Data is incomplete."));
}
?>
