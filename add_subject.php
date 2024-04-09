<?php

// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');

header('Access-Control-Allow-Origin: *'); // อนุญาต CORS
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization'); // อนุญาตหัวข้อเหล่านี้
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // อนุญาตเมธอดที่คุณต้องการใช้

$conn = new mysqli('localhost', 'root', '', 'omr');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateUniqueCodeSubject($conn) {
    $codeExists = true;
    $code_subject = '';

    while ($codeExists) {
        $code_subject = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

        $stmt = $conn->prepare("SELECT * FROM subject WHERE code_subject = ?");
        $stmt->bind_param("s", $code_subject);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $codeExists = false; 
        }
        $stmt->close();
    }

    return $code_subject;
}

$data = json_decode(file_get_contents("php://input"), true);

$code_subject = generateUniqueCodeSubject($conn); // สร้าง code_subject แบบสุ่มที่ไม่ซ้ำ

$stmt = $conn->prepare("INSERT INTO subject (username, year, term, id_subject, name_subject, code_subject) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissss", $data['username'], $data['year'], $data['term'], $data['id_subject'], $data['name_subject'], $code_subject);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'code_subject' => $code_subject]); // ส่งคืน code_subject ที่สร้างไปยัง client ด้วย
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add subject.']);
}

$stmt->close();
$conn->close();
?>
