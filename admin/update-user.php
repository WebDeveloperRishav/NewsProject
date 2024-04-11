<?php include "header.php";
include 'config.php';
noentry();
$id = $_REQUEST['id'];
$getsql = "SELECT * FROM user WHERE user_id = {$id}";
$result = mysqli_query($conn, $getsql) or die("query Failed");
if (isset($_REQUEST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_REQUEST['f_name']);
    $last_name = mysqli_real_escape_string($conn, $_REQUEST['l_name']);
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $userrole = $_REQUEST['role'];
    $update = "UPDATE user SET first_name = '{$first_name}', last_name = '{$last_name}', username = '{$username}', role = '{$userrole}' where user_id = {$id}";
    $updateresult = mysqli_query($conn, $update);
    header("Location: http://localhost/phpcrud/news-template/admin/users.php");
}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <!-- Form Start -->
                <?php
                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {

                ?>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id']; ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="form-control" name="role" value="<?php echo $row['role']; ?>">

                                    <?php
                                    if ($row['role'] == 1) {
                                        echo '<option value="0">normal User</option>
                                    <option selected value="1">Admin</option>';
                                    } else {
                                        echo '<option selected value="0">normal User</option>
                                    <option value="1">Admin</option>';
                                    }

                                    ?>

                                </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>
                <?php
                    }
                }
                ?>


                <!-- /Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>