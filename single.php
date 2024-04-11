<?php include 'header.php';
include 'admin/config.php';
$post_id = $_REQUEST['id'];
$getpost = "SELECT * FROM post p
            LEFT JOIN user u on p.author = u.user_id
            LEFT JOIN category c on p.category = c.category_id WHERE post_id = {$post_id}";
$result = mysqli_query($conn, $getpost);
?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {


                    ?>
                            <div class="post-content single-post">
                                <h3><?php echo $row['title']; ?></h3>
                                <div class="post-information">
                                    <span>
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                        <?php echo $row['category_name']; ?>
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
                                <img class="single-feature-image" src="admin/upload/<?php echo $row['post_img']; ?>" alt="" />
                                <p class="description">
                                    <?php echo $row['description']; ?>
                                </p>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>