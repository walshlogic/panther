<?php
// Include the database connection class
include 'logic/db/dbconn_vision.php'; // Update the path as needed.

// Enable error reporting for debugging (remove this in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch the VID from the POST request
$numberVID = isset($_POST['numberVID']) ? $_POST['numberVID'] : '';

// Get the singleton instance of the database connection
$dbConnection = Connection::getInstance();
$conn = $dbConnection->getConnection();

// Check connection
if (!$conn) {
    die("Connection failed: Unable to connect to the database");
}

$response = [];

try {
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT REM_PRCL_LOCN FROM REAL_PROP.REALMAST WHERE REM_PID = ?");
    $stmt->bindParam(1, $numberVID, PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    // Fetch the result
    if ($row = $stmt->fetch()) {
        echo $row['REM_PRCL_LOCN'];  // Directly output the address
        exit(); // Stop script execution
    } else {
        echo "No Record Found for VID:" . $numberVID;  // Output an error message
        exit(); // Stop script execution
    }
}
catch (PDOException $e) {
    $response['error'] = "An error occurred: " . $e->getMessage();
}
finally {
    // Close the statement and the connection
    $stmt = null;
    $dbConnection->close();
}

// Send the response as JSON
echo json_encode($response);
?>