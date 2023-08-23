<?php
$target_dir='./img/emp/';
$target_file=$target_dir.basename($_FILES['profile_pic']['name']);
$uploadOk=1;
$imageFileType=strtolower(
        pathinfo(
                $target_file, PATHINFO_EXTENSION
        )
        );
// check if image file is actual image
if(isset($_POST['submit'])){
    $check=getimagesize($_FILES['profile_pic']['temp_name']);
    if($check!==false){
        echo 'File is an image - '.$check['mime'].'.';
        $uploadOk=1;
    }
    else{
        echo 'File is not an image';
        $uploadOk=0;
    }
}

