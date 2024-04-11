<?php
include 'config.php';
include 'function.php';
session_start();

if (isset($_FILES['fileToUpload'])) {
    $error = array();
    $file_name = $_FILES['fileToUpload']['name'];
    $temp_name = $_FILES['fileToUpload']['tmp_name'];
    $size = $_FILES['fileToUpload']['size'];
    $type = $_FILES['fileToUpload']['type'];
    $file_ext = strtolower(end(explode(".", $file_name)));
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

$post_title = mysqli_real_escape_string($conn, $_REQUEST['post_title']);
$postdesc = mysqli_real_escape_string($conn, $_REQUEST['postdesc']);
$category = $_REQUEST['category'];
$date = date('D, M, Y');
$author = $_SESSION['user_id'];
$sql = "INSERT INTO post(title, description, category, post_date, author, post_img) values('{$post_title}','{$postdesc}','{$category}','{$date}',{$author}, '{$file_name}');";
$sql .= "UPDATE category SET post = post + 1 WHERE category_id = '{$category}'";

if (mysqli_multi_query($conn, $sql)) {
    changepage('post.php');
} else {
    echo "Query Failed";
}
