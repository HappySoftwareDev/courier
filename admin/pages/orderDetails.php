<?php require ("login-security.php"); ?>

<?php
require("function.php");

define('DBhost', 'localhost');
define('DBuser', 'kundaita_mc_user');
define('DBname', 'kundaita_mc_db');
define('DBpass', '#;H}MXNXx(kB');

try {

    $DB_con = new PDO("mysql:host=" . DBhost . ";dbname=" . DBname, DBuser, DBpass);
} catch (PDOException $e) {

    die($e->getMessage());
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

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Order Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php
            if (isset($_GET['orderD'])) {
                $MrE = $_GET['orderD'];

                $get = "SELECT * FROM `bookings` WHERE order_id = '$MrE' ";

                $run = mysqli_query($Connect, $get);

                while ($row_type = mysqli_fetch_array($run)) {
                    $ID = $row_type['order_id'];
                    $ID2 = $row_type['order_id'];
                    $Date = $row_type['Date'];
                    $email_fro = $row_type['email'];
                    $address = $row_type['pick_up_address'];
                    $drop_address = $row_type['drop_address'];
                    $name = $row_type['Name'];
                    $phone = $row_type['phone'];
                    $pick_up_date = $row_type['pick_up_date'];
                    $drop_date = $row_type['drop_date'];
                    $Drop_name = $row_type['Drop_name'];
                    $Total_price = $row_type['Total_price'];
                    $drop_phone = $row_type['drop_phone'];
                    $driver_username = $row_type['username'];
                    $order_number = $row_type['order_number'];
                }
            }

            ?>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Order List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <ul class="nav navbar-top-links navbar-right">
                                            <li class='dropdown'>
                                                <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                                                    Assign Driver <i class='fa fa-caret-down'></i>
                                                </a>
                                                <ul class='dropdown-menu dropdown-user'>
                                                    <?php
                                                    $get_driver = "SELECT * FROM `driver` ";
                                                    $run_driver = mysqli_query($Connect, $get_driver);
                                                    while ($row_type = mysqli_fetch_array($run_driver)) {
                                                        $username = $row_type['username'];
                                                        $driver_num = $row_type['driver_number'];

                                                        echo "
                        <li><a href='orderDetails.php?AssignD=$username' id='assign_d'>$username</a></li>
                        <li class='divider'></li>

            		";
                                                    }
                                                    // Store job ID as a session
                                                    if (isset($_GET['orderD'])) {
                                                        $job_id = $_GET['orderD'];
                                                        $_SESSION["Job"] = $job_id;
                                                        echo     $_SESSION["Job"];
                                                    }
                                                    // Assign a job to a driver
                                                    if (isset($_GET['AssignD'])) {
                                                        $assign_d = $_GET['AssignD'];
                                                        $job_num =  $_SESSION["Job"];
                                                        $r = 'new';
                                                        $stmt = $DB_con->prepare("SELECT * FROM bookings WHERE status='$r' AND order_id=:job_num");
                                                        $stmt->execute(array(":job_num" => $job_num));
                                                        $count = $stmt->rowCount();
                                                        if ($count == 1) {
                                                            $renew = "UPDATE `bookings` SET `username`='$assign_d', status='$assign_d' WHERE `order_id`='$job_num'";

                                                            $run_renew = mysqli_query($Connect, $renew);
                                                            if ($run_renew) {
                                                                $get_driver_token = "SELECT * FROM `driver` WHERE username = '$assign_d'";
                                                                $run_token = mysqli_query($Connect, $get_driver_token);
                                                                while ($row_type = mysqli_fetch_array($run_token)) {
                                                                    $username = $row_type['username'];
                                                                    $email = $row_type['email'];
                                                                    $driver_name = $row_type['name'];
                                                                    $vehicleMake = $row_type['vehicleMake'];
                                                                    $RegNo = $row_type['RegNo'];
                                                                    $driver_push_token = $row_type['push_token'];
                                                                }
                                                                // Admin Email
                                                                $subject4 = "New Order";
                                                                $email_to_admin = $email;
                                                                $htmlContent4 = '
    <html>
    <head>
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>Freight Booking</h3>
		<p>
	     You have been assigned a Job please login and accept
		</p>

        <a href="https://www.merchantcouriers.com/driver/"><h2>View Order</h2></a>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263779495409. <br/>
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
            $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";
            //$headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";

            // Send email
            if (mail($email_to_admin, $subject4, $htmlContent4, $headers)) :
                $successMsg = 'Email has sent successfully.';
            else :
                $errorMsg = 'Email sending fail.';
            endif;
            echo "<script>alert('Job Assigned to $assign_d !')</script>";
            $title = "Merchant Couriers";
            $msg ="You have been assigned a Job please login and accept";
            $page="orderDetails.php?orderD=$job_num";
            echo "<script>window.open('send_notification.php?title=$title&message=$msg&token=$driver_push_token&page=$page','_self')</script>";
           
        }
    } else {
        echo "<script>alert('Error! this is not a new Job.')</script>";
        echo "<script>window.open('orderDetails.php?orderD=$job_num','_self')</script>";
        
    }
}


?>
</ul>
</li>
</ul><br />
                    <div class="list-group">
                        <?php getBookingsD(); ?>
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
                    <!-- /.panel -->

                    <!-- /.panel -->
                    <div>
                        <!-- /.panel -->

                    </div>

                    <?php
                    // ----------------------------------------Cancel Btn------------------------------------
                    if (isset($_GET['CancelOrder'])) {

                        $cancel_order = $_GET['CancelOrder'];
                        $v = 'cancelled';
                        $cancel = "UPDATE `bookings` SET `status`='$v', invoice='UNPAID' WHERE `order_id`='$cancel_order' ";

                        $run_cancel = mysqli_query($Connect, $cancel);

                        $s = "SELECT * FROM bookings WHERE `order_id`='$cancel_order'";
                        $run = mysqli_query($Connect, $s);

                        while ($row_type = mysqli_fetch_array($run)) {
                            $email = $row_type['email'];
                            $Name = $row_type['Name'];
                            $order_number = $row_type['order_number'];


                            if ($run) {
                            // ---------------get client token-------------    
                            $get = "SELECT * FROM `users` where Email='$email'";
                        	 $run = mysqli_query($Connect,$get);
                        	 while ($row_type = mysqli_fetch_array($run)){
                        		 $push_token = $row_type['push_token'];
                        	 }


                                $email_to = $email;
                                $subject2 = "Order Cancelled";

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
		Hi' . $Name . '
	     Your order has been cancelled click the link below to see the invoice with your cancelation fee.
		</p>


       <h3> Click <a href="https://www.merchantcouriers.com/cancelled_invo.php?cancelled=' . $order_number . '"><b>View Invoice</b></a> to see your invoice.</h3>

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
                                $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";
                                $headers .= 'Cc: merchantcouriers1@gmail.com' . "\r\n";

                                // Send email
                                mail($email_to, $subject2, $htmlContent2, $headers);

                               
                                echo "<script>alert('$Name Order has been cancelled!')</script>";
                                // --------------------------------Push Notification---------------------------
                                $title = "Merchant Couriers";
                                $msg ="Your order has been cancelled click the link below to see the invoice with your cancelation fee.";
                                $page="orderDetails.php?orderD=$cancel_order";
                                echo "<script>window.open('send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                            }
                        }
                    }

                    //------------------------------------------------Accept Btn-------------------------------------------

                    if (isset($_GET['AcceptOrder'])) {
                        $accept_order = $_GET['AcceptOrder'];
                        $get = "SELECT * FROM `bookings` WHERE order_id = '$accept_order' ";
                        $run = mysqli_query($Connect, $get);
                        while ($row_type = mysqli_fetch_array($run)) {
                            $ID2 = $row_type['order_id'];
                            $email_fro = $row_type['email'];
                            $name = $row_type['Name'];
                            $phone = $row_type['phone'];
                            $Drop_name = $row_type['Drop_name'];
                            $drop_phone = $row_type['drop_phone'];
                            $driver_username = $row_type['username'];
                            $order_number = $row_type['order_number'];
                        }
                        //---------------get client token----------------------
                        $get_user = "SELECT * FROM `users` where Email='$email_fro'";
                        	 $run = mysqli_query($Connect,$get_user);
                        	 while ($row_type = mysqli_fetch_array($run)){
                        		 $push_token = $row_type['push_token'];
                        	 }
                        	 
                        $r = 'accepted';
                        $accept = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$accept_order' ";

                        $run_accept = mysqli_query($Connect, $accept);

                        if ($run_accept) {
                            $admin = "merchantcouriers1@gmail.com";
                            $email_to = $email_fro;
                            $email_subject = "Delivery Booking Accepted";
                            $email_from = "orders@merchantcouriers.com";
                            $dr_name = $driver_name;
                            $vmake = $vehicleMake;
                            $subject = "Accepted";

                            $htmlContent = '
                            <html>
                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                <title>Merchant Couriers</title>
                            </head>
                            <body>
                            <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                <h3>We Deliver With Speed!</h3>
                        		<p>
                        		Thank You for Using Merchant Couriers. Your order ' . $order_number . ' has been ACCEPTED by our delivery driver merchant ' . $dr_name . '.
                        		</p>
                        		<p>Thank You for Using Merchant Couriers.</p>
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
                            $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";

                            // Send email
                            if (mail($email_to, $subject, $htmlContent, $headers)) :
                                $successMsg = 'Email has sent successfully.';
                            else :
                                $errorMsg = 'Email sending fail.';
                            endif;

                            $sms_phone = $phone;
                            $uname = "Business";
                            $pwd = "Merchant2017";
                            $id = "b5c57830717b41b6c8b038912a55e641";
                            $sms_msg = "Hie your order has been ACCEPTED by our delivery driver merchant $dr_name driving $vmake vehicle reg# $RegNo. Thank you for using Merchant Couriers";
                            $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

                            $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($ch);
                            curl_close($ch);
                           // echo $result;

                            echo "<script>alert('Order Accepted! $email_fro')</script>";
                             // --------------------------------Push Notification---------------------------
                                $title = "Merchant Couriers";
                                $msg ="Thank You for using Merchant Couriers. Your order  $order_number  has been ACCEPTED";
                                $page="orderDetails.php?orderD=$accept_order";
                                
                                echo "<script>window.open('send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                           
                        }
                    }

                    //------------------------------------------------At Pick Btn-------------------------------------------

                    if (isset($_GET['AtPick'])) {
                        $atpick_order = $_GET['AtPick'];
                        $get = "SELECT * FROM `bookings` WHERE order_id = '$atpick_order' ";
                        $run = mysqli_query($Connect, $get);
                        while ($row_type = mysqli_fetch_array($run)) {
                            $ID2 = $row_type['order_id'];
                            $email_fro = $row_type['email'];
                            $name = $row_type['Name'];
                            $phone = $row_type['phone'];
                            $Drop_name = $row_type['Drop_name'];
                            $drop_phone = $row_type['drop_phone'];
                            $driver_username = $row_type['username'];
                            $order_number = $row_type['order_number'];
                        }
                        //---------------get client token----------------------
                        $get_user = "SELECT * FROM `users` where Email='$email_fro'";
                        	 $run = mysqli_query($Connect,$get_user);
                        	 while ($row_type = mysqli_fetch_array($run)){
                        		 $push_token = $row_type['push_token'];
                        	 }
                        	 
                        $r = 'at pick';
                        $atpick = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$atpick_order' ";

                        $run_atpick = mysqli_query($Connect, $atpick);

                        if ($run_atpick) {
                            $admin = "merchantcouriers1@gmail.com";
                            $email_to = $email_fro;
                            $email_subject = "Delivery Booking Accepted";
                            $email_from = "orders@merchantcouriers.com";
                            $dr_name = $driver_name;
                            $vmake = $vehicleMake;
                            $subject = "At Pick";

                            $htmlContent = '
                            <html>
                                <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                    <title>Merchant Couriers</title>
                                </head>
                                <body>
                                <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                    <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                    <h3>We Deliver With Speed!</h3>
                            		<p>
                            	    Hey ' . $clientName . '. Delivery driver  is AT PICKUP for your delivery to ' . $drop_name . '. Expect notification when on the way to drop off.
                            		</p>
                            		<p>Thank You for using Merchant Couriers.</p>
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
                            $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";

                            // Send email
                            if (mail($email_to, $subject, $htmlContent, $headers)) :
                                $successMsg = 'Email has sent successfully.';
                            else :
                                $errorMsg = 'Email sending fail.';
                            endif;

                            $sms_phone = $phone;
                            $uname = "Business";
                            $pwd = "Merchant2017";
                            $id = "b5c57830717b41b6c8b038912a55e641";
                            $sms_msg = "Hey $clientName. Delivery driver $driverName is AT PICKUP location. An email/sms notification will be sent when your delivery is on the way.";
                            $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

                            $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($ch);
                            curl_close($ch);

                           
                            // --------------------------------Push Notification---------------------------
                                $title = "Merchant Couriers";
                                $msg =" Hey $clientName. Delivery driver  is AT PICKUP";
                                $page="orderDetails.php?orderD=$atpick_order";
                                echo "<script>window.open('send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                                
                                echo "<script>alert('Driver at pick!')</script>";
                                
                        }
                    }

                    //------------------------------------------------On the Way Btn-------------------------------------------

                    if (isset($_GET['OnWay'])) {
                        $onway_order = $_GET['OnWay'];
                        $get = "SELECT * FROM `bookings` WHERE order_id = '$onway_order' ";
                        $run = mysqli_query($Connect, $get);
                        while ($row_type = mysqli_fetch_array($run)) {
                            $ID2 = $row_type['order_id'];
                            $email_fro = $row_type['email'];
                            $name = $row_type['Name'];
                            $phone = $row_type['phone'];
                            $Drop_name = $row_type['Drop_name'];
                            $drop_phone = $row_type['drop_phone'];
                            $driver_username = $row_type['username'];
                            $order_number = $row_type['order_number'];
                        }
                        //---------------get client token----------------------
                        $get_user = "SELECT * FROM `users` where Email='$email_fro'";
                        	 $run = mysqli_query($Connect,$get_user);
                        	 while ($row_type = mysqli_fetch_array($run)){
                        		 $push_token = $row_type['push_token'];
                        	 }
                        	 
                        $r = 'on the way';
                        $onway = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$onway_order' ";

                        $run_onway = mysqli_query($Connect, $onway);

                        if ($run_onway) {
                            $admin = "merchantcouriers1@gmail.com";
                            $email_to = $email_fro;
                            $email_subject = "Delivery Booking Accepted";
                            $email_from = "orders@merchantcouriers.com";
                            $dr_name = $driver_name;
                            $vmake = $vehicleMake;
                            $subject = "On the way";

                            $htmlContent = '
                            <html>
                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                <title>Merchant Couriers</title>
                            </head>
                            <body>
                            <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                <h3>We Deliver With Speed!</h3>
                        		<p>
                        	    Hey ' . $clientName . '. Delivery driver  is ON THE WAY to dropoff your goods for ' . $drop_name . '.
                        		</p>
                        		<p>Thank You for using Merchant Couriers.</p>
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
                            $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";

                            // Send email
                            if (mail($email_to, $subject, $htmlContent, $headers)) :
                                $successMsg = 'Email has sent successfully.';
                            else :
                                $errorMsg = 'Email sending fail.';
                            endif;

                            $sms_phone = $phone;
                            $uname = "Business";
                            $pwd = "Merchant2017";
                            $id = "b5c57830717b41b6c8b038912a55e641";
                            $sms_msg = "Hey $clientName. Delivery driver $driverName is ON THE WAY to dropoff your goods.";
                            $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

                            $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($ch);
                            curl_close($ch);

                            $sms_phone2 = $drop_phone;
                            $uname = "Business";
                            $pwd = "Merchant2017";
                            $id2 = "b5c57830717b41b6c8b038912a55e641";
                            $sms_msg2 = "Hello $rec_name. Delivery driver $driverName is ON THE WAY to dropoff goods to you sent by $clientName. Please be ready to collect it.";
                            $data = "&u=" . $uname . "&h=" . $id2 . "&op=pv&to=" . $sms_phone2 . "&msg=" . urlencode($sms_msg2);

                            $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($ch);
                            curl_close($ch);

                           
                            // --------------------------------Push Notification---------------------------
                                $title = "Merchant Couriers";
                                $msg ="Hey $clientName. Delivery driver  is ON THE WAY to dropoff your goods";
                                $page="orderDetails.php?orderD=$onway_order";
                                echo "<script>window.open('send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                                
                                 echo "<script>alert('Driver on the way!')</script>";
                        }
                    }

                    //------------------------------------------------Deliverd Btn-------------------------------------------

                    if (isset($_GET['Deliverd'])) {
                        $deliverd_order = $_GET['Deliverd'];
                        $get = "SELECT * FROM `bookings` WHERE order_id = '$deliverd_order' ";
                        $run = mysqli_query($Connect, $get);
                        while ($row_type = mysqli_fetch_array($run)) {
                            $ID2 = $row_type['order_id'];
                            $email_fro = $row_type['email'];
                            $name = $row_type['Name'];
                            $phone = $row_type['phone'];
                            $Drop_name = $row_type['Drop_name'];
                            $drop_phone = $row_type['drop_phone'];
                            $driver_username = $row_type['username'];
                            $order_number = $row_type['order_number'];
                        }
                        //---------------get client token----------------------
                        $get_user = "SELECT * FROM `users` where Email='$email_fro'";
                        	 $run = mysqli_query($Connect,$get_user);
                        	 while ($row_type = mysqli_fetch_array($run)){
                        		 $push_token = $row_type['push_token'];
                        	 }
                        	 
                        $r = 'deliverd';
                        $deliverd = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$deliverd_order' ";

                        $run_deliverd = mysqli_query($Connect, $deliverd);

                        if ($run_deliverd) {
                            $admin = "merchantcouriers1@gmail.com";
                            $email_to = $email_fro;
                            $email_subject = "Delivery Booking Accepted";
                            $email_from = "orders@merchantcouriers.com";
                            $dr_name = $driver_name;
                            $vmake = $vehicleMake;
                            $subject = "Deliverd";

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
                        	   ORDER COMPLETED Successfully. Your goods were DELIVERED by driver ' . $driverName . '. Kindly take time to rate our service <a href="https://m.facebook.com/pg/merchantcouriers/reviews/?ref=page_internal&mt_nav=0">RATE</a>.
                        		</p>
                        		<p><a href="www.merchantcouriers.com/driver/proof_img/' . $name_img . '">Download proof of delivery</a></p>
                        		<p>Thank You for using Merchant Couriers.</p>
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
                            $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";

                            // Send email
                            if (mail($to, $subject, $htmlContent, $headers)) :
                                $successMsg = 'Email has sent successfully.';
                            else :
                                $errorMsg = 'Email sending fail.';
                            endif;

                            $sms_phone = $phone;
                            $uname = "Business";
                            $pwd = "Merchant2017";
                            $id = "b5c57830717b41b6c8b038912a55e641";
                            $sms_msg = "Thank You for Using Merchant Couriers. ORDER COMPLETED Successfully and your stuff has been DELIVERED by our courier driver merchant $driverName.";
                            $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

                            $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($ch);
                            curl_close($ch);


                            echo "<script>alert(Deliverd!')</script>";
                             echo "<script>alert('Driver on the way!')</script>";
                            // --------------------------------Push Notification---------------------------
                                $title = "Merchant Couriers";
                                $msg ="ORDER COMPLETED Successfully. Your goods were DELIVERED";
                                $page="orderDetails.php?orderD=$deliverd_order";
                                echo "<script>window.open('send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                        }
                    }
                    //------------------------------------------------Renew Btn-------------------------------------------

                    if (isset($_GET['RenewOrder'])) {

                        $renew_order = $_GET['RenewOrder'];
                        $r = 'new';
                        $renew = "UPDATE `bookings` SET `status`='$r', invoice='UNPAID' WHERE `order_id`='$renew_order' ";

                        $run_renew = mysqli_query($Connect, $renew);

                        if ($renew) {

                            echo "<script>alert('Order Renewed!')</script>";
                            echo "<script>window.open('orderDetails.php?orderD=$renew_order','_self')</script>";
                        }
                    }
                    //----------------------------------------------Done Order--------------------------------------------
                    if (isset($_GET['DoneOrder'])) {

                        $done_order = $_GET['DoneOrder'];
                        $r = 'deliverd';
                        $done = "UPDATE `bookings` SET `status`='$r', invoice='UNPAID' WHERE `order_id`='$done_order' ";

                        $run_done = mysqli_query($Connect, $done);

                        if ($done) {

                            echo "<script>alert('Booking Done!')</script>";
                            echo "<script>window.open('index.php','_self')</script>";
                        }
                    }

                    ?>

                    <!-- /.col-lg-8 -->

                    <!-- /.col-lg-4 -->

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
