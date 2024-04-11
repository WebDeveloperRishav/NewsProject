<?php
include 'config.php';
include 'function.php';
$id = $_REQUEST['id'];
$del = "DELETE FROM user WHERE user_id = {$id}";
$result = mysqli_query($conn, $del);
changepage('users.php');
mysqli_close($conn);
