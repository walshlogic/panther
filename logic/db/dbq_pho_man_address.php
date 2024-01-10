<?php
// path_to_your_php_script.php
include './logic/db/dbconn.php'; // Include your DB connection script

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$vidNumber = $input['numberVID'] ?? '';

try {
    if ($vidNumber) {
        // Log the received VID number for debugging
        error_log("Received VID number: " . $vidNumber);

        // Prepare your SQL query
        $query = "SELECT REM_PRCL_LOCN FROM REAL_PROP.REALMAST WHERE REM_PID = ?";
        $stmt = $dbConnection->prepare($query);

        if (!$stmt) {
            error_log("Statement preparation failed: " . $dbConnection->error);
            throw new Exception('Statement preparation failed');
        }

        $stmt->bind_param("s", $vidNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            error_log("Address found: " . $row['REM_PRCL_LOCN']); // Log the found address
            echo json_encode(['address' => $row['REM_PRCL_LOCN']]);
        } else {
            error_log("No address found for VID: " . $vidNumber); // Log no address found
            echo json_encode(['address' => null]);
        }
    } else {
        error_log("VID number is empty"); // Log empty VID number
        echo json_encode(['error' => 'VID number is empty']);
    }
}
catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['error' => 'Database query failed']);
}
?>