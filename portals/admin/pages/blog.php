<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Video_blogForm")) {
    $name_image = $_FILES['image']['name'];
    $tmp_name_array = $_FILES['image']['tmp_name'];
    $type_array = $_FILES['image']['type'];
    $size_array = $_FILES['image']['size'];
    move_uploaded_file($tmp_name_array, "blog_videos/cover_image/$name_image");

    $name_video = $_FILES['video']['name'];
    $tmp_name_array = $_FILES['video']['tmp_name'];
    $type_array = $_FILES['video']['type'];
    $size_array = $_FILES['video']['size'];
    move_uploaded_file($tmp_name_array, "blog_videos/$name_video");
    $insertSQL = sprintf(
        "INSERT INTO video_blog (Title, Video, image, `Description`, `Date`) VALUES (%s, '$name_video', '$name_image', %s, %s)",
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['description'], "text"),
        GetSQLValueString($_POST['date'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $insertGoTo = "blog.php";
    if ($insertGoTo) {
        echo "<script>alert('Video uploaded!')</script>";
        echo "<script>window.open('blog.php','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "blog")) {
    $name_image = $_FILES['image']['name'];
    $tmp_name_array = $_FILES['image']['tmp_name'];
    $type_array = $_FILES['image']['type'];
    $size_array = $_FILES['image']['size'];
    move_uploaded_file($tmp_name_array, "blog_images/$name_image");

    $insertSQL = sprintf(
        "INSERT INTO blog (Name, heading, category, message, `date`, image) VALUES (%s, %s, %s, %s, %s, '$name_image')",
        GetSQLValueString($_POST['name'], "text"),
        GetSQLValueString($_POST['heading'], "text"),
        GetSQLValueString($_POST['category'], "text"),
        GetSQLValueString($_POST['message'], "text"),
        GetSQLValueString($_POST['date'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $insertGoTo = "blog.php";
    if ($insertGoTo) {
        echo "<script>alert('blog uploaded!')</script>";
        echo "<script>window.open('blog.php','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
}
?>

<?php require("function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Post Blogs</title>

    

</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <?php
        $get = "SELECT * FROM `prizelist`";

        $stmt = $DB->prepare( $get);

        foreach ($results as $1) {
            $ID = $row_type['ID'];
            $Car_per_km = $row_type['Car_per_km'];
            $Weight = $row_type['Weight'];
            $Cost_per_item = $row_type['Cost_per_item'];
            $Insurance = $row_type['Insurance'];
            $Base_price = $row_type['Base_price'];
            $Price_per_km = $row_type['Price_per_km'];
        }

        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Blog</h1>
                        <div class="row">

                            <!-- /.col-lg-6 -->
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <i class="fa fa-list fa-fw"></i> Blog Form
                                        </div>
                                        <div class="panel-body">
                                            <!-- /.panel-heading -->

                                            <form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" name="blog" enctype="multipart/form-data">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label>Enter Your Name</label>
                                                        <input class="form-control" name="name" required type="text">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Heading</label>
                                                        <input class="form-control" name="heading" required type="text">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Category</label>
                                                            <select class="form-control" name="category" required>
                                                                <option></option>
                                                                <option>Updates</option>
                                                                <option>News</option>
                                                                <option>Press Release</option>
                                                                <option>Promotions</option>
                                                                <option>Advertising</option>
                                                                <option>Tutorials</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Date (Aug 03 2017)</label>
                                                            <input class="form-control" name="date" required type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Image</label>
                                                        <input class="form-control" name="image" required type="file">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Message</label>
                                                        <textarea class="form-control" rows="6" name="message" required type="text"></textarea>
                                                    </div>

                                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Post">
                                                </fieldset>
                                                <input type="hidden" name="MM_insert" value="blog">

                                            </form>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <i class="fa fa-list fa-fw"></i> Blog List
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="list-group">
                                                <?php getBlog(); ?>
                                            </div>
                                            <!-- /.list-group -->

                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-list fa-fw"></i> Video Form
                                    </div>
                                    <div class="panel-body">
                                        <!-- /.panel-heading -->
                                        <form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" name="Video_blogForm" enctype="multipart/form-data">
                                            <fieldset>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Enter Video Title</label>
                                                        <input class="form-control" name="title" required type="text">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Date (Aug 03 2017)</label>
                                                        <input class="form-control" name="date" required type="text">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Cover Image</label>
                                                        <input class="form-control" name="image" required type="file">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Video</label>
                                                        <input class="form-control" name="video" type="file">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Video Description</label>
                                                    <textarea class="form-control" rows="6" name="description" required type="text"></textarea>
                                                </div>

                                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Upload Video">
                                            </fieldset>
                                            <input type="hidden" name="MM_insert" value="blog">
                                            <input type="hidden" name="MM_insert" value="Video_blogForm">

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php

                            if (isset($_POST['email'])) {

                                $email = $_POST['email'];

                                $email_from = 'admin@merchantcouriers.co.zw';
                                $email_to = $email;
                                $subject = '<img src="//images/logo.png" alt="logo">';
                                $message = 'Hi!\n Merchant Couriers has invited you to signup to become an admin.\n\n <a href="adminUsers.php">Click here</a> to enter your details.';

                                $body = 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;

                                $success = @mail($email_to, $subject, $body, 'From: <' . $email_from . '>');
                                echo '<script>document.getElementById("sent").innerHTML="Invitation sent successfully!"</script>';
                            }

                            ?>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


