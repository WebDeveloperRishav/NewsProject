<?php
include 'config.php';
include 'function.php';
$id = $_REQUEST['id'];
$catid = $_REQUEST['catid'];
$sql1 = "SELECT * FROM post where post_id = {$id}";
$result = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result);
unlink("upload/" . $row['post_img']);
$sql = "DELETE FROM post where post_id = {$id};";
$sql .= "UPDATE category SET post = post -1 WHERE category_id = {$catid}";

if (mysqli_multi_query($conn, $sql)) {
    changepage('post.php');
} else {
    echo "Query Failed";
}
