<?php include "header.php";
include 'config.php';

$id = $_REQUEST['id'];
if ($_SESSION['user_role'] == 0) {
    $check = "SELECT * from post where post_id = {$id}";
    $checkresult = mysqli_query($conn, $check);
    $checkrow = mysqli_fetch_assoc($checkresult);
    if ($checkrow['author'] != $_SESSION['user_id']) {
        header("Location: http://localhost/phpcrud/news-template/admin/post.php");
    }
}
$getvalue = "SELECT * FROM post where post_id = {$id}";
$result = mysqli_query($conn, $getvalue);
if (mysqli_num_rows($result)) {
    while ($get = mysqli_fetch_assoc($result)) {



?>
        <div id="admin-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="admin-heading">Update Post</h1>
                    </div>
                    <div class="col-md-offset-3 col-md-6">
                        <!-- Form for show edit-->
                        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" name="post_id" class="form-control" value="<?php echo $get['post_id']; ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTile">Title</label>
                                <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?php echo $get['title']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> Description</label>
                                <textarea name="postdesc" class="form-control" required rows="5">
                                    <?php echo $get['description']; ?>
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCategory">Category</label>
                                <select class="form-control" name="category">
                                    <option disabled>Select Category</option>
                                    <?php
                                    $cat = "SELECT * FROM category";
                                    $res = mysqli_query($conn, $cat);
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            if ($row['category_id'] == $get['category']) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }

                                    ?>
                                            <option <?php echo $selected; ?> value="<?php echo $row['category_id'] ?>"><?php echo $row['category_name']; ?></option>

                                    <?php
                                        }
                                    } ?>

                                </select>
                                <input type="hidden" name="old_category" value="<?php echo $get['category']; ?>" />

                            </div>
                            <div class="form-group">
                                <label for="">Post image</label>
                                <input type="file" name="filetoupload">
                                <img src="upload/<?php echo $get['post_img']; ?>" height="150px">
                                <input type="hidden" name="old-image" value="<?php echo $get['post_img']; ?>">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </form>
                <?php
            }
        }

                ?>
                <!-- Form End -->
                    </div>
                </div>
            </div>
        </div>
        <?php include "footer.php"; ?>