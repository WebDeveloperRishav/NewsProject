<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    include 'admin/config.php';
                    $limit = 3;
                    if (isset($_REQUEST['page'])) {
                        $page = $_REQUEST['page'];
                    } else {
                        $page = 1;
                    }

                    $offset = ($page - 1) * $limit;

                    $getpost = "SELECT * FROM post p
                    LEFT JOIN user u on p.author = u.user_id
                    LEFT JOIN category c on p.category = c.category_id
                    ORDER BY p.post_id DESC
                    LIMIT {$offset}, {$limit}";
                    $postquery = mysqli_query($conn, $getpost);
                    if (mysqli_num_rows($postquery) > 0) {
                        while ($row = mysqli_fetch_assoc($postquery)) {
                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt="" /></a>
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
                                                    <a href='author.php?id=<?php echo $row['user_id']; ?>'><?php echo $row['first_name'] . " " . $row['last_name']; ?></a>
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
                    } else {
                        echo "Recoard not Found";
                    }
                    ?>


                    <?php
                    $sql = "SELECT * FROM post";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $totalrecoard = mysqli_num_rows($result);
                        $totalpage = ceil($totalrecoard / $limit);


                        if ($totalrecoard >= 3) {
                            echo "<ul class='pagination'>";
                            if ($page > 1) {
                                echo "<li><a href='index.php?page=" . ($page - 1) . "'>Prev</a></li>";
                            }
                            for ($i = 1; $i <= $totalpage; $i++) {
                                if ($page == $i) {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }

                                echo "<li class='{$active}'><a href='index.php?page={$i}'>{$i}</a></li>";
                            }
                            if ($totalpage > $page) {
                                echo "<li><a href='index.php?page=" . ($page + 1) . "'>Next</a></li>";
                            }
                            echo "</ul>";
                        }
                    }

                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>