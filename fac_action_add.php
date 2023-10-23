<?php
// /\/\/\/\/\/\
// Add Suggestion
// \/\/\/\/\/\/
session_start();
require_once './logic/favicon.php';
include_once './logic/dbconn.php';
if (isset($_POST['add'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        // use prepared statement to prevent sql injection
        $stmt = $db->prepare("INSERT INTO facility (fac_loc_type, fac_loc_number, fac_loc_description) VALUES (:fac_loc_type, :fac_loc_number, :fac_loc_description)");
        // if-else statement in executing our prepared statement
        $_SESSION['message'] = ($stmt->execute(array(':fac_loc_type' => $_POST['fac_loc_type'],
            ':fac_loc_number' => $_POST['fac_loc_number'],
            ':fac_loc_description' => $_POST['fac_loc_description'])))
            ? '' : 'ERROR: Suggestion Not Added! (PANTHER Error #AF101';
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close connection
    $database->close();
} else {
    $_SESSION['message'] = 'All Fields Are Required! (PANTHER MESSAGE #DF100)';
}
header('location: fac_view_index.php');