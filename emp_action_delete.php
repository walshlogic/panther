<?php

session_start();
include_once('./db/dbconn.php');

if (isset($_GET['id'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        $sql = "DELETE FROM employee WHERE id = '" . $_GET['id'] . "'";
        // if-else statement in executing DELETE query
        $_SESSION['message'] = ($db->exec($sql)) ? 'Employee Record Deleted Successfully. There Is No Method To Reverse This Action.' : 'ERROR: Employee Record NOT Deleted! Try Again? (PANTHER Error #: ED101)';
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close database connection
    $database->close();
} else {
    $_SESSION['message'] = 'Select An Employee Record To Delete!';
}
header('location: emp_view_index.php');