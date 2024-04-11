<?php include 'header.php';
include 'admin/config.php';
include 'admin/function.php';
$authid = $_REQUEST['id'];
$limit = 3;
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $limit;
$sql = "SELECT * FROM post p
LEFT JOIN category c on p.category = c.category_id
LEFT JOIN user u on p.author = u.user_id
WHERE u.user_id = {$authid}
ORDER BY p.post_id DESC
LIMIT {$offset}, {$limit}
";
$result = mysqli_query($conn, $sql);
?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    $pagesql = "SELECT * FROM post p
                    LEFT JOIN category c on p.category = c.category_id
                    LEFT JOIN user u on p.author = u.user_id
                    WHERE author = {$authid}
                    ";

                    $pagequery = mysqli_query($conn, $pagesql);
                    $data = mysqli_fetch_assoc($pagequery);
                    ?>
                    <h2 class='page-heading'><?php echo $data['first_name'] . " " . $data['last_name']; ?></h2>
                    <?php
                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {



                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt="" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?id=<?php echo $row['category_id']; ?>'><?php echo $row['category_name']; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?id=<?php echo $row['user_id'] ?>'><?php echo $row['first_name'] . " " . $row['last_name']; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date']; ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo substr($row['description'], 0, 120) . "...."; ?>
                                            </p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>

                    <?php

                    if (mysqli_num_rows($pagequery) > 0) {
                        $total_recoard = mysqli_num_rows($pagequery);
                        $total_page = ceil($total_recoard / $limit);
                        echo "<ul class='pagination'>";
                        if ($page > 1) {
                            echo "<li><a href='author.php?page=" . ($page - 1) . "&id={$authid}'>Prev</a></li>";
                        }
                        if ($total_recoard > 3) {
                            for ($i = 1; $i <= $total_page; $i++) {
                                if ($page == $i) {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                echo "<li class='{$active}'><a href='author.php?page={$i}&id={$authid}'>{$i}</a></li>";
                            }
                        }
                        if ($total_page > $page) {
                            echo "<li><a href='author.php?page=" . ($page + 1) . "&id={$authid}'>Next</a></li>";
                        }
                        echo "</ul>";
                    }

                    ?>

                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>