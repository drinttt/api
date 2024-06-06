<?php
// เปิดใช้งานการแสดงข้อผิดพลาด
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// รับข้อมูลที่ส่งมาจากฟอร์มโดยตรง
$id_subject = $_POST['id_subject'] ?? '';
$name_subject = $_POST['name_subject'] ?? '';
$year = $_POST['year'] ?? '';
$term = $_POST['term'] ?? '';
$code_subject = $_POST['code_subject'] ?? '';

$host = "localhost";
$db_name = "omr";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($id_subject) && !empty($name_subject) && !empty($year) && !empty($term) && isset($code_subject)) {
        $query = "UPDATE subject SET id_subject = :id_subject, name_subject = :name_subject, year = :year, term = :term WHERE code_subject = :code_subject";
        $stmt = $conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":id_subject", $id_subject);
        $stmt->bindParam(":name_subject", $name_subject);
        $stmt->bindParam(":year", $year);
        $stmt->bindParam(":term", $term);
        $stmt->bindParam(":code_subject", $code_subject);

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
