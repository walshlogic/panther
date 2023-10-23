<?php
session_start();
include_once('./logic/dbconn.php');
if (isset($_POST['edit'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        $id = $_GET['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $akaname = $_POST['akaname'];
        $initialsname = $_POST['initialsname'];
        $emp_title = $_POST['emp_title'];
        $email = $_POST['email'];
        $user_login = $_POST['user_login'];
        $phone_work_desk = $_POST['phone_work_desk'];
        $phone_work_mobile = $_POST['phone_work_mobile'];
        $emp_location = $_POST['emp_location'];
        $profile_pic = $_POST['profile_pic'];
        $sql = "UPDATE employee SET firstname = '$firstname', lastname = '$lastname', akaname = '$akaname', initialsname = '$initialsname', emp_title = '$emp_title', email = '$email', user_login = '$user_login', phone_work_desk = '$phone_work_desk', phone_work_mobile = '$phone_work_mobile', location = '$emp_location' , profile_pic = '$profile_pic' WHERE id = '$id'";
        // if-else statement in executing query
        $_SESSION['message'] = ($db->exec($sql)) ? 'Employee Updated Successfully!' : 'ERROR: Employee Not Updated. (PANTHER Error #EE101)';
    }
    catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    // close database connection
    $database->close();
} else {
    $_SESSION['message'] = 'All Fields Required!';
}
header('location: emp_view_index.php');