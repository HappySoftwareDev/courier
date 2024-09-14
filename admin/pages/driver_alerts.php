<?php require ("login-security.php"); ?>

<?php require_once('../../Connections/Connect.php'); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "invite")) {
    $insertSQL = sprintf(
        "INSERT INTO `driver_alerts`(`msg`, `subject`) VALUES (%s, %s)",
        GetSQLValueString($_POST['msg'], "text"),
        GetSQLValueString($_POST['subject'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $email_to = $_POST['email'];
    $msg = $_POST['msg'];

    $from = "registrations@merchantcouriers.com";
    $subject2 = $_POST['subject'];

    $htmlContent2 = '
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>We Deliver With Speed!</h3>
        <p>Hello</p>
		<p>
	     ' . $msg . '
		</p>
		<p>If you need help talk to us <a href="www.merchantcouriers.com/contact-us.php">here.</p>
       <h3> Go to <a href="merchantcouriers.com/driver/"><b>Dashboard.</b></a></h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
        PLEASE DO NOT REPLY TO THIS EMAIL.
		</p>

		<h4 style="color:#FF8C00">Merchant Couriers</h4>
		<p>We Deliver With Speed.</p>
		</div>
		</footer>
		</div>
    </body>
    </html>';

    // Set content-type header for sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers
    $headers .= 'From: Merchant Couriers<customerservice@merchantcouriers.com>' . "\r\n";
    $headers .= 'Bcc:' . $email_to . "\r\n";

    // Send email
    mail(null, $subject2, $htmlContent2, $headers);


    echo "<script>alert('Alert sent!')</script>";
    echo "<script>window.open('driver_alerts.php','_self')</script>";

?>

<?php
if ((isset($_POST["MM_insert_sms"])) && ($_POST["MM_insert_sms"] == "invite_sms")) {
    $insertSQL = sprintf(
        "INSERT INTO `affiliate_msg`(`msg`, `subject`) VALUES (%s, %s)",
        GetSQLValueString($_POST['msg'], "text"),
        GetSQLValueString($_POST['subject'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $email_to = $_POST['email'];
    $msg = $_POST['msg'];

    $from = "registrations@merchantcouriers.com";
    $subject2 = $_POST['subject'];

    // Send email
    mail(null, $subject2, $htmlContent2, $headers);

    $sms_phone = $_POST['phone'];
    $uname = "Business";
    $pwd = "Merchant2017";
    $id = "5cb7afb730f8fefe60780e67871c117f";
    $sms_msg = "$msg";
    $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

    $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo "<script>alert('Alert sent!')</script>";
    echo "<script>window.open('driver_alerts.php','_self')</script>";

?>

<?php require("function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - Drivers</title>

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

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Driver Alerts</h1>
                        <div class="row">
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <form role="form" method="POST" name="invite" action="driver_alerts.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block">Send Email Alerts to Drivers.</p> <br />
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" placeholder="Subject" required /><br />
                                        <input type="hidden" class="form-control" name="email" placeholder="Email" value="<?php
                                                                                                                            $get = "SELECT * FROM `driver` GROUP BY email LIMIT 50";
                                                                                                                            $run = mysqli_query($Connect, $get);
                                                                                                                            while ($row_type = mysqli_fetch_array($run)) {
                                                                                                                                $Email = $row_type['email'];

                                                                                                                                echo "$Email, ";
                                                                                                                            }
                                                                                                                            ?>" />
                                        <textarea class="form-control" rows="5" name="msg" placeholder="Message" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea><br />
                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Send Email">
                                        <input type="hidden" name="MM_insert" value="invite">
                                        <p class="help-block"> Send email alerts to all drivers here.</p>
                                    </div>
                                </form>
                                <hr />

                            </div>

                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <form role="form" method="POST" name="invite_sms" action="driver_alerts.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block">Send SMS Alerts to Drivers.</p> <br />
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" placeholder="Subject" required /><br />
                                        <input type="hidden" class="form-control" name="phone" placeholder="Email" value="<?php
                                                                                                                            $get = "SELECT * FROM `driver` ";
                                                                                                                            $run = mysqli_query($Connect, $get);
                                                                                                                            while ($row_type = mysqli_fetch_array($run)) {
                                                                                                                                $phone = $row_type['phone'];

                                                                                                                                echo $e = "$phone,";
                                                                                                                            }
                                                                                                                            ?>" />
                                        <textarea class="form-control" rows="5" name="msg" placeholder="Message" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea><br />
                                        <input type="submit" name="invite_sms" class="btn btn-warning btn-lg btn-block" value="Send SMS">
                                        <input type="hidden" name="MM_insert_sms" value="invite_sms">
                                        <p class="help-block"> Send sms alerts to all drivers here.</p>
                                    </div>
                                </form>
                                <hr />

                            </div>

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Driver
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Email</th>
                                                        <th>Message</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php getDriverAlerts(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <?php
                            if (isset($_GET['delete_drAlert'])) {

                                $delete_alert = $_GET['delete_drAlert'];

                                $delet = "DELETE FROM `driver_alerts` WHERE `driver_alerts`.`id`='$delete_alert' ";

                                $run_delete = mysqli_query($Connect, $delet);

                                if ($delete_alert) {

                                    echo "<script>alert('Alert deleted')</script>";
                                    echo "<script>window.open('driver_alerts.php','_self')</script>";
                                }
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
        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
