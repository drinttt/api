<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "omr";

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$examId = isset($_POST['id_exam']) ? $_POST['id_exam'] : '';

$targetDir = "uploads/" . $examId . "/";

// Check if the directory exists, if not, create it
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$response = array();
$fileCount = 0;

if (!empty($_FILES['files']['name'][0])) {
    foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
        $originalFileName = basename($_FILES['files']['name'][$key]);
        // Check if the file name is a number
        if (preg_match('/^\d+\..+$/', $originalFileName)) {
            $noStudent = explode('.', $originalFileName)[0];
            // Query the database for the student ID based on no_student
            $query = "SELECT id_student FROM student WHERE no_student = '$noStudent' AND id_exam = '$examId'";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $newFileName = $row['id_student'] . '.' . pathinfo($originalFileName, PATHINFO_EXTENSION);
                $targetFilePath = $targetDir . $newFileName;
                // Move and rename the file
                if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetFilePath)) {
                    $fileCount++;
                } else {
                    $response['errors'][] = "File {$originalFileName} could not be uploaded.";
                }
            } else {
                $response['errors'][] = "No student found for file {$originalFileName}.";
            }
        } else {
            $response['errors'][] = "File {$originalFileName} does not have a numeric name.";
        }
    }

    $response['message'] = "{$fileCount} file(s) uploaded and renamed successfully.";
} else {
    $response['errors'][] = 'No files were uploaded.';
}

// Convert the response array to JSON format to send back to the client
echo json_encode($response);

$conn->close();
?>
