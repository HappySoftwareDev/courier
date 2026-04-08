<?php require_once('../../config/bootstrap.php'); require_once('../../function.php'); ?>

<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<?php include("function.php") ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "AdminUpdate")) {
    $updateSQL = sprintf(
        "UPDATE `admin` SET Name=%s, Email=%s, phone=%s, Password=%s WHERE ID=%s",
        GetSQLValueString($_POST['Name'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['phone'], "text"),
        GetSQLValueString($_POST['password'], "text"),
        GetSQLValueString($_POST['ID'], "int")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($updateSQL, $Connect) or die(mysql_error());

    $updateGoTo = "profile.php";
    if ($updateGoTo) {
        echo "<script>alert('Details Updated...!')</script>";
        echo "<script>window.open('profile.php','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Manage Account</title>

</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <?php
        $user = $_SESSION['MM_Username'];
        $get = "SELECT * FROM `admin` where Email = '$user' ";

        $stmt = $DB->prepare( $get);

        foreach ($results as $1) {
            $ID = $row_type['ID'];
            $Name = $row_type['Name'];
            $Email = $row_type['Email'];
            $phone = $row_type['phone'];
            $pass = $row_type['Password'];
        }
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Manage Your Account</h1>
                        <div class="col-lg-6">
                            <form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" role="form" name="AdminUpdate" required>
                                <fieldset>
                                    <div class="form-group">

                                        <label>First name</label>
                                        <input class="form-control" name="Name" type="text" value="<?php echo $Name; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" name="email" type="email" value="<?php echo $Email; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input class="form-control" name="phone" type="tel" value="<?php echo $phone; ?>" required>
                                        <input class="form-control" name="ID" type="hidden" value="<?php echo $ID; ?>">
                                    </div><br />
                                    <h4>UPDATE PASSWORD</h4>
                                    <div class="form-group">
                                        <input class="form-control" name="password" type="text" value="<?php echo $pass; ?>" required>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Update">
                                </fieldset>
                                <input type="hidden" name="MM_insert" value="addDriver">
                                <input type="hidden" name="MM_update" value="AdminUpdate">
                            </form>
                        </div>
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

