<?php
// Set header to return JSON
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "omr"; 

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$username = isset($_GET['username']) ? $_GET['username'] : '';

$sql = "SELECT COUNT(*) FROM user WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute([':username' => $username]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}

?>
