<?php require ("login-security.php"); ?>

<?php require("function.php"); ?>

<?php include ('site_settings.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $site_name ?> - Admin Area</title>

    <!-- Bootstrap Coresite_name CSS -->
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
    <!--<script charset="UTF-8" src="//cdn.sendpulse.com/9dae6d62c816560a842268bde2cd317d/js/push/b2c0ef5ab9fba570935b51c6ba64f361_1.js" async></script>-->
    
    <!--Firebase Push-->
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-messaging.js"></script>
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
                        <li><a href="site_management.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
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

                        <li>
                            <a href="api_users.php"><i class="fa fa-gear fa-fw"></i> API Users</a>
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
                    <h1 class="page-header">Dashboard </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-2">
                                    <i class="fa fa-usd fa-5x"></i>
                                </div>
                                <div class="col-xs-10 text-right">
                                    <div class="huge"><?php getCountTotalSales(); ?> </div>
                                    <div>Total USD Sales</div>
                                </div>
                            </div>
                        </div>
                        <!--<a href="seller_orders.php?more=<?php echo $seller_email; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>-->
                        </a>
                    </div>
                </div>
                <!--<div class="col-lg-3 col-md-6">-->
                <!--    <div class="panel panel-primary">-->
                <!--<div class="panel-heading">-->
                <!--    <div class="row">-->
                <!--        <div class="col-xs-2">-->
                <!--            <i class="fa fa-usd fa-5x"></i>-->
                <!--        </div>-->
                <!--        <div class="col-xs-10 text-right">-->
                <div class="huge"><?php //getCountTotalRTGSSales(); 
                                    ?></div>
                <!--            <div>Total RTGS Sales</div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<a href="seller_orders.php?more=<?php echo $seller_email; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>-->
                <!--        </a>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php getCountAllSellers(); ?></div>
                                    <div>Business Partners</div>
                                </div>
                            </div>
                        </div>
                        <!-- <a href="sellers.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div> -->
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php getCountNewOrders();  ?></div>
                                    <div>New Orders!</div>
                                </div>
                            </div>
                        </div>
                        <!-- <a href="seller_orders.php?more=<?php echo $seller_email; ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div> -->
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-car fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php getCountAllDrivers(); ?></div>
                                    <div>Drivers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-history fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>Total Orders!</div>
                                    <div class="huge"><?php getCountAllOrders();  ?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-times fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>Cancelled Orders!</div>
                                    <div class="huge"><?php getCountCancelledOrders();  ?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-download fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>App Downloads</div>
                                    <div><b>Booking App <?php getCountDownloadsb();  ?></b></div>
                                    <div><b>Driver App <?php getCountDownloadsd();  ?></b></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div>
                    <!-- /.panel -->
                    <!------------------ Jobs ----------------------->
                    <div class="tab-content">
                        <!-- /.panel -->
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Job Number</th>
                                                    <th>Date</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Invoice</th>
                                                    <th>Status</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php getBookings(); ?>
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
                        <!-- /.panel -->
                        <!------------------ /Jobs ----------------------->
                        <!-- /.panel -->

                        <!-- /.panel -->
                        <div>
                            <!-- /.panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Clients List
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table id="clients_Ac" class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Business Name</th>
                                                            <th>Business Type</th>
                                                            <th>Business Location</th>
                                                            <th>Contact Name</th>
                                                            <th>Details</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php getBusinessPartner(); ?>
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

                    <!-- /.col-lg-8 -->
                    <div class="col-lg-4">

                        <!-- /.panel -->
                        <div class="chat-panel panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-comments fa-fw"></i> Messages
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-chevron-down"></i>
                                    </button>

                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <ul class="chat">
                                    <?php getContacts(); ?>
                                </ul>
                            </div>
                            <!-- /.panel-body -->
                            <div class="panel-footer">

                            </div>
                            <!-- /.panel-footer -->
                        </div>
                        <!-- /.panel .chat-panel -->
                    </div>
                    <!-- /.col-lg-4 -->

                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bell fa-fw"></i> Messages From Drivers
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="list-group">
                                    <?php getChats(); ?>

                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        
        <!--Firebase Push-->
    <script>
    var firebaseConfig = {
        apiKey: "AIzaSyCSNGUwzJ0iXTz01MAWsfec5jbTWvbCYC8",
		authDomain: "merchant-booking.firebaseapp.com",
		databaseURL: "https://merchant-booking.firebaseio.com",
		projectId: "merchant-booking",
		storageBucket: "merchant-booking.appspot.com",
		messagingSenderId: "909204433162",
		appId: "1:909204433162:web:cd5165ba87c3e131ccb2f3"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging=firebase.messaging();

    function IntitalizeFireBaseMessaging() {
        messaging
            .requestPermission()
            .then(function () {
                console.log("Notification Permission");
                return messaging.getToken();
            })
            .then(function (token) {
                console.log("Token : "+token);
                // document.getElementById("token").innerHTML=token;
                $.ajax({
                url: 'save_token.php',
                type: 'POST',
                data: 'token=' + token,
                success: function(result) {
                    if(result == "OK"){
                        console.log("token saved");
                    }
                    else if(result == "exist"){
                        console.log("token already exist")
                    };
                }
                 });
            })
            .catch(function (reason) {
                console.log(reason);
            });
    }

    messaging.onMessage(function (payload) {
        console.log(payload);
        const notificationOption={
            body:payload.notification.body,
            icon:payload.notification.icon
        };

        if(Notification.permission==="granted"){
            var notification=new Notification(payload.notification.title,notificationOption);

            notification.onclick=function (ev) {
                ev.preventDefault();
                window.open(payload.notification.click_action,'_blank');
                notification.close();
            }
        }

    });
    messaging.onTokenRefresh(function () {
        messaging.getToken()
            .then(function (newtoken) {
                console.log("New Token : "+ newtoken);
            })
            .catch(function (reason) {
                console.log(reason);
            })
    })
    IntitalizeFireBaseMessaging();
</script>
<!--End Firebase Push-->
        
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
            $(document).ready(function() {
                $('#preBk').DataTable();
            });
            $(document).ready(function() {
                $('#doneJ').DataTable();
            });
            $(document).ready(function() {
                $('#liveJ').DataTable();
            });
            $(document).ready(function() {
                $('#cancelledJ').DataTable();
            });
            $(document).ready(function() {
                $('#clients_Ac').DataTable();
            });
        </script>

</body>

</html>
