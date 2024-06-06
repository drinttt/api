<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// รับข้อมูลที่ส่งมาจากฟอร์มโดยตรง
$name_exam = $_POST['name_exam'] ?? '';
$qty_exam = $_POST['qty_exam'] ?? '';
$id_exam = $_POST['id_exam'] ?? '';

$host = "localhost";
$db_name = "omr";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($name_exam) && !empty($qty_exam) && isset($id_exam)) {
        $query = "UPDATE exam SET name_exam = :name_exam, qty_exam = :qty_exam WHERE id_exam = :id_exam";
        $stmt = $conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":name_exam", $name_exam);
        $stmt->bindParam(":qty_exam", $qty_exam);
        $stmt->bindParam(":id_exam", $id_exam);

        if ($stmt->execute()) {
            echo json_encode(array('success' => true, 'message' => 'Subject updated successfully.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update subject.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Incomplete Data.'));
    }
} catch(PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>
