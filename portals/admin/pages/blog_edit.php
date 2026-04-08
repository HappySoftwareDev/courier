<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "blogEditForm")) {
    $updateSQL = sprintf(
        "UPDATE blog SET Name=%s, heading=%s, category=%s, message=%s, `date`=%s WHERE ID=%s",
        GetSQLValueString($_POST['name'], "text"),
        GetSQLValueString($_POST['heading'], "text"),
        GetSQLValueString($_POST['category'], "text"),
        GetSQLValueString($_POST['message'], "text"),
        GetSQLValueString($_POST['date'], "text"),
        GetSQLValueString($_POST['id'], "int")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($updateSQL, $Connect) or die(mysql_error());

    $updateGoTo = "blog.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
}
?>

<?php require("function.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Edit Blog</title>


</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <?php

        if (isset($_GET['blogEdit'])) {

            $edit = $_GET['blogEdit'];
            $get = "SELECT * FROM `blog` where ID ='$edit' ";

            $stmt = $DB->prepare( $get);

            foreach ($results as $1) {
                $ID = $row_type['ID'];
                $name = $row_type['Name'];
                $Date = $row_type['date'];
                $heading = $row_type['heading'];
                $category = $row_type['category'];
                $msg = $row_type['message'];
                $image = $row_type['image'];
                $video = $row_type['video'];
            }
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
                            <div class="col-lg-6">
                                <form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" name="blogEditForm" enctype="multipart/form-data">
                                    <fieldset>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Enter Your Name</label>
                                                <input class="form-control" name="name" value="<?php echo $name; ?>" required type="text">
                                                <input class="form-control" name="id" value="<?php echo $ID; ?>" required type="hidden">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Heading</label>
                                                <input class="form-control" name="heading" value="<?php echo $heading; ?>" required type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <input class="form-control" name="category" value="<?php echo $category; ?>" required type="text">

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input class="form-control" value="<?php echo $Date; ?>" name="date" required type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea class="form-control" rows="6" name="message" required type="text"><?php echo $msg; ?></textarea>
                                        </div>

                                        <input type="submit" class="btn btn-lg btn-success btn-block" value="UPDATE">
                                    </fieldset>
                                    <input type="hidden" name="MM_update" value="blogEditForm">

                                </form>
                                <br><br><br>
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


