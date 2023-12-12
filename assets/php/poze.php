<?php
require_once("conn.php");

$conn.

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photos'])) {
    $uploadFolder = 'uploads/'; // Create a folder named 'uploads' in the same directory as your PHP file

    // Loop through each uploaded file
    foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['photos']['name'][$key];
        $file_tmp = $_FILES['photos']['tmp_name'][$key];
        $file_type = $_FILES['photos']['type'][$key];

        $target_path = $uploadFolder . $file_name;

        // Move the uploaded file to the specified folder
        move_uploaded_file($file_tmp, $target_path);

        // Save file information to the database (you need to implement your database connection)
        // Example SQL query: INSERT INTO photos (file_name, file_path) VALUES ('$file_name', '$target_path');
    }

    echo json_encode(['success' => 'Files uploaded successfully']);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>