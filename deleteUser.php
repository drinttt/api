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

    // เริ่ม Transaction
    $conn->begin_transaction();

    // ลบข้อมูลในตาราง exam_answer_key, student_answer, และ student ที่เป็นลูกของตาราง exam
    $sql_delete_exam_data = "DELETE exam_answer_key, student_answer, student
                             FROM exam
                             LEFT JOIN exam_answer_key ON exam.id_exam = exam_answer_key.id_exam
                             LEFT JOIN student_answer ON exam.id_exam = student_answer.id_exam
                             LEFT JOIN student ON exam.id_exam = student.id_exam
                             WHERE exam.code_subject IN (SELECT code_subject FROM subject WHERE username = ?)";
    $stmt_delete_exam_data = $conn->prepare($sql_delete_exam_data);
    $stmt_delete_exam_data->bind_param("s", $data->username);
    $stmt_delete_exam_data->execute();
    $stmt_delete_exam_data->close();

    // ลบข้อมูลในตาราง exam
    $sql_delete_exam = "DELETE FROM exam WHERE code_subject IN (SELECT code_subject FROM subject WHERE username = ?)";
    $stmt_delete_exam = $conn->prepare($sql_delete_exam);
    $stmt_delete_exam->bind_param("s", $data->username);
    $stmt_delete_exam->execute();
    $stmt_delete_exam->close();

    // ลบข้อมูลในตาราง subject
    $sql_delete_subject = "DELETE FROM subject WHERE username = ?";
    $stmt_delete_subject = $conn->prepare($sql_delete_subject);
    $stmt_delete_subject->bind_param("s", $data->username);
    $stmt_delete_subject->execute();
    $stmt_delete_subject->close();

    // ลบข้อมูลในตาราง user
    $sql_delete_user = "DELETE FROM user WHERE username = ?";
    $stmt_delete_user = $conn->prepare($sql_delete_user);
    $stmt_delete_user->bind_param("s", $data->username);
    $stmt_delete_user->execute();
    $stmt_delete_user->close();

    // Commit Transaction หลังจากทำการลบข้อมูลทั้งหมดเรียบร้อยแล้ว
    $conn->commit();
    echo json_encode(array("message" => "Data deleted successfully."));

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
} else {
    echo json_encode(array("message" => "Data is incomplete."));
}
?>
