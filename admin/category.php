<?php include "header.php";
include 'config.php';
noentry();
$limit = 3;
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

$offset = ($page - 1) * $limit;
$sql = "SELECT * FROM category order by category_id DESC LIMIT {$offset}, {$limit}";
$result = mysqli_query($conn, $sql);

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td class='id'><?php echo $row['category_id']; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td><?php echo $row['post']; ?></td>
                                    <td class='edit'><a href='update-category.php?id=<?php echo $row['category_id']; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-category.php?id=<?php echo $row['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<h1>Recoard Not Found</h1>";
                        }
                        ?>

                    </tbody>
                </table>
                <?php
                $pagesql = "SELECT * FROM category";
                $pagequery = mysqli_query($conn, $pagesql);
                if (mysqli_num_rows($pagequery) > 0) {
                    $totalrecoared = mysqli_num_rows($pagequery);

                    $totalpage = ceil($totalrecoared / $limit);
                    echo "<ul class='pagination admin-pagination'>";
                    if ($totalrecoared > 3) {
                        if ($page > 1) {
                            echo "<li><a href='category.php?page=" . ($page - 1) . "'>Prev</a></li>";
                        }
                        for ($i = 1; $i <= $totalpage; $i++) {
                            if ($page == $i) {
                                $active = 'active';
                            } else {
                                $active = "";
                            }
                            echo "<li class='{$active}'><a href='category.php?page={$i}'>{$i}</a></li>";
                        }
                        if ($totalpage > $page) {
                            echo "<li><a href='category.php?page=" . ($page + 1) . "'>Next</a></li>";
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