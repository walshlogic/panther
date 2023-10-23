<?php
session_start();
include_once('./logic/dbconn.php');
if (isset($_POST['view'])) {
    $database = new Connection();
    $db = $database->open();
    try {
        $id = $_GET['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $emp_title = $_POST['emp_title'];
        $email = $_POST['email'];
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