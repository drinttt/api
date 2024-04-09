<?php
header('Access-Control-Allow-Origin: *'); // อนุญาต CORS
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization'); // อนุญาตหัวข้อเหล่านี้
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // อนุญาตเมธอดที่คุณต้องการใช้

$conn = new mysqli('localhost', 'root', '', 'omr');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

// $stmt = $conn->prepare("UPDATE subject SET year=?, term=?, id_subject=?, name_subject=? WHERE code_subject=? AND username=?");
// $stmt->bind_param("ssssis", $data['year'], $data['term'], $data['id_subject'], $data['name_subject'], $data['code_subject'], $data['username']);
$stmt = $conn->prepare("UPDATE subject SET year=?, term=?, id_subject=?, name_subject=? WHERE code_subject=? AND username=?");
$stmt->bind_param("ssssis", $data['year'], $data['term'], $data['id_subject'], $data['name_subject'], $data['code_subject'], $data['username']);


if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update subject.']);
}

$stmt->close();
$conn->close();
?>
