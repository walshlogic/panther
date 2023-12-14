<?php require_once './logic/favicon.php'; ?> <?php
$connection = mysqli_connect("localhost", "root", "Dixie!104");
$db = mysqli_select_db($connection, 'panther.employee');
if (isset($_POST['updatedata'])) {
    $id = $_POST['update_id'];
    $firstname = $_POST['firstname'];
    $llastname = $_POST['lastname'];
    $emp_title = $_POST['emp_title'];
    $email = $_POST['email'];
    $query = "UPDATE panther.employee SET firstname='$firstname', lastname='$lastname', emp_title='$emp_title', email=' $email' WHERE id='$id'  ";
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
        echo '<script> alert("Data Updated"); </script>';
        header("Location:app_view_index.php");
    } else {
        echo '<script> alert("Data Not Updated"); </script>';
    }
}