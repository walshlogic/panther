<?php
session_start();
include_once('./logic/dbconn.php');
if (isset($_GET['inv_id'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        $sql = "DELETE FROM items WHERE inv_id = '" . $_GET['inv_id'] . "'";
        // if-else statement in executing DELETE query
        $_SESSION['message'] = ($db->exec($sql))
            ? 'Inventory Item Record Deleted Successfully. There Is No Method To Reverse This Action.'
            : 'ERROR: Inventory Item Record NOT Deleted! Try Again? (PANTHER Error #: ID101)';
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close database connection
    $database->close();
} else {
    $_SESSION['message'] = 'Select A Suggestion Record To Delete!';
}
header('location: inventory_index.php');