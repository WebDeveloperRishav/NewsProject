<?php include 'header.php';
include 'admin/config.php';

?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    if (isset($_REQUEST['search'])) {
                        $search_trem = $_REQUEST['search'];
                    }

                    ?>
                    <h2 class="page-heading">Search : <?php echo $search_trem; ?></h2>
                    <?php
                    $limit = 3;
                    if (isset($_REQUEST['page'])) {
                        $page = $_REQUEST['page'];
                    } else {
                        $page = 1;
                    }

                    $offset = ($page - 1) * $limit;
                    $searchsql = "SELECT * FROM post p 
                    LEFT JOIN category c on p.category = c.category_id
                    LEFT JOIN user u on p.author = u.user_id
                    WHERE P.title LIKE '%{$search_trem}%' OR p.description LIKE '%{$search_trem}%'
                    LIMIT {$offset}, {$limit}";
                    $query = mysqli_query($conn, $searchsql);

                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
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
                                                    <a href='category.php?id=<?php echo $row['category']; ?>'><?php echo $row['category_name']; ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?id=<?php echo $row['author']; ?>'><?php echo $row['first_name'] . " " . $row['last_name']; ?></a>
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
                    $sql = "SELECT * FROM post WHERE title LIKE '%{$search_trem}%' OR description LIKE '%{$search_trem}%'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $total_recoard = mysqli_num_rows($result);

                        $total_page = ceil($total_recoard / $limit);
                        echo "<ul class='pagination'>";

                        if ($total_recoard > 3) {
                            if ($page > 1) {
                                echo "<li><a href='search.php?page=" . ($page - 1) . "&search={$search_trem}'>Prev</a></li>";
                            }
                            for ($i = 1; $i <= $total_page; $i++) {
                                if ($page == $i) {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                echo "<li class='{$active}'><a href='search.php?page={$i}&search={$search_trem}'>{$i}</a></li>";
                            }
                            if ($total_page > $page) {
                                echo "<li><a href='search.php?page=" . ($page + 1) . "&search={$search_trem}'>Next</a></li>";
                            }
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