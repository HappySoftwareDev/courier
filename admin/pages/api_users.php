<?php include_once('db.php'); ?>

<?php require ("login-security.php"); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "blogEditForm")) {
    $con_af = @mysqli_connect("localhost", "merchant_admin", "}{kTftfu1449", "merchant_db");
    $updateSQL = sprintf(
        "UPDATE `affiliate_payouts` SET `amount_paid`=%s,`status`=%s WHERE `affiliate_no`=%s",
        GetSQLValueString($_POST['amount'], "text"),
        GetSQLValueString($_POST['status'], "text"),
        GetSQLValueString($_POST['affiliate_no'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($updateSQL, $Connect) or die(mysql_error());

    $affialte_no = $_POST['affiliate_no'];
    $amount = $_POST['amount'];
    $get = "SELECT * FROM `affilate_user` WHERE affialte_no='$affialte_no'";
    $run = mysqli_query($con_af, $get);
    while ($row_type = mysqli_fetch_array($run)) {
        $Name = $row_type['name'];
        $aff_email = $row_type['email'];
    }

    $email_to = "merchantcouriers1@gmail.com";

    $subject = "Payment Confirmation";
    $htmlContent2 = '
    <html>
    <head>
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>We Deliver With Speed!</h3>
		<p>
	     Hello
	     </p>
	     <p>
	     This is a confirmation that ' . $Name . ' received a payment of $' . $amount . '
		</p>

       <h3> Go to <a href="merchantcouriers.co.zw/admin"><b>Dashboard.</b></a></h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
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
    $headers .= 'From: Merchant Couriers<admin@merchantcouriers.co.zw>' . "\r\n";
    $headers .= 'Bcc:bamhara1@gmail.com' . "\r\n";

    // Send email
    if (mail($email_to, $subject, $htmlContent2, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $htmlContent = '
    <html>
    <head>
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>We Deliver With Speed!</h3>
		<p>
	     Hello ' . $Name . '
	     </p>
	     <p>
	     This is a confirmation that you received a payment of $' . $amount . ' if you didn`t get any payment don`t hesitate to contact us.
		</p>

       <h3> Go to <a href="merchantcouriers.co.zw/affiliate.user/"><b>Dashboard.</b></a></h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
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
    $headers .= 'From: Merchant Couriers<admin@merchantcouriers.co.zw>' . "\r\n";
    $headers .= 'Bcc:customerservice@merchantcouriers.co.zw' . "\r\n";

    // Send email
    if (mail($aff_email, $subject, $htmlContent, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $updateGoTo = "affiliate.php";
    if ($updateGoTo) {
        echo "<script>alert('Payment status updated!')</script>";
        echo "<script>window.open('affiliate.php','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
}
?>
<?php require("function.php");

if (isset($_GET['ban']) && $_GET['ban'] !== "") {
    // var_dump('ededededed'); die;
    $id = $_GET['ban'];
    update_API_user($id, 'ban');
    header('Location:api_users.php');
}
if (isset($_GET['active']) && $_GET['active'] !== "") {
    $id = $_GET['active'];
    update_API_user($id, 'active');
    header('Location:api_users.php');
}

if (isset($_GET['del']) && $_GET['del'] !== "") {
    $id = $_GET['del'];
    delete_API_user($id);
    header('Location:api_users.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
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
                            <a href="driver.php"><i class="fa fa-car fa-fw"></i> Drivers</a>
                        </li>
                        <li>
                            <a href="map.php"><i class="fa fa-map-marker fa-fw"></i> Map</a>
                        </li>
                        <li>
                            <a href="integration.php"><i class="fa fa-gear fa-fw"></i> Integration</a>
                        </li>
                        <li>
                            <a href="affiliate.php"><i class="fa fa-bullhorn fa-fw"></i> Affiliate</a>
                        </li>
                        <li>
                            <a href="affiliate.alerts.php"><i class="fa fa-bell fa-fw"></i> Affiliate Alerts</a>
                        </li>
                        <li>
                            <a href="affiliate.msg.php"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Affiliate Help</a>
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
                        <h1 class="page-header">Manage API Users</h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">

                    <div class="col-lg-4 col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-usd fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php getCountTotalAPIEarned(); ?></div>
                                        <div>Total Bookings</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <!--<span class="pull-left">Total Payouts</span>-->
                                    <!--<span class="pull-right"><i class="fa fa-usd"></i><?php getCountTotalAPIEarned(); ?></span>-->
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user-plus fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php getCountAPIUsers(); ?></div>
                                        <div>Total API Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="sellers.php">
                                <div class="panel-footer">
                                    <!--<span class="pull-left">View Details</span>-->
                                    <!--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php getCountAPIUserOrders();  ?></div>
                                        <div>Total Orders!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="seller_orders.php?more=<?php echo $seller_email; ?>">
                                <div class="panel-footer">
                                    <!--<span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!--<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php getCountAffilateClients(); ?></div>
                                    <div>Total Registered</div>
                                </div>
                            </div>
                        </div>
                        <a href="driver.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>-->
                    <!--<div class="col-lg-12 col-md-12">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-history fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>Total Shares!</div>
                                    <div class="huge"><?php getCountAffilateShares();  ?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>-->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                API Users
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive table-bordered">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Stores</th>
                                                <th>join date</th>
                                                <th>Orders</th>
                                                <!--<th>Balance</th>-->
                                                <th>Contact</th>
                                                <th>Address</th>
                                                <!-- <th>Request</th> -->
                                                <th>Action</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $data = getApiUsers(); ?>
                                            <?php //var_dump($data); 
                                            ?>
                                            <?php foreach ($data as $item) : ?>
                                                <?php
                                                $stores = getUserStores($item['id']);
                                                $orders = getUserorders($item['id']);
                                                ?>
                                                <tr>
                                                    <td><?= $item['business_name'] ?></td>
                                                    <td><?= $stores ?></td>
                                                    <td><?= $item['join_date'] ?></td>
                                                    <td><?= $orders ?></td>
                                                    <!--<td>Balance</td>-->
                                                    <td><?= $item['business_email'] ?>
                                                        <br>
                                                        <?= $item['business_phone'] ?>
                                                    </td>
                                                    <td><?= $item['address'] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($item['status'] == 'active') :
                                                        ?>
                                                            <a href="api_users.php?ban=<?= $item['id'] ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ban this user?')">
                                                                <i class="fa fa-ban"></i>
                                                            </a>
                                                        <?php else : ?>
                                                            <a href="api_users.php?active=<?= $item['id'] ?>" class="btn btn-xs btn-success">
                                                                <i class="fa fa-check-circle"></i>
                                                            </a>
                                                        <?php endif; ?> |

                                                        <a href="api_users.php?del=<?= $item['id'] ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure delete this user?')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>

                                        </tbody>
                                    </table>

                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                        <?php
                        if (isset($_GET['block_aff'])) {

                            $block_aff = $_GET['block_aff'];

                            $get = "SELECT * FROM `affilate_user` WHERE `affialte_no`='$block_aff'";
                            $run = mysqli_query($Connect, $get);
                            while ($row_type = mysqli_fetch_array($run)) {
                                $ID = $row_type['id'];
                                $password = $row_type['password'];
                                $u = "b10ck3d";
                            }
                            $delet = "UPDATE `affilate_user` SET `password`='$u', reserve='$password' WHERE `affilate_user`.`affialte_no`='$block_aff' ";

                            $run_delete = mysqli_query($Connect, $delet);

                            if ($block_aff) {

                                echo "<script>alert('Affiliate Blocked!')</script>";
                                echo "<script>window.open('affiliate.php','_self')</script>";
                            }
                        }

                        if (isset($_GET['unblock_aff'])) {

                            $block_aff = $_GET['unblock_aff'];

                            $get = "SELECT * FROM `affilate_user` WHERE `affialte_no`='$block_aff'";
                            $run = mysqli_query($Connect, $get);
                            while ($row_type = mysqli_fetch_array($run)) {
                                $reserve = $row_type['reserve'];
                            }
                            $delet = "UPDATE `affilate_user` SET `password`='$reserve' WHERE `affilate_user`.`affialte_no`='$block_aff' ";

                            $run_delete = mysqli_query($Connect, $delet);

                            if ($block_aff) {

                                echo "<script>alert('Affiliate Unblocked!')</script>";
                                echo "<script>window.open('affiliate.php','_self')</script>";
                            }
                        }
                        ?>


                    </div>

                    <!-- /.col-lg-6 -->
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
