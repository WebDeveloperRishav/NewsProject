<?php include "header.php";
include "config.php";
noentry();
$limit = 3;
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$usersql = "SELECT * FROM user ORDER BY user_id Desc LIMIT {$offset}, {$limit}";
$result = mysqli_query($conn, $usersql) or die("Query Failed");
$data = mysqli_num_rows($result);

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        if ($data > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td class='id'><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php
                                        if ($row['role'] == 1) {
                                            echo "Admin";
                                        } else {
                                            echo "Normal User";
                                        }

                                        ?></td>
                                    <td class='edit'><a href='update-user.php?id=<?php echo $row['user_id']; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-user.php?id=<?php echo $row['user_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<h1> Recoard Not Found </h1>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                $pagesql = "SELECT * FROM user";
                $pageresult = mysqli_query($conn, $pagesql);
                if (mysqli_num_rows($pageresult) > 0) {
                    $totalrecoard = mysqli_num_rows($pageresult);

                    $totalpage = ceil($totalrecoard / $limit);
                    echo "<ul class='pagination admin-pagination'>";
                    if ($totalrecoard > 3) {
                        if ($page > 1) {
                            echo "<li><a href='users.php?page=" . ($page - 1) . "'>Prev</a></li>";
                        }
                        for ($i = 1; $i <= $totalpage; $i++) {
                            if ($page == $i) {
                                $active = 'active';
                            } else {
                                $active = "";
                            }
                            echo "<li class='{$active}'><a href='users.php?page={$i}'>{$i}</a></li>";
                        }
                        if ($totalpage > $page) {
                            echo "<li><a href='users.php?page=" . ($page + 1) . "'>Prev</a></li>";
                        }
                    }
                    echo "</ul>";
                }

                ?>


            </div>
        </div>
    </div>
</div>
<?php include "header.php"; ?>