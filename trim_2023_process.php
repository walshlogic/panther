<?php
error_log("Received request");
//error_log(print_r($inputData, true));

ini_set('display_errors', 1);
error_reporting(E_ALL);


//PHP Version 7.4.12

header('Content-Type: application/json');

// Database connection settings
$serverName = "PUTSVISP01";
$connectionOptions = array(
    "Database" => "V7_VISION",
    "Uid" => "PA",
    "PWD" => "hype23#pa"
);

//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Read the input data
$inputData = json_decode(file_get_contents('php://input'), true);

if (!isset($inputData['numbers'])) {
    http_response_code(400);
    //echo json_encode(['error' => 'Missing numbers']);
    exit;
}

foreach ($inputData['numbers'] as $trd_id) {
    $trd_id = (int) $trd_id; // ensure it's an integer
    // We'll put all of your queries here and use $trd_id as the TRD_ID    
    // Your SQL queries should go here. For example:
    $sql = "DECLARE @TRD_ID INT; 
            SET @TRD_ID = ?;
            -- Add your UPDATE queries here, they will use @TRD_ID
            ";

    $params = array($trd_id);

    // Execute query
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        http_response_code(500);
        //echo json_encode(['error' => sqlsrv_errors()]);
        exit;
    }
}

// Close the connection.
sqlsrv_close($conn);

//echo json_encode(['status' => 'success']);