<?php require ("login-security.php"); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$sResponse = "";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "invite")) {
    $myFile = "keys.json";
    $myFilea = "../keys.json";
    file_put_contents($myFile, json_encode($_POST));
    file_put_contents($myFilea, json_encode($_POST));
    $sResponse = '<div class="alert alert-success">Record Updated Successfully</div>';
}

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
                        <h1 class="page-header">Manage APIs</h1>
                        <div class="row">
                            <?php
                            echo $sResponse;
                            $aData = json_decode(file_get_contents("keys.json"));
                            // echo "<pre>" . print_r($aData, true) . "</pre>";
                            $stripePk = !empty($aData->stripePk) ? $aData->stripePk : "";
                            $stripeSk = !empty($aData->stripeSk) ? $aData->stripeSk : "";
                            $paynowIk = !empty($aData->paynowIk) ? $aData->paynowIk : "";
                            $paynowId = !empty($aData->paynowId) ? $aData->paynowId : "";
                            $paypalid = !empty($aData->paypalid) ? $aData->paypalid : "";
                            $mapApi = !empty($aData->mapApi) ? $aData->mapApi : "";
                            $smsID = !empty($aData->smsId) ? $aData->smsId : "";
                            $smsUsername = !empty($aData->smsUsername) ? $aData->smsUsername : "";
                            $smsPwd = !empty($aData->smsPwd) ? $aData->smsPwd : "";

                            $twiliosmsID = !empty($aData->twiliosmsID) ? $aData->twiliosmsID : "";
                            $twiliosmsUsername = !empty($aData->twiliosmsUsername) ? $aData->twiliosmsUsername : "";
                            $twilioPhoneNumber = !empty($aData->twilioPhoneNumber) ? $aData->twilioPhoneNumber : "";
                            ?>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-12">
                                <form role="form" method="POST" name="invite" action="api.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block"></p>

                                        <div class="panel panel-default">
                                            <!-- .panel-heading -->
                                            <div class="panel-body">
                                                <div class="panel-group" id="accordion">
                                                    <!----------Strip Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Stripe API</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse in">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="stripe_handle" id="stripe_handle" <?php echo ($aData->stripe_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show Stripe
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="stripe_handle" id="stripe_handle" <?php echo ($aData->stripe_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide Stripe
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Stripe Publish Key</label>
                                                                        <input type="text" class="form-control" value="<?php echo $stripePk; ?>" name="stripePk" placeholder="Enter Stripe Publish Key" required /><br />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Stripe Secret Key</label>
                                                                        <input type="text" class="form-control" value="<?php echo $stripeSk; ?>" name="stripeSk" placeholder="Enter Stripe Secret Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Strip End --------->

                                                    <!----------Paynow Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Paynow API</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paynow_handle" id="paynow_handle" <?php echo ($aData->paynow_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show PayNow
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paynow_handle" id="paynow_handle" <?php echo ($aData->paynow_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide PayNow
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>PayNow Integration ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paynowId; ?>" name="paynowId" placeholder="Enter PayNow Integration ID" required /><br />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>PayNow Integration ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paynowIk; ?>" name="paynowIk" placeholder="Enter PayNow Integration Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/PayNow End --------->

                                                    <!----------Paypal Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">PayPal API</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseThree" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paypal_handle" id="paypal_handle" <?php echo ($aData->paypal_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show Paypal
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paypal_handle" id="paypal_handle" <?php echo ($aData->paypal_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide Paypal
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Paypal ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paypalid; ?>" name="paypalid" placeholder="Enter PayNow Integration Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Paypal End --------->

                                                    <!----------Google Maps Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Google Maps API</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFour" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Google Map API</label>
                                                                        <input type="text" class="form-control" value="<?php echo $mapApi; ?>" name="mapApi" placeholder="Enter Google Map API Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Google Maps End --------->

                                                    <!----------Bulk SMS Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Bulk SMS API</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFive" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsID; ?>" name="smsId" placeholder="Enter SMS ID" required /><br />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS Username</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsUsername; ?>" name="smsUsername" placeholder="Enter SMS Username" required />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS Password</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsPwd; ?>" name="smsPwd" placeholder="Enter SMS Password" required /> <br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Bulk SMS End --------->

                                                    <!----------Twilio Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">Twilio SMS API</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseSix" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="twilio_handle" id="twilio_handle" <?php echo ($aData->twilio_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Active
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="twilio_handle" id="twilio_handle" <?php echo ($aData->twilio_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Deactivate
                                                                        </label>

                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Account SID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twiliosmsID; ?>" name="twiliosmsID" placeholder="Enter SMS ID" required /><br />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Auth Token</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twiliosmsUsername; ?>" name="twiliosmsUsername" placeholder="Enter SMS Username" required />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Phone Number</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twilioPhoneNumber; ?>" name="twilioPhoneNumber" placeholder="Enter SMS Password" required /> <br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Twilio End --------->

                                                    <div class="col-lg-6 pull-right">
                                                        <br /><br />
                                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Submit">
                                                        <input type="hidden" name="MM_insert" value="invite">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </form>
                                <hr />

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
