<?php
// เปิดใช้งานการแสดงข้อผิดพลาด
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

    if (!empty($data->username) && isset($data->name) && isset($data->surname) && isset($data->email) && isset($data->password)) {
        $query = "UPDATE user SET name = :name, surname = :surname, email = :email, password = :password WHERE username = :username";
        $stmt = $conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":name", $data->name);
        $stmt->bindParam(":surname", $data->surname);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":password", $data->password);
        $stmt->bindParam(":username", $data->username);

        if ($stmt->execute()) {
            echo json_encode(array('success' => true, 'message' => 'User data updated successfully.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update user data.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Incomplete Data.'));
    }

} catch(PDOException $exception) {
    echo json_encode(array('success' => false, 'message' => 'ERROR: ' . $exception->getMessage()));
}
?>
