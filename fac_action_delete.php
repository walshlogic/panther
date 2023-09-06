<?php
session_start();
require_once './logic/favicon.php';
include_once('./db/dbconn.php');
if (isset($_GET['id'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        $sql = "DELETE FROM facility WHERE id = '" . $_GET['id'] . "'";
        // if-else statement in executing DELETE query
        $_SESSION['message'] = ($db->exec($sql)) ? 'Facility Location Record Deleted Successfully. There Is No Method To Reverse This Action.'
            : 'ERROR: Facility Location  Record NOT Deleted! Try Again? (PANTHER Error #: FD101)';
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close database connection
    $database->close();
} else {
    $_SESSION['message'] = 'Select A Facility Location Record To Delete!';
}
header('location: fac_view_index.php');