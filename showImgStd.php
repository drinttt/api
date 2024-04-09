<?php
// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Check if id_exam and id_student parameters exist in the URL
if(isset($_GET['id_exam']) && isset($_GET['id_student'])) {
    // Get the id_exam and id_student from the URL
    $id_exam = $_GET['id_exam'];
    $id_student = $_GET['id_student'];
    
    // Specify the directory containing images based on id_exam
    $directory = "C:/xampp/htdocs/api/result/{$id_exam}";
    $baseUrl = "http://localhost/api/result/{$id_exam}/";
    
    // Initialize an array to hold the image URL
    $imageUrl = null;
    
    // Check if the directory exists and is a directory
    if (is_dir($directory)) {
        // Open the directory
        if ($dh = opendir($directory)) {
            // Read files from the directory
            while (($file = readdir($dh)) !== false) {
                // Check for image file that matches the id_student
                if (preg_match("/res_{$id_student}\.(jpg|jpeg|png|gif)$/", $file)) {
                    // Construct the full URL for the image and set it
                    $imageUrl = $baseUrl . rawurlencode($file);
                    break; // Stop the loop after finding the matching file
                }
            }
            // Close the directory
            closedir($dh);
        }
    }
    
    // Check if an image URL was set
    if ($imageUrl) {
        echo json_encode(["url" => $imageUrl]);
    } else {
        echo json_encode(["error" => "No matching image found for the specified id_student"]);
    }
} else {
    // If id_exam or id_student parameter is not provided, return an error message
    echo json_encode(["error" => "Both id_exam and id_student parameters are required"]);
}
?>
