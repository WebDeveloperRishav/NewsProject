<?php include "header.php";
include 'config.php';
noentry();
if (isset($_REQUEST['save'])) {
    $fname = mysqli_real_escape_string($conn, $_REQUEST['fname']);
    $lname = mysqli_real_escape_string($conn, $_REQUEST['lname']);
    $username = mysqli_real_escape_string($conn, $_REQUEST['user']);
    $password = md5($_REQUEST['password']);
    $user_role = $_REQUEST['role'];

    $checkuser = "SELECT username from user where username = '{$username}'";
    $checkquery = mysqli_query($conn, $checkuser);
    if (mysqli_num_rows($checkquery) > 0) {
        echo "<p>User name {$username} Already Exists</p>";
    } else {
        $insert = "INSERT INTO user (first_name, last_name, username, password, role) VALUES ('{$fname}','{$lname}','{$username}','{$password}','{$user_role}')";
        $result = mysqli_query($conn, $insert) or die("query Failed");
        header("Location: http://localhost/phpcrud/news-template/admin/users.php");
    }
}


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add User</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="user" class="form-control" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="role">
                            <option value="0">Normal User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                </form>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>