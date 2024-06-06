<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// รับข้อมูล JSON ที่ส่งมา
$data = json_decode(file_get_contents("php://input"));

$host = "localhost";
$db_name = "omr";
$username = "root";
$password = ""; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($data->id_exam) && !empty($data->id_student) && isset($data->total_score)) {
        $query = "UPDATE student SET total_score = :total_score WHERE id_exam = :id_exam AND id_student = :id_student";
        $stmt = $conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":total_score", $data->total_score);
        $stmt->bindParam(":id_exam", $data->id_exam);
        $stmt->bindParam(":id_student", $data->id_student);

        if ($stmt->execute()) {
            echo json_encode(array('success' => true, 'message' => 'Score updated successfully.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update score.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Incomplete Data.'));
    }

} catch(PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>
