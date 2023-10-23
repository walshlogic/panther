<?php
session_start();
require_once './logic/favicon.php';
include_once('./logic/dbconn.php');
if (isset($_POST['inv_action_edit'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        $inv_id = $_GET['inv_id'];
        $inv_item_status = $_POST['checkboxStatus'];
        $county_dept_num = $_POST['county_dept_num'];
        $county_asset_id = $_POST['county_asset_id'];
        $inv_item_make = $_POST['inv_item_make'];
        $inv_item_model = $_POST['inv_item_model'];
        $inv_item_sn = $_POST['inv_item_sn'];
        $inv_item_location = $_POST['inv_item_location'];
        $sql = "UPDATE items SET inv_item_status = '$inv_item_status', county_dept_num = '$county_dept_num', county_asset_id = '$county_asset_id' ,inv_item_make = '$inv_item_make', inv_item_model = '$inv_item_model', inv_item_sn = '$inv_item_sn', inv_item_location = '$inv_item_location' WHERE inv_id = '$inv_id'";
        // if-else statement in executing query
        $_SESSION['message'] = ($db->exec($sql)) ? 'Inventory Item Updated Successfully!'
            : 'ERROR: Inventory Item Not Updated. (PANTHER Error #IE101)';
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close database connection
    $database->close();
} else {
    $_SESSION['message'] = 'All Fields Required!';
}
header('location: inv_view_index.php');