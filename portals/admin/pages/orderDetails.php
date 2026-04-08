<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<?php include ('../../config/bootstrap.php');  ?>

<?php require("function.php"); 



try {

    $DB_con = new PDO("mysql:host=" . DBhost . ";dbname=" . DBname, DBuser, DBpass);
} catch (PDOException $e) {

    die($e->getMessage());
}


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Order Details</title>

</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

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

                $stmt = $DB->prepare( $get);

                foreach ($results as $1) {
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
                                                    $stmt = $DB->prepare( $get_driver);
                                                    foreach ($results as $1) {
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

                                                            $stmt = $DB->prepare( $renew);
                                                            if ($run_renew) {
                                                                $get_driver_token = "SELECT * FROM `driver` WHERE username = '$assign_d'";
                                                                $stmt = $DB->prepare( $get_driver_token);
                                                                foreach ($results as $1) {
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
        <title><?php echo $site_name; ?></title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00"><?php echo $site_name; ?></h1>
        <h3>Freight Booking</h3>
		<p>
	     You have been assigned a delivery job on ' . $site_name . '. Please login and accept to fulfill the order.
		</p>

        <a href="https://<?php echo $web_url; ?>/driver/"><h2>View Order</h2></a>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

        PLEASE DO NOT REPLY TO THIS EMAIL.
        </p>

		<h4 style="color:#FF8C00"><?php echo $site_name; ?></h4>
		<p></p>
		</div>
		</footer>
		</div>
    </body>
    </html>';

            // Set content-type header for sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // Additional headers
            $headers .= 'From: <?php echo $site_name; ?> <orders@' . $web_url . '>' . "\r\n";

            // Send email
            if (mail($email_to_admin, $subject4, $htmlContent4, $headers)) :
                $successMsg = 'Email has sent successfully.';
            else :
                $errorMsg = 'Email sending fail.';
            endif;
            echo "<script>alert('Job Assigned to $assign_d !')</script>";
            $title = "<?php echo $site_name; ?>";
            $msg ="You have been assigned a delivery job on ' . $site_name . '. Please login and accept to fulfill the order.";
            $page="orderDetails.php?orderD=$job_num";
            echo "<script>window.open('../../web_push/send_notification.php?title=$title&message=$msg&token=$driver_push_token&page=$page','_self')</script>";
           
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

                        $stmt = $DB->prepare( $cancel);

                        $s = "SELECT * FROM bookings WHERE `order_id`='$cancel_order'";
                        $stmt = $DB->prepare( $s);

                        foreach ($results as $1) {
                            $email = $row_type['email'];
                            $Name = $row_type['Name'];
                            $order_number = $row_type['order_number'];


                            if ($run) {
                            // ---------------get client token-------------    
                            $get = "SELECT * FROM `users` where Email='$email'";
                        	 $stmt = $DB->prepare($get); $stmt->execute(); $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        	 foreach ($results as $1){
                        		 $push_token = $row_type['push_token'];
                        	 }


                                $email_to = $email;
                                $subject2 = "Order Cancelled";

                                $htmlContent2 = '
    <html>
    <head>
        <title><?php echo $site_name; ?></title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00"><?php echo $site_name; ?></h1>
        <h3></h3>
		<p>
		Hi' . $Name . '
	     Your order has been cancelled click the link below to see the invoice with your cancelation fee.
		</p>


       <h3> Click <a href="https://<?php echo $web_url; ?>/cancelled_invo.php?cancelled=' . $order_number . '"><b>View Invoice</b></a> to see your invoice.</h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">

		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

        PLEASE DO NOT REPLY TO THIS EMAIL.
        </p>

		<h4 style="color:#FF8C00"><?php echo $site_name; ?></h4>
		<p></p>
		</div>
		</footer>
		</div>
    </body>
    </html>';

                                // Set content-type header for sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                                // Additional headers
                                $headers .= 'From: <?php echo $site_name; ?> <orders@' . $web_url . '>' . "\r\n";
                                $headers .= 'Cc: <?php echo $bus_email; ?>' . "\r\n";

                                // Send email
                                mail($email_to, $subject2, $htmlContent2, $headers);

                               
                                echo "<script>alert('$Name Order has been cancelled!')</script>";
                                // --------------------------------Push Notification---------------------------
                                $title = "<?php echo $site_name; ?>";
                                $msg ="Your order has been cancelled click the link below to see the invoice with your cancelation fee.";
                                $page="orderDetails.php?orderD=$cancel_order";
                                echo "<script>window.open('../../web_push/send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                            }
                        }
                    }

                    //------------------------------------------------Accept Btn-------------------------------------------

                    if (isset($_GET['AcceptOrder'])) {
                        $accept_order = $_GET['AcceptOrder'];
                        $get = "SELECT * FROM `bookings` WHERE order_id = '$accept_order' ";
                        $stmt = $DB->prepare( $get);
                        foreach ($results as $1) {
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
                        	 $stmt = $DB->prepare($get); $stmt->execute(); $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        	 foreach ($results as $1){
                        		 $push_token = $row_type['push_token'];
                        	 }
                        	 
                        $r = 'accepted';
                        $accept = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$accept_order' ";

                        $stmt = $DB->prepare( $accept);

                        if ($run_accept) {
                            $admin = "<?php echo $bus_email; ?>";
                            $email_to = $email_fro;
                            $email_subject = "Delivery Booking Accepted";
                            $email_from = "orders@<?php echo $web_url; ?>";
                            $dr_name = $driver_name;
                            $vmake = $vehicleMake;
                            $subject = "Accepted";

                            $htmlContent = '
                            <html>
                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                <title><?php echo $site_name; ?></title>
                            </head>
                            <body>
                            <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                <h1 style="color:#FF8C00"><?php echo $site_name; ?></h1>
                                <h3></h3>
                        		<p>
                        		Thank You for Using ' . $site_name . '. Your order ' . $order_number . ' has been ACCEPTED by our delivery driver ' . $dr_name . '.
                        		</p>
                        		<p>Thank You for Using ' . $site_name . '.</p>
                        		<footer>
                        		<div style="background-color:#CCC; padding:10px;">

                        		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

                                PLEASE DO NOT REPLY TO THIS EMAIL.
                                </p>
                    
                        		<h4 style="color:#FF8C00"><?php echo $site_name; ?></h4>
                        		<p></p>
                        		</div>
                        		</footer>
                        		</div>
                            </body>
                            </html>';

                            // Set content-type header for sending HTML email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                            // Additional headers
                            $headers .= 'From: <?php echo $site_name; ?> <orders@' . $web_url . '>' . "\r\n";

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
                            $sms_msg = "Hie your order has been ACCEPTED by our delivery driver $dr_name driving $vmake vehicle reg# $RegNo. Thank you for using <?php echo $site_name; ?>";
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
                                $title = "<?php echo $site_name; ?>";
                                $msg ="Thank You for using <?php echo $site_name; ?>. Your order  $order_number  has been ACCEPTED";
                                $page="orderDetails.php?orderD=$accept_order";
                                
                                echo "<script>window.open('../../web_push/send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                           
                        }
                    }

                    //------------------------------------------------At Pick Btn-------------------------------------------

                    if (isset($_GET['AtPick'])) {
                        $atpick_order = $_GET['AtPick'];
                        $get = "SELECT * FROM `bookings` WHERE order_id = '$atpick_order' ";
                        $stmt = $DB->prepare( $get);
                        foreach ($results as $1) {
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
                        	 $stmt = $DB->prepare($get); $stmt->execute(); $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        	 foreach ($results as $1){
                        		 $push_token = $row_type['push_token'];
                        	 }
                        	 
                        $r = 'at pick';
                        $atpick = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$atpick_order' ";

                        $stmt = $DB->prepare( $atpick);

                        if ($run_atpick) {
                            $admin = "<?php echo $bus_email; ?>";
                            $email_to = $email_fro;
                            $email_subject = "Delivery Booking Accepted";
                            $email_from = "orders@<?php echo $web_url; ?>";
                            $dr_name = $driver_name;
                            $vmake = $vehicleMake;
                            $subject = "At Pick";

                            $htmlContent = '
                            <html>
                                <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                    <title><?php echo $site_name; ?></title>
                                </head>
                                <body>
                                <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                    <h1 style="color:#FF8C00"><?php echo $site_name; ?></h1>
                                    <h3></h3>
                            		<p>
                            	    Hey ' . $clientName . '. Delivery driver  is AT PICKUP for your delivery to ' . $drop_name . '. Expect a notification when ON THE WAY to drop off address.
                            		</p>
                            		<p>Thank You for using ' . $site_name . '.</p>
                            		<footer>
                            		<div style="background-color:#CCC; padding:10px;">
                            		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

                                    PLEASE DO NOT REPLY TO THIS EMAIL.
                                    </p>
                    
                            		<h4 style="color:#FF8C00"><?php echo $site_name; ?></h4>
                            		<p></p>
                            		</div>
                            		</footer>
                            		</div>
                                </body>
                                </html>';

                            // Set content-type header for sending HTML email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                            // Additional headers
                            $headers .= 'From: <?php echo $site_name; ?><orders@ ' . $web_url . '>' . "\r\n";

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
                                $title = "<?php echo $site_name; ?>";
                                $msg =" Hey $clientName. Delivery driver  is AT PICKUP";
                                $page="orderDetails.php?orderD=$atpick_order";
                                echo "<script>window.open('../../web_push/send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                                
                                echo "<script>alert('Driver at pick!')</script>";
                                
                        }
                    }

                    //------------------------------------------------On the Way Btn-------------------------------------------

                    if (isset($_GET['OnWay'])) {
                        $onway_order = $_GET['OnWay'];
                        $get = "SELECT * FROM `bookings` WHERE order_id = '$onway_order' ";
                        $stmt = $DB->prepare( $get);
                        foreach ($results as $1) {
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
                        	 $stmt = $DB->prepare($get); $stmt->execute(); $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        	 foreach ($results as $1){
                        		 $push_token = $row_type['push_token'];
                        	 }
                        	 
                        $r = 'on the way';
                        $onway = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$onway_order' ";

                        $stmt = $DB->prepare( $onway);

                        if ($run_onway) {
                            $admin = "<?php echo $bus_email; ?>";
                            $email_to = $email_fro;
                            $email_subject = "Delivery Booking Accepted";
                            $email_from = "orders@<?php echo $web_url; ?>";
                            $dr_name = $driver_name;
                            $vmake = $vehicleMake;
                            $subject = "On the way";

                            $htmlContent = '
                            <html>
                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                <title><?php echo $site_name; ?></title>
                            </head>
                            <body>
                            <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                <h1 style="color:#FF8C00"><?php echo $site_name; ?></h1>
                                <h3></h3>
                        		<p>
                        	    Hey ' . $clientName . '. Delivery driver  is ON THE WAY to dropoff your goods for ' . $drop_name . '.
                        		</p>
                        		<p>Thank You for using ' . $site_name . '.</p>
                        		<footer>
                        		<div style="background-color:#CCC; padding:10px;">

                        		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

                                PLEASE DO NOT REPLY TO THIS EMAIL.
                                </p>
                    
                        		<h4 style="color:#FF8C00"><?php echo $site_name; ?></h4>
                        		<p></p>
                        		</div>
                        		</footer>
                        		</div>
                            </body>
                            </html>';

                            // Set content-type header for sending HTML email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                            // Additional headers
                            $headers .= 'From: <?php echo $site_name; ?> <orders@' . $web_url . '>' . "\r\n";

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
                                $title = "<?php echo $site_name; ?>";
                                $msg ="Hey $clientName. Delivery driver  is ON THE WAY to dropoff your goods";
                                $page="orderDetails.php?orderD=$onway_order";
                                echo "<script>window.open('../../web_push/send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                                
                                 echo "<script>alert('Driver on the way!')</script>";
                        }
                    }

                    //------------------------------------------------Deliverd Btn-------------------------------------------

                    if (isset($_GET['Deliverd'])) {
                        $deliverd_order = $_GET['Deliverd'];
                        $get = "SELECT * FROM `bookings` WHERE order_id = '$deliverd_order' ";
                        $stmt = $DB->prepare( $get);
                        foreach ($results as $1) {
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
                        	 $stmt = $DB->prepare($get); $stmt->execute(); $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        	 foreach ($results as $1){
                        		 $push_token = $row_type['push_token'];
                        	 }
                        	 
                        $r = 'deliverd';
                        $deliverd = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$deliverd_order' ";

                        $stmt = $DB->prepare( $deliverd);

                        if ($run_deliverd) {
                            $admin = "<?php echo $bus_email; ?>";
                            $email_to = $email_fro;
                            $email_subject = "Delivery Booking Accepted";
                            $email_from = "orders@<?php echo $web_url; ?>";
                            $dr_name = $driver_name;
                            $vmake = $vehicleMake;
                            $subject = "Deliverd";

                            $htmlContent = '
                            <html>
                            <head>
                                <title><?php echo $site_name; ?></title>
                            </head>
                            <body>
                            <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                <h1 style="color:#FF8C00"><?php echo $site_name; ?></h1>
                                <h3></h3>
                        		<p>
                        	   ORDER COMPLETED Successfully. Your goods were DELIVERED by driver ' . $driverName . '. Kindly take time to rate our service <a href="https://m.facebook.com/pg/<?php echo $site_name; ?>/reviews/?ref=page_internal&mt_nav=0">RATE</a>.
                        		</p>
                        		<p><a href="<?php echo $web_url; ?>/driver/proof_img/' . $name_img . '">Download proof of delivery</a></p>
                        		<p>Thank You for using ' . $site_name . '.</p>
                        		<footer>
                        		<div style="background-color:#CCC; padding:10px;">
                        		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

                                PLEASE DO NOT REPLY TO THIS EMAIL.
                                </p>
                        
                        		<h4 style="color:#FF8C00"><?php echo $site_name; ?></h4>
                        		<p></p>
                        		</div>
                        		</footer>
                        		</div>
                            </body>
                            </html>';

                            // Set content-type header for sending HTML email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                            // Additional headers
                            $headers .= 'From: Merchant Couriers<orders@' . $web_url . '>' . "\r\n";

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
                            $sms_msg = "Thank You for Using <?php echo $site_name; ?>. ORDER COMPLETED Successfully and your goods have been DELIVERED SUCCESSFULLY by our courier driver merchant $driverName.";
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
                                $title = "<?php echo $site_name; ?>";
                                $msg ="ORDER COMPLETED Successfully. Your goods were DELIVERED SUCCESSFULLY";
                                $page="orderDetails.php?orderD=$deliverd_order";
                                echo "<script>window.open('send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
                        }
                    }
                    //------------------------------------------------Renew Btn-------------------------------------------

                    if (isset($_GET['RenewOrder'])) {

                        $renew_order = $_GET['RenewOrder'];
                        $r = 'new';
                        $renew = "UPDATE `bookings` SET `status`='$r', invoice='UNPAID' WHERE `order_id`='$renew_order' ";

                        $stmt = $DB->prepare( $renew);

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

                        $stmt = $DB->prepare( $done);

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

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


