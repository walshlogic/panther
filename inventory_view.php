<?php
session_start();
include_once('./logic/dbconn.php');
if (isset($_POST['view_inv_item'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        $inv_id = $_GET['inv_id'];
        $inv_item_make = $_POST['inv_item_make'];
        $inv_item_model = $_POST['inv_item_model'];
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close database connection
    $database->close();
} else {
    $_SESSION['message'] = 'All Fields Required!';
}
header('location: inventory_index.php');