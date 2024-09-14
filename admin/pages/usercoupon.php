<?php require("function.php");

$coupons = getAllUniqueCoupon();
if (isset($_GET['delid'])) {
    deleteUserCoupon();
    header('location:usercoupon.php');
    exit;
}
if (isset($_POST['send'])) {
    if (empty($_POST['check'])) {
        echo "<script>alert('please select users to send mail');</script>";
    } else {
        sendUserMail();
    }

    // for ($i=0; $i <count($_POST['check']) ; $i++)
    // {
    //     echo $_POST['check'][$i];
    //     echo "<br>";
    // }
    // die;
}
if (isset($_GET['coupon'])) {

    $new = $_GET['phone'];

    $sms_phone = $new;
    //   $sms_phone = '+263772467352';
    $uname = "Business";
    $pwd = "Merchant2017";
    $id = "5cb7afb730f8fefe60780e67871c117f";
    $sms_msg = 'Dear client. Recieve a coupon gift for your next order with Merchant Couriers. Book a delivery on merchantcouriers.com and get a discount; coupon code is ' . $_GET['coupon'];
    $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

    $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo "<script>alert('Alert sent!')</script>";
    echo "<script>window.open('usercoupon.php','_self')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - User Coupon</title>

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

    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <script charset="UTF-8" src="//cdn.sendpulse.com/9dae6d62c816560a842268bde2cd317d/js/push/b2c0ef5ab9fba570935b51c6ba64f361_1.js" async></script>
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
        <form method="POST" action="usercoupon.php">
            <div id="page-wrapper">
                <div class="row">
                    <div>
                        <!-- /.panel -->
                        <!------------------ Jobs ----------------------->
                        <div class="tab-content">
                            <!-- /.panel -->
                            <!-- /.panel-heading -->


                            <!-- /.panel -->
                            <div>
                                <!-- /.panel -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-bar-chart-o fa-fw"></i> User Coupon List
                                    </div>
                                    <button class="btn btn-success btn-sm" name="send" id="send" style="margin-top: 10px; margin-left: 40px;">send mail</button>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table id="example" class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>ID</th>
                                                                <th>User Name</th>
                                                                <th>User Email</th>
                                                                <th>Coupon</th>
                                                                <th>Limit of use</th>
                                                                <th>Expiry Date</th>
                                                                <th>Discount</th>
                                                                <th>Share</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($coupons as $coupon) : ?>
                                                                <tr>
                                                                    <td> <input type="checkbox" name="check[]" class="check" value="<?php echo $coupon['user_coupon_id']; ?>"> </td>
                                                                    <td><?php echo $coupon['user_coupon_id']; ?></td>
                                                                    <td><?php echo $coupon['Name']; ?></td>
                                                                    <td><?php echo $coupon['email']; ?></td>
                                                                    <td><?php echo $coupon['coupon']; ?></td>
                                                                    <td><?php echo $coupon['limit_used']; ?></td>
                                                                    <td><?php echo $coupon['expiry_date']; ?></td>
                                                                    <td><?php echo $coupon['amount'];
                                                                        if ($coupon['type'] == 1) {
                                                                            echo "%";
                                                                        }
                                                                        ?>

                                                                    </td>
                                                                    <td>
                                                                        <a href="https://api.whatsapp.com/send?text=Hie <?php echo $coupon['Name']; ?> Here's your coupon gift from Merchant Couriers <?php echo $coupon['coupon']; ?>Book a delivery online at merchantcouriers.com enter coupon and get a discount.We Deliver with Speed!"><img src="blog_images/whats.png"></a>

                                                                        <!--  <a href="whatsapp://send?text=Hie <?php echo $coupon['Name']; ?> Here's your coupon gift from Merchant Couriers <?php echo $coupon['coupon']; ?>Here's your coupon gift from Merchant Couriers <?php echo $coupon['coupon']; ?>Book a delivery online at merchantcouriers.com enter coupon and get a discount. We Deliver with Speed!"> -->
                                                                        <!-- <img src="blog_images/whats.png"></a> -->
                                                                        <a href="usercoupon.php?coupon=<?php echo $coupon['coupon']; ?>&phone=<?php echo $coupon['phone']; ?>" class="btn btn-info btn-sm">
                                                                            send message
                                                                        </a>
                                                                    </td>
                                                                    <td><a href="editcoupon.php?editid=<?php echo $coupon['user_coupon_id']; ?>" class="btn btn-info fa fa-pencil"></a>
                                                                        <a href="usercoupon.php?delid=<?php echo $coupon['user_coupon_id']; ?>" class="btn btn-danger fa fa-trash" onclick="return confirm('are you sure to delete this coupon?')"></a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
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
                                <!-- /.panel -->

                                <!-- /.panel -->
                            </div>
                        </div>




                    </div>
                    <!-- /.row -->
                </div>
                <!-- /#page-wrapper -->

            </div>
        </form>
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

        <script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable();


            });
        </script>

</body>

</html>