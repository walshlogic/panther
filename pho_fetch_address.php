<?php
// Include the database connection class
include 'logic/db/dbconn_vision.php';

// Set header to indicate JSON response
header('Content-Type: application/json');

$numberVID = isset($_POST['numberVID']) ? $_POST['numberVID'] : '';
$accountNumber = isset($_POST['accountNumber']) ? $_POST['accountNumber'] : '';

try {
    // Get the database connection
    $dbConnection = Connection::getInstance();
    $conn = $dbConnection->getConnection();

    // Check if the connection is successful
    if (!$conn) {
        throw new Exception('Connection failed: Unable to connect to the database');
    }

    // Initialize response array
    $response = [];

    // Prepare SQL query based on whether numberVID or accountNumber is provided
    if ($numberVID) {
        $stmt = $conn->prepare('SELECT REM_PRCL_LOCN, REM_ACCT_NUM FROM REAL_PROP.REALMAST WHERE REM_PID = ?');
        $stmt->bindParam(1, $numberVID, PDO::PARAM_STR);
    } elseif ($accountNumber) {
        $stmt = $conn->prepare('SELECT REM_PRCL_LOCN, REM_PID FROM REAL_PROP.REALMAST WHERE REM_ACCT_NUM = ?');
        $stmt->bindParam(1, $accountNumber, PDO::PARAM_STR);
    } else {
        throw new Exception('No valid identifier provided');
    }

    // Execute the query
    $stmt->execute();

    // Fetch the result
    if ($row = $stmt->fetch()) {
        $response = [
            'address' => $row['REM_PRCL_LOCN'],
            'numberVID' => $numberVID ? $numberVID : (isset($row['REM_PID']) ? $row['REM_PID'] : null), // Include numberVID from input or fetched from DB
            'accountNum' => $accountNumber ? $accountNumber : (isset($row['REM_ACCT_NUM']) ? $row['REM_ACCT_NUM'] : null) // Include accountNumber from input or fetched from DB
        ];
    } else {
        throw new Exception('No Record Found');
    }

    // Return the JSON response
    echo json_encode($response);
}
catch (Exception $e) {
    // Return a JSON-encoded error message
    echo json_encode(['error' => $e->getMessage() . ". Please Try Again."]);
}
finally {
    // Close statement and connection if they exist
    if ($stmt) {
        $stmt = null;
    }
    if ($dbConnection) {
        $dbConnection->close();
    }
}