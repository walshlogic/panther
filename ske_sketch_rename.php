<?php
session_start();
// Log errors to a file
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

include 'db/dbconn_vision.php';
define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/photos/');
$prefixCounter = [];

try {
    $dbConnection = Connection::getInstance();
    $conn = $dbConnection->getConnection();
}
catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

include 'ske_common_functions.php';

$response = [];

try {
    $files = glob(DIRECTORY_PATH . '*.*');
    if (!$files || empty($files)) {
        $response['error'] = 'No files found';
        echo json_encode($response);
        exit;
    }
    $response = batchRenameCopyMoveAndUpdateDatabase($files, $conn);
}
catch (Exception $e) {
    $response['error'] = $e->getMessage();
}
finally {
    $conn = null;
    echo json_encode($response);
}
?>