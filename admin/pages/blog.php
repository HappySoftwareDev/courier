<?php require ("login-security.php"); ?>

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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Merchant Couriers</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">

                        <?php getChatAlert(); ?>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="message.php">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">

                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $logoutAction ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-users fa-fw"></i> Users</a>
                        </li>
                        <li>
                            <a href="invite.php"><i class="fa fa-users fa-fw"></i> Invite</a>
                        </li>
                        <li>
                            <a href="driver.php"><i class="fa fa-car fa-fw"></i> Drivers</a>
                        </li>
                        <li>
                            <a href="map.php"><i class="fa fa-map-marker fa-fw"></i> Map</a>
                        </li>
                        <li>
                            <a href="integration.php"><i class="fa fa-gear fa-fw"></i> Integration</a>
                        </li>
                        <li>
                            <a href="blog.php"><i class="fa fa-list fa-fw"></i> Blog</a>
                        </li>
                        <li>
                            <a href="affiliate.php"><i class="fa fa-bullhorn fa-fw"></i> Affiliate</a>
                        </li>
                        <li class="">
                            <a href="coupons.php"><i class="fa fa-gear fa-fw"></i> coupons</a>
                        </li>
                        <li class="">
                            <a href="usercoupon.php"><i class="fa fa-gear fa-fw"></i> All Users coupons</a>
                        </li>
                        <li class="">
                            <a href="commoncoupon.php"><i class="fa fa-gear fa-fw"></i> Common coupons</a>
                        </li>
                        <li>
                            <a href="affiliate.msg.php"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Affiliate Help</a>
                        </li>
                        <li>
                            <a href="customer_alerts.php"><i class="fa fa-bell fa-fw"></i> Send Alerts</a>
                        </li>
                        <li>
                            <a href="api.php"><i class="fa fa-gear fa-fw"></i> API keys</a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <?php
        $get = "SELECT * FROM `prizelist`";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
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

        <!-- jQuery -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
