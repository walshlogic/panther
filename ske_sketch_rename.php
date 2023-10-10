<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db/dbconn_vision.php';

define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/photos/');
//define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/zSketchesDumpTest/');
define('BACKUP_DIRECTORY', '/mnt/paphotos/SketchFinal/OriginalBackups/');
define('COUNTER_DIRECTORY', './counters/');

$prefixCounter = [];

try {
    $dbConnection = Connection::getInstance();
    $conn = $dbConnection->getConnection();
}
catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

// Include common functions
include 'ske_common_functions.php';

try {
    $files = glob(DIRECTORY_PATH . '*.*');
    if (!$files || empty($files)) {
        echo json_encode(["status" => "completed", "message" => "No more files to process."]);
        exit;
    }

    if (!is_dir(COUNTER_DIRECTORY)) {
        mkdir(COUNTER_DIRECTORY, 0755, true);
    }

    batchRenameCopyMoveAndUpdateDatabase($files, $conn); // Updated function name
    echo json_encode(["status" => "success", "message" => "Processing completed successfully"]);
}
catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "An error occurred: " . $e->getMessage()]);
}
finally {
    $conn = null;
}
?>