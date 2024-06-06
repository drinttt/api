<?php
// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Check if id_exam parameter exists in the URL
if(isset($_GET['id_exam'])) {
    // Get the id_exam from the URL
    $id_exam = $_GET['id_exam'];
    
    // Specify the directory containing images based on id_exam
    $directory = "C:/xampp/htdocs/api/result/{$id_exam}";
    $baseUrl = "http://localhost/api/result/{$id_exam}/";
    
    // Initialize an array to hold the image URLs
    $imageUrls = [];
    
    // Check if the directory exists and is a directory
    if (is_dir($directory)) {
        // Open the directory
        if ($dh = opendir($directory)) {
            // Read files from the directory
            while (($file = readdir($dh)) !== false) {
                // Check for image files (you might want to add more file types)
                if (preg_match('/\.(jpg|jpeg|png|gif)$/', $file)) {
                    // Construct the full URL for each image and add it to the array
                    $imageUrls[] = $baseUrl . rawurlencode($file);
                }
            }
            // Close the directory
            closedir($dh);
        }
    }
    
    // Convert the array of image URLs to JSON and output
    echo json_encode($imageUrls);
} else {
    // If id_exam parameter is not provided, return an error message
    echo json_encode(["error" => "id_exam parameter is required"]);
}
?>

