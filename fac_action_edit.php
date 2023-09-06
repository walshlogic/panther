<?php
session_start();
require_once './logic/favicon.php';
include_once('./db/dbconn.php');
if (isset($_POST['fac_action_edit'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        $id = $_GET['id'];
        $fac_loc_type = $_POST['fac_loc_type'];
        $fac_loc_number = $_POST['fac_loc_number'];
        $fac_loc_description = $_POST['fac_loc_description'];
        $sql = "UPDATE facility SET fac_loc_type = '$fac_loc_type', fac_loc_number = '$fac_loc_number', fac_loc_description = '$fac_loc_description' WHERE id = '$id'";
        // if-else statement in executing query
        $_SESSION['message'] = ($db->exec($sql)) ? 'Facility Information Updated Successfully!'
            : 'ERROR: Facility Information Not Updated. (PANTHER Error #FE101)';
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close database connection
    $database->close();
} else {
    $_SESSION['message'] = 'All Fields Required!';
}
header('location: fac_view_index.php');