<?php
include 'config.php';
include 'function.php';
if (empty($_FILES['filetoupload']['name'])) {
    $file_name = $_REQUEST['old-image'];
} else {
    $error = array();
    $file_name = $_FILES['filetoupload']['name'];
    $temp_name = $_FILES['filetoupload']['tmp_name'];
    $size = $_FILES['filetoupload']['size'];
    $type = $_FILES['filetoupload']['type'];
    $file_ext = explode('.', $file_name)[1];
    $extension = ['jpeg', 'jpg', 'png'];
    if (in_array($file_ext, $extension) === false) {
        $error[] = "This Extension file not allowed , please uploade JPEG, JPG and PNG formet";
    }
    if ($size > 2097152) {
        $error[] = "File size must be 2mb or lower";
    }

    if (empty($error) == true) {
        move_uploaded_file($temp_name, "upload/" . $file_name);
    } else {
        printarray($error);
    }
}
$id = $_REQUEST['post_id'];
$title = mysqli_real_escape_string($conn, $_REQUEST['post_title']);
$description = mysqli_real_escape_string($conn, $_REQUEST['postdesc']);
$category = $_REQUEST['category'];
$date = date('D, M, Y');
$old_category = $_REQUEST['old_category'];
$sql = "UPDATE post set 
title = '{$title}',
description = '{$description}',
category = '{$category}',
post_date = '{$date}',
post_img = '{$file_name}'
where post_id = {$id};";
if ($category != $old_category) {
    $sql .= "UPDATE category SET post = post -1 WHERE category_id = {$old_category};";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category};";
}

if (mysqli_multi_query($conn, $sql)) {
    changepage('post.php');
} else {
    echo "Query Failed";
}
