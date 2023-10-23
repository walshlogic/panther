<?php
session_start();

include 'logic/db/dbconn_vision.php';
define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/photos/');
$prefixCounter = [];

try {
    $dbConnection = Connection::getInstance();
    $conn = $dbConnection->getConnection();
    //echo "Database connection established. \n"; // Add this line for debugging
}
catch (Exception $e) {
    //echo "Error connecting to the database: " . $e->getMessage() . "\n"; // Add this line for debugging
}

include 'ske_common_functions.php';

$response = [];

try {
    $files = glob(DIRECTORY_PATH . '*.*');
    if (!$files || empty($files)) {
        $response['error'] = 'No files found';
        //echo "No files found. \n"; // Add this line for debugging
        //echo json_encode($response);
        exit;
    }
    $response = batchRenameCopyMoveAndUpdateDatabase($files, $conn);
    //echo "Batch processing completed. \n"; // Add this line for debugging
}
catch (Exception $e) {
    //echo "An error occurred: " . $e->getMessage() . "\n"; // Add this line for debugging
}
finally {
    $conn = null;
    //echo json_encode($response);
}

?>