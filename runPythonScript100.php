<?php

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: Content-Type");

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');


// Get JSON payload from the request
$json = file_get_contents('php://input');
$data = json_decode($json, true); // Decode as an associative array

// Now extract 'scriptPath' and 'id_exam' from $data
$scriptPath = $data['scriptPath'];
$id_exam = $data['id_exam'];

// Define the static string
$staticPath = 'C:/xampp/htdocs/api/result';

// Execute the Python script with the static string and id_exam as arguments
$output = shell_exec("python \"$scriptPath\" \"$staticPath\" \"$id_exam\"");

// Check if execution was successful
if ($output !== null) {
  echo json_encode(['success' => true, 'output' => $output]); // Optionally return output for debugging
} else {
  echo json_encode(['success' => false]);
}
?>