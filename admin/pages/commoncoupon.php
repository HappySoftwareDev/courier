<?php require_once('../../Connections/Connect.php');

require("function.php");

$coupons = getAllCommonCoupon();

if (isset($_GET['editid'])) {
    $single = getCommonCoupon();
}
if (isset($_GET['coupon'])) {
    $phone = getusersPhone();
    $new = json_encode($phone);



    $sms_phone = $new;
    $uname = "Business";
    $pwd = "Merchant2017";
    $id = "5cb7afb730f8fefe60780e67871c117f";
    $sms_msg = 'Dear client. Recieve a coupon gift for your next order with Merchant Couriers. Book a delivery on merchantcouriers.com and get a discount; coupon code is' . $_GET['coupon'];
    $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

    $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo "<script>alert('Alert sent!')</script>";
    echo "<script>window.open('commoncoupon.php','_self')</script>";
}
if (isset($_GET['delid'])) {
    deleteCommonCoupon();
    header('location:commoncoupon.php');
    exit;
}
// var_dump($single);
// die;

if (isset($_POST['update'])) {
    updateCommonCoupon();
    header('location:commoncoupon.php');
    exit;
}
if (isset($_POST['submit'])) {

    storeCommonCoupon();
    header('location:commoncoupon.php');
    exit;
}
if (isset($_GET['mailid'])) {
    sendCommonCouponMail();
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

    <title>Merchant Couriers - Coupon Promotions</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div id="wrapper">
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

        <div id="page-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Generate A Common Coupon For All Users</h3>
                            </div>
                            <div class="panel-body">
                                <form action="" method="POST" role="form" name="">
                                    <fieldset>
                                        <div class="form-group">
                                            <label>
                                                <h4>Coupon Info</h4>
                                            </label><br />
                                        </div>
                                        <div class="form-group">
                                            <label>Limit of use</label>
                                            <input class="form-control" name="limit" type="number" value="<?php if (isset($single)) {   echo $single['limit_used']; } ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Discount in</label>
                                            <input class="" name="type" type="radio" value="1" style="margin-left:20px; " <?php if (isset($single)) {                                                                                                 if ($single['type'] == 1) {
                                                                                                                                    echo "checked";
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>Percentage
                                            <input class="" name="type" type="radio" value="2" style="margin-left:20px; " <?php if (isset($single)) {
                                                                                                                                if ($single['type'] == 2) {
                                                                                                                                    echo "checked";
                                                                                                                                }
                                                                                                                            } ?>>Amount
                                        </div>
                                        <div class="form-group">
                                            <label>% or amount</label>
                                            <input class="form-control" name="amount" type="number" value="<?php if (isset($single)) {
                                                                                                                echo $single['amount'];
                                                                                                            } ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Coupon</label>
                                            <input class="form-control" name="coupon" id="coupon" type="text" value="<?php if (isset($single)) {
                                                                                                                            echo $single['coupon'];
                                                                                                                        } ?>" required>
                                            <button class="btn btn-block btn-xm btn-info" type="button" onclick="makeid()">Generate Coupon</button>
                                        </div>
                                        <div class="form-group">
                                            <label>Expiry Date</label>
                                            <input class="form-control" name="expiry_date" type="date" value="<?php if (isset($single)) {
                                                                                                                    echo $single['expiry_date'];
                                                                                                                } ?>" required>

                                        </div>
                                        <?php if (isset($single)) : ?>
                                            <input type="hidden" name="id" value="<?php echo $single['id']; ?>">

                                            <!-- Change this to a button or input when using this as a form -->
                                            <input type="submit" class="btn btn-lg btn-success btn-block" name="update" value="Update">
                                        <?php else : ?>
                                            <input type="submit" class="btn btn-lg btn-success btn-block" name="submit" value="Submit">
                                        <?php endif; ?>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Common Coupon List
                                </div>

                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
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
                                                                <td><?php echo $coupon['id']; ?></td>
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
                                                                    <a href="commoncoupon.php?coupon=<?php echo $coupon['coupon']; ?>" class="btn btn-info">
                                                                        send message
                                                                    </a>
                                                                    <a href="http://www.facebook.com/dialog/feed?
app_id=681106672510251&
link=http://developers.facebook.com/docs/reference/dialogs/&
picture=http://fbrell.com/f8.jpg&
name=Facebook%20Dialogs&
caption=Reference%20Documentation&
description=Dialogs%20provide%20a%20simple,%20consistent%20interface%20for%20applications%20to%20interact%20with%20users.&
message=Facebook%20Dialogs%20are%20so%20easy!&
redirect_uri=http://www.example.com/response"> share</a>
                                                                    <!-- <a href="#"><img src="blog_images/facebook.png" width="30"></a> -->
                                                                    <!-- <div class="fb-share-button" data-href="https://merchantcouriers.com/" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmerchantcouriers.com%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div> -->
                                                                    <a href="commoncoupon.php?mailid=<?php echo $coupon['id']; ?>" class="btn btn-success btn-xs" name="send" id="send" style="margin-bottom: 12px;"> <img src="blog_images/gmail.png" width="20"> send mail</a>
                                                                </td>
                                                                <td><a href="commoncoupon.php?editid=<?php echo $coupon['id']; ?>" class="btn btn-info fa fa-pencil"></a>
                                                                    <a href="commoncoupon.php?delid=<?php echo $coupon['id']; ?>" class="btn btn-danger fa fa-trash" onclick="return confirm('are you sure to delete this coupon?')"></a>
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
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2({
                placeholder: "Please select a client",
                allowClear: true
            });
        });

        function makeid() {
            $('#coupon').val('');
            var length = 10;
            var result = '';
            var characters = 'ABCDE0077FGHIJKLMNOPQRSTUVW555Zabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#coupon').val(result);
        }
    </script>

    <!-- jQuery -->
    <!--    <script src="../vendor/jquery/jquery.min.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

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
