<?php include "header.php";
include 'config.php';
$limit = 3;
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

$offset = ($page - 1) * $limit;
if ($_SESSION['user_role'] == 1) {
    $sql = "SELECT * FROM post p 
LEFT JOIN category c on p.category = c.category_id
LEFT JOIN user u on p.author = u.user_id
ORDER BY p.post_id DESC
LIMIT {$offset}, {$limit}";
} elseif ($_SESSION['user_role'] == 0) {
    $sql = "SELECT * FROM post p 
LEFT JOIN category c on p.category = c.category_id
LEFT JOIN user u on p.author = u.user_id
where p.author = {$_SESSION['user_id']}
ORDER BY p.post_id DESC
LIMIT {$offset}, {$limit}";
};
$result = mysqli_query($conn, $sql);
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">add post</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Author</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td class='id'><?php echo $serial; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td><?php echo $row['post_date']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id']; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id']; ?>&catid=<?php echo $row['category'] ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                        <?php
                                $serial++;
                            }
                        }
                        ?>


                    </tbody>
                </table>
                <?php
                if ($_SESSION['user_role'] == 1) {
                    $pagesql = "SELECT * FROM post";
                } elseif ($_SESSION['user_role'] == 0) {
                    $pagesql = "SELECT * FROM post WHERE author = {$_SESSION['user_id']}";
                }
                $pageresult = mysqli_query($conn, $pagesql);
                if (mysqli_num_rows($pageresult) > 0) {
                    $totalrecoard = mysqli_num_rows($pageresult);

                    $totalpage = ceil($totalrecoard / $limit);
                    echo "<ul class='pagination admin-pagination'>";
                    if ($totalrecoard > 3) {
                        if ($page > 1) {
                            echo "<li><a href='post.php?page=" . ($page - 1) . "'>Prev</a></li>";
                        }
                        for ($i = 1; $i <= $totalpage; $i++) {
                            if ($page == $i) {
                                $active = 'active';
                            } else {
                                $active = "";
                            }
                            echo "<li class='{$active}'><a href='post.php?page={$i}'>{$i}</a></li>";
                        }
                        if ($totalpage > $page) {
                            echo "<li><a href='post.php?page=" . ($page + 1) . "'>Next</a></li>";
                        }
                    }
                    echo "</ul>";
                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>