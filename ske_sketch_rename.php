<?php
session_start();

include 'logic/db/dbconn_vision.php';
define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/photos/');
$prefixCounter = [];

try {
    $dbConnection = Connection::getInstance();
    $conn = $dbConnection->getConnection();
    // Database connection established
}
catch (Exception $e) {
    // Error connecting to the database
    $response['error'] = 'Database connection failed';
}

include 'ske_common_functions.php';

$response = [];

try {
    $files = glob(DIRECTORY_PATH . '*.*');
    if (!$files || empty($files)) {
        $response['error'] = 'No files found';
    } else {
        $response = batchRenameCopyMoveAndUpdateDatabase($files, $conn);
        // Batch processing completed
    }
}
catch (Exception $e) {
    $response['error'] = 'An error occurred: ' . $e->getMessage();
}
finally {
    $conn = null;
    // Send the response as JSON
    echo json_encode($response);
}
?>