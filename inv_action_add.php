<?php
// /\/\/\/\/\/\/\/\
// add inventory item
// \/\/\/\/\/\/\/\/
session_start();
include_once './logic/dbconn.php';
if (isset($_POST['add'])) {
    $database = new Connection();
    $db = $database->open();
    $upCategory = (strtoupper($inv_item_cateogry));
    try {
        // use prepared statement to prevent sql injection
        $stmt = $db->prepare("INSERT INTO items (county_dept_num, county_asset_id, inv_item_category, inv_item_make, inv_item_model, inv_item_sn, inv_received_date, inv_received_cost) VALUES (:county_dept_num, :county_asset_id, :inv_item_category, :inv_item_make, :inv_item_model, :inv_item_sn, :inv_received_date, :inv_received_cost)");
        // if-else statement in executing our prepared statement
        $_SESSION['message'] = ($stmt->execute(array(
            ':county_dept_num' => $_POST['county_dept_num'],
            ':county_asset_id' => $_POST['county_asset_id'],
            ':inv_item_category' => $_POST['inv_item_category'],
            ':inv_item_make' => $_POST['inv_item_make'],
            ':inv_item_model' => $_POST['inv_item_model'],
            ':inv_item_sn' => $_POST['inv_item_sn'],
            ':inv_received_date' => $_POST['inv_received_date'],
            ':inv_received_cost' => $_POST['inv_received_cost'],
        ))) ? '' : 'ERROR: Inventory Item Not Added! (PANTHER Error #AI101';
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close connection
    $database->close();
} else {
    $_SESSION['message'] = 'All Fields Are Required For Adding Inventory Item! (PANTHER MESSAGE #AI100)';
}
header('location: inventory_index.php');