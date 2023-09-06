<?php
session_start();
include_once './db/dbconn.php';
if (isset($_POST['add'])) {
    $database = new Connection();
    $db = $database->open();
    $file_name = $_FILES['profile_pic']['name'];
    $temp_file_name = $_FILES['profile_pic']['tmp_name'];
    $file_size = $_FILES['profile_pic']['size'];
    $target_dir = "img/emp/";
    $target_file = strtolower($target_dir . basename($file_name));
    $uploadOk = 1;
    $img_file_type = pathinfo($target_file, PATHINFO_EXTENSION);
    // check if image is actual image
    $check_img = getimagesize($temp_file_name);
    if ($check_img == false) {
        echo 'File Is Not An Image! Please Try Again';
        $uploadOk = 0;
    } else {
        $uploadOk = 1;
        if (file_exists($target_file)) {
            echo 'File With Same Name Alrady Uploaded!';
            $uploadOk = 0;
        } else {
            // check file size
            if ($file_size > 500000) {
                echo 'File Size Over 5MB. Please Select Image Under 5MB.';
                $uploadOk = 0;
            } else {
                // allow only these image file types
                if (
                    $img_file_type != "jpg" && $img_file_type != "jpeg" && $img_file_type
                    != "png"
                ) {
                    echo 'Please Select A File Type Of jpg, jpeg, or png';
                    $uploadOk = 0;
                } else {
                    // check if $uploadOk Is Set To '0' By An Error
                    if ($uploadOk === 0) {

                        echo 'Error!File Has Not Been Uploaded. Please Try Again.';
                    } else {
                        if (move_uploaded_file($temp_file_name, $target_file)) {
                            // use prepared statement to prevent sql injection
                            $stmt = $db->prepare("INSERT INTO employee (firstname, lastname, akaname, initialsname, emp_title, email, user_login, phone_work_desk, phone_work_mobile, profile_pic) VALUES (:firstname, :lastname, :akaname, :initialsname, :emp_title, :email, :user_login, :phone_work_desk, :phone_work_mobile, :profile_pic)");
                            // if-else statement in executing our prepared statement
                            $_SESSION[' message'] = ($stmt->execute(array(
                                ':firstname' => $_POST['firstname'],
                                ':lastname' => $_POST['lastname'],
                                ':akaname' => $_POST['akaname'],
                                ':initialsname' => $_POST['initialsname'],
                                ':emp_title' => $_POST['emp_title'],
                                ':email' => $_POST['email'],
                                ':user_login' => $_POST['user_login'],
                                ':phone_work_desk' => $_POST['phone_work_desk'],
                                ':phone_work_mobile' => $_POST['phone_work_mobile'],
                                ':profile_pic' => $file_name,
                            ))) ? '' : 'ERROR: Employee Not Added!(PANTHER Error #AE101';
                        }
                    }
                }
            }
        }
    }
    // close connection
    $database->close();
} else {
    $_SESSION['message'] = 'All Fields Are Required! (PANTHER MESSAGE #DF100)';
}
header('location: emp_view_index.php');