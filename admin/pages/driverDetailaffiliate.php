<?php require ("login-securityaffiliate.php"); ?>

<?php
if (isset($_POST['email'])) {
    $driverID = $_POST['driverID'];
    $note = $_POST['note'];
    $to = $_POST['email'];
    $company_name = $_POST['company_name'];
    $from = "registrations@merchantcouriers.co.zw";
    $message = "Hello you have been invited to become a driver at $company_name\n Follow the link below.\n If you didn't apply to become a driver just ignore this email.\n http://www.merchantcouriers.co.zw/admin_companies/pages/addDriver.php?approvedDriver=$to \n\n $note";
    $headers = 'From: ' . $from;
    mail($to, 'Ivitation To Drive With Merchant Couriers', $message, $headers);

    echo "<script>alert('Invitation sent!')</script>";
    echo "<script>window.open('driver.php','_self')</script>";
}
?>

<?php require("functionaffiliate.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - Admin Area</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

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

    <?php
    if (isset($_GET['detail'])) {
        $MrE = $_GET['detail'];
        global $Connect;

        $get = "SELECT * FROM `driver` where email='$MrE' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['driverID'];
            $Name = $row_type['name'];
            $phone = $row_type['phone'];
            $email = $row_type['email'];
            $address = $row_type['address'];
            $mode_of_transport = $row_type['mode_of_transport'];
            $vehicleMake = $row_type['vehicleMake'];
            $model = $row_type['model'];
            $year = $row_type['year'];
            $engineCapacity = $row_type['engineCapacity'];
            $dob = $row_type['DOB'];
            $occupation = $row_type['occupation'];
            $regNo = $row_type['RegNo'];
            $username = $row_type['username'];
            $online = $row_type['online'];
            $profileImage = $row_type['profileImage'];
        }
    }

    ?>
    <?php
    $user = $_SESSION['MM_Username'];

    $get = "SELECT * FROM `users` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $company_name = $row_type['Name'];
        $Email = $row_type['email'];
        $phone = $row_type['phone'];
    }
    ?>


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
                <a class="navbar-brand" href="index.php">Merchant / <b><?php getUsername(); ?></b></a>
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
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i><?php getUsername(); ?></a>
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
                            <a href="driver.php"><i class="fa fa-car fa-fw"></i> Drivers</a>
                        </li>
                        <li>
                            <a href="map.php"><i class="fa fa-map-marker fa-fw"></i> Map</a>
                        </li>
                        <li>
                            <a href="integration.php"><i class="fa fa-gear fa-fw"></i> Integration</a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Driver Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <div class="list-group">
                                            <?php getDriverDetails(); ?>
                                            <?php getDriverDocs(); ?>
                                        </div>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>

                    <div>
                        <!-- /.panel -->

                    </div>

                    <!-- /.col-lg-8 -->

                    <!-- /.col-lg-4 -->

                </div>

                <div class="col-lg-4">
                    <form role="form" method="POST" action="driverDetail.php" name="driverinv">
                        <div class="form-group">
                            <p><span id="sent"></span></p>
                            <h4 class="help-block">Invite a new driver.</h4> <br />
                            <label>Email</label>
                            <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" required><br />
                            <textarea class="form-control" rows="3" type="text" name="note" placeholder="invitation note" required></textarea><br />
                            <input class="form-control" type="hidden" name="driverID" value="<?php echo $ID; ?>" placeholder="Driver ID" required>
                            <input class="form-control" type="hidden" name="company_name" value="<?php echo $company_name; ?>" required>
                            <input type="submit" name="sendinv" class="btn btn-primary btn-lg btn-block" value="Invite Drivers">
                            <p class="help-block">Only approved drivers are to be invited here.</p>
                        </div>
                    </form>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->

        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="../vendor/raphael/raphael.min.js"></script>
        <script src="../vendor/morrisjs/morris.min.js"></script>
        <script src="../data/morris-data.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
