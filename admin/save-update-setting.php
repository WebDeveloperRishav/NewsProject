<?php
include 'config.php';
include 'function.php';
if (empty($_FILES['new-image']['name'])) {
    $file_name = $_REQUEST['old-image'];
} else {
    $error = array();
    $file_name = $_FILES['new-image']['name'];
    $temp_name = $_FILES['new-image']['tmp_name'];
    $size = $_FILES['new-image']['size'];
    $type = $_FILES['new-image']['type'];
    $file_ext = strtolower(end(explode(".", $file_name)));
    $extension = ['jpeg', 'jpg', 'png'];

    if (in_array($file_ext, $extension) === false) {
        $error[] = "This Extension file not allowed , please uploade JPEG, JPG and PNG formet";
    }
    if ($size > 2097152) {
        $error[] = "File size must be 2mb or lower";
    }

    if (empty($error) == true) {
        move_uploaded_file($temp_name, "images/" . $file_name);
    } else {
        printarray($error);
    }
}

$websitename = $_REQUEST['website_name'];
$footerdesc = $_REQUEST['footerdesc'];
$sql = "UPDATE settings SET websitename = '{$websitename}', logo = '{$file_name}', footerdesc = '{$footerdesc}'";
if (mysqli_query($conn, $sql)) {
    changepage('setting.php');
} else {
    echo "Query Failed";
}
