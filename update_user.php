<?php
// เปิดใช้งานการแสดงข้อผิดพลาด
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// รับข้อมูลที่ส่งมาจากฟอร์มโดยตรง
$name = $_POST['name'] ?? '';
$surname = $_POST['surname'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$username = $_POST['username'] ?? '';

$host = "localhost";
$db_name = "omr";
$username = "root";
$password = ""; // ใส่รหัสผ่านของคุณเองที่นี่หากมี

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && isset($username)) {
        $query = "UPDATE user SET name = :name, surname = :surname, email = :email, password = :password WHERE username = :username";
        $stmt = $conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":surname", $surname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":username", $username);

        if ($stmt->execute()) {
            echo json_encode(array('success' => true, 'message' => 'user updated successfully.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update user.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Incomplete Data.'));
    }
} catch(PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}


// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// // รับข้อมูล JSON ที่ส่งมาจากคำขอ
// $json_data = file_get_contents('php://input');
// $data = json_decode($json_data, true);

// // กำหนดค่าข้อมูลจาก JSON
// $name = $data['name'] ?? '';
// $surname = $data['surname'] ?? '';
// $email = $data['email'] ?? '';
// $password = $data['password'] ?? '';
// $username = $data['username'] ?? '';

// $host = "localhost";
// $db_name = "omr";
// $username = "root";
// $password = ""; // ใส่รหัสผ่านของคุณเองที่นี่หากมี

// try {
//     $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     if (!empty($name) && !empty($surname) && !empty($email) && !empty($password) && isset($username)) {
//         $query = "UPDATE user SET name = :name, surname = :surname, email = :email, password = :password WHERE username = :username";
//         $stmt = $conn->prepare($query);

//         // ผูกค่าพารามิเตอร์
//         $stmt->bindParam(":name", $name);
//         $stmt->bindParam(":surname", $surname);
//         $stmt->bindParam(":email", $email);
//         $stmt->bindParam(":password", $password);
//         $stmt->bindParam(":username", $username);

//         if ($stmt->execute()) {
//             echo json_encode(array('success' => true, 'message' => 'user updated successfully.'));
//         } else {
//             echo json_encode(array('success' => false, 'message' => 'Failed to update user.'));
//         }
//     } else {
//         echo json_encode(array('success' => false, 'message' => 'Incomplete Data.'));
//     }
// } catch(PDOException $exception) {
//     die('ERROR: ' . $exception->getMessage());
// }

?>
