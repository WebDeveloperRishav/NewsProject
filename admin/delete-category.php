<?php
include 'config.php';
include 'function.php';
$id = $_REQUEST['id'];
$del = "DELETE FROM category WHERE category_id = {$id}";
$result = mysqli_query($conn, $del);
changepage('category.php');
mysqli_close($conn);
