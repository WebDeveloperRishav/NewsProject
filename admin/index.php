<?php
include 'config.php';
include 'function.php';
session_start();
if (isset($_SESSION['username'])) {
    changepage('post.php');
}



?>


<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN | Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div id="wrapper-admin" class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <img class="logo" src="images/news.jpg">
                    <h3 class="heading">Admin</h3>
                    <!-- Form Start -->
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="" required>
                        </div>
                        <input type="submit" name="login" class="btn btn-primary" value="login" />
                    </form>
                    <?php
                    if (isset($_REQUEST['login'])) {
                        $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
                        $password = md5($_REQUEST['password']);
                        $sql = "SELECT user_id, username, role from user WHERE username = '{$username}' AND password = '{$password}'";
                        $query = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {

                                $_SESSION['username'] = $row['username'];
                                $_SESSION['user_role'] = $row['role'];
                                $_SESSION['user_id'] = $row['user_id'];

                                changepage('post.php');
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Username and Password Does not Match</div>";
                        }
                    }
                    ?>


                    <!-- /Form  End -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>