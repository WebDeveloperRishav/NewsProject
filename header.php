<?php
include 'admin/config.php';
$page = basename($_SERVER['PHP_SELF']);
switch ($page) {
    case "single.php":
        if (isset($_REQUEST['id'])) {
            $sql = "SELECT * FROM post where post_id = {$_REQUEST['id']}";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $page_title = $row['title'];
        } else {
            $page_title = "No Post Found";
        }
        break;
    case "category.php";
        if (isset($_REQUEST['id'])) {
            $sql = "SELECT * FROM category where category_id = {$_REQUEST['id']}";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $page_title = $row['category_name'] . " " . "News";
        } else {
            $page_title = "No Post Found";
        }
        break;
    case "author.php":
        if (isset($_REQUEST['id'])) {
            $sql = "SELECT * FROM user where user_id = {$_REQUEST['id']}";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $page_title = "News By: " . $row['first_name'] . " " . $row['last_name'];
        } else {
            $page_title = "No Post Found";
        }
        break;
    case "search.php":
        if (isset($_REQUEST['search'])) {
            $page_title = $_REQUEST['search'];
        } else {
            $page_title = "No Post Found";
        }
        break;

    case "index.php":
        $page_title =  "News Site";
        break;
    default:
        $page_title =  "News Site";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <?php
                    $getlogo = "SELECT * FROM settings";
                    $logores = mysqli_query($conn, $getlogo);
                    if (mysqli_num_rows($logores) > 0) {
                        while ($row1 = mysqli_fetch_assoc($logores)) {
                            if ($row1['logo'] == "") {
                                echo "<h1><a href='index.php'>{$row1['websitename']}</a></h1>";
                            } else {
                                echo "<a href='index.php' id='logo'><img src='admin/images/{$row1['logo']}'></a>";
                            }
                        }
                    }

                    ?>

                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class='menu'>
                        <li><a href='index.php'>Home</a></li>
                        <?php
                        include 'admin/config.php';
                        if (isset($_REQUEST['id'])) {
                            $catid = $_REQUEST['id'];
                        }
                        $getcat = "SELECT * FROM category WHERE post > 0";
                        $result = mysqli_query($conn, $getcat);
                        $active = '';
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if (isset($_REQUEST['id'])) {
                                    if ($row['category_id'] == $catid) {
                                        $active = 'active';
                                    } else {
                                        $active = '';
                                    }
                                }

                        ?>
                                <li><a class="<?php echo $active; ?>" href='category.php?id=<?php echo $row['category_id'] ?>'><?php echo $row['category_name']; ?></a></li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->