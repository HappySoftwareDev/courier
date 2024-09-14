<?php require("function.php"); ?>

<?php

$get = "SELECT * FROM `bookings` ORDER BY Date DESC Limit 1";

$run = mysqli_query($Connect, $get);

while ($row_type = mysqli_fetch_array($run)) {
    $ID = $row_type['order_id'];
    $Date = $row_type['Date'];
}
?>
<?php require_once('Connections/Connect.php'); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Services | Merchant Couriers</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sl-slide.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>

    <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a id="logo" class="pull-left" href="index.php"></a>
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">

                        <li class="active"><a href="index.php">Home</a></li>



                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Book Delivery <i class="icon-angle-down"></i></a>
                            <ul class="dropdown-menu">


                                <li><a href="book/parcel_delivery.php">Parcel Delivery</a></li>
                                <li><a href="book/freight.booking.php">Send Freight</a></li>
                                <li><a href="book/furniture_go.php">Move Furniture</a></li>
                                <li><a href="freight.reg.php">New Customer? Register.</a></li>
                                <li class="divider"></li>
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Use</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign-UP <i class="icon-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="driver_registration.php">Driver Sign-Up</a></li>
                                <li><a href="freight.reg.php">Customer Sign-Up</a></li>
                                <li class="divider"></li>
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Use</a></li>
                            </ul>
                        </li>
                        <li class="login"><a href="driver/index.php"><i class="icon-taxi">Driver Login</i></a></li>
                        <li><a href="invite-email.php"><i class="icon-share"></i> Share</a></li>


                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </header>
    <!-- /header -->


    <section class="title">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <h1>Booking</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li class="active">Booking</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->


    <section Style="background-color:#193b50" id="services">
        <div class="container">


            <?php

            $get = "SELECT * FROM `driver` WHERE type_of_service='Tow Truck' AND username !='pending' AND info !='blocked' ";

            $run = mysqli_query($Connect, $get);

            while ($row_type = mysqli_fetch_array($run)) {
                $ID = $row_type['driverID'];
                $Name = $row_type['name'];
                $driver_phone = $row_type['phone'];
                $driver_email = $row_type['email'];
                $address = $row_type['address'];
                $documents = $row_type['documents'];
            }

            if (isset($_POST['MM_insert'])) {

                $email_to = $driver_email;

                $email_subject = "New order from Merchant Couriers";

                function died($error)
                {

                    // your error code can go here

                    echo "We are very sorry, but there were error(s) found with the form you submitted. ";

                    echo "These errors appear below.<br /><br />";

                    echo $error . "<br /><br />";

                    echo "Please go back and fix these errors.<br /><br />";

                    die();
                }
                // validation expected data exists

                if (
                    !isset($_POST['email']) ||

                    !isset($_POST['address']) ||

                    !isset($_POST['drop_address']) ||

                    !isset($_POST['phone']) ||

                    !isset($_POST['name']) ||

                    !isset($_POST['date']) ||

                    !isset($_POST['vehicle_type']) ||

                    !isset($_POST['time']) ||

                    !isset($_POST['drop_time'])
                ) {

                    died('We are sorry, but there appears to be a problem with the form you submitted.');
                }

                $email_from = "orders@merchantcouriers.co.zw";

                $email_client = $_POST['email'];

                $address = $_POST['address'];

                $drop_address = $_POST['drop_address'];

                $phone = $_POST['phone'];

                $name = $_POST['name'];

                $date = $_POST['date'];

                $vehicle_type = $_POST['vehicle_type'];

                $note = $_POST['note'];

                $time = $_POST['time'];

                $drop_time = $_POST['drop_time'];

                $distance = $_POST['distance'];

                $Total_price = $_POST['Total_price'];

                $order_number = $_POST['order_number'];

                $OrderID = $ID + 1;


                $error_message = "";

                $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

                if (!preg_match($email_exp, $email_from)) {

                    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
                }

                $string_exp = "/^[A-Za-z .'-]+$/";

                if (!preg_match($string_exp, $name)) {

                    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
                }


                if (strlen($error_message) > 0) {

                    died($error_message);
                }


                $uname = "Fasttrack1";
                $pwd = "Thelordismyshephered2017";
                $id = "FleetStar";
                $sms_drivers = $driver_phone;
                $book_num = $_POST['order_number'];

                $message_to_cust = "New Tow Truck Booking on Merchant Couriers. For more info check your email. Ref: $order_number, Price: $$Total_price . Pay for your booking on Paynow.";

                $data = "user=" . $uname . "&password=" . $pwd . "&sender=" . $id . "&SMSText=" . $message_to_cust . "&GSM=" . $sms_drivers;

                $ch = curl_init('http://api.infobip.com/api/v3/sendsms/plain?');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);


                $subject2 = "New Taxi Booking";

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
	     New Tow Truck booking on Merchant  Couriers. Below are details of the booking.
		</p>
		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
            <tr style="background-color: #e0e0e0;">
			<th>Order Number:</th><td>#' . $order_number . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Name:</th><td>' . $name . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Pick Up Address:</th><td>' . $address . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Drop Off Address:</th><td>' . $drop_address . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Type Of Vehicle:</th><td>' . $vehicle_type . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Distance:</th><td>' . $distance . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Total Price:</th><td>$' . $Total_price . '</td>
			</tr>

        </table>

       <h3> Click <a href="https://www.merchantcouriers.co.zw/driver/"><b>View Order</b></a> to see more details about this order.</h3>

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
                $headers .= 'From: Merchant Couriers<orders@merchantcouriers.co.zw>' . "\r\n";
                $headers .= 'Cc: bamhara1@gmail.com' . "\r\n";
                $headers .= 'Cc: merchantcouriers1@gmail.com' . "\r\n";

                // Send email
                if (mail($email_to, $subject2, $htmlContent2, $headers)) :
                    $successMsg = 'Email has sent successfully.';
                else :
                    $errorMsg = 'Email sending fail.';
                endif;

                $subject = "Confirmation";

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
	     Congratulations! You have SUCCESSFULLY BOOKED a tow truck through Merchant Couriers. <br/> An email/sms notification with a taxi driver assigned to you will be sent to you shortly.
		</p>

		<p>Below are details of your booking.</p>

		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
            <tr style="background-color: #e0e0e0;">
			<th>Order Number:</th><td>#' . $order_number . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Pick Up Address:</th><td>' . $address . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Destination Address:</th><td>' . $drop_address . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Distance:</th><td>' . $distance . '</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Total Price:</th><td>$' . $Total_price . '</td>
			</tr>

        </table>

       <h3> Click this link <a href="https://www.merchantcouriers.co.zw/towtruck.invoice.php?towtruckbooking=' . $order_number . '">Invoice</a> to see your invoice if you didn`t pay the booking.</h3>


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
                $headers .= 'From: Merchant Couriers<orders@merchantcouriers.co.zw>' . "\r\n";

                // Send email
                if (mail($email_client, $subject, $htmlContent, $headers)) :
                    $successMsg = 'Email has sent successfully.';
                else :
                    $errorMsg = 'Email sending fail.';
                endif;




            ?>

                <h1>Thank you for booking your tow truck with Merchant Couriers. <br /></h1> <br /><br />

                <h5>
                    Please pay for your booking by Clicking the followin button. We use Paynow, a secure online payment merchant platform for Zimbabwe. Note that paynow accepts Visa, Mastercard, Zimswitch, Ecocash and Telecash. Click the button below. Please check your email for your taxi booking confirmation, booking price and booking number.<br />

                    <br />

                    Alternatively you can call and pay over the phone. Dial +263772467352 or +263779495409. We do not advise customers to pay, drivers in cash as thi sis outside of our billing processes.
                </h5>




            <?php

            }

            ?>
         
<?php require ("get-sql-value.php"); 

            $editFormAction = $_SERVER['PHP_SELF'];
            if (isset($_SERVER['QUERY_STRING'])) {
                $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
            }

            if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "bookingform")) {
                $insertSQL = sprintf(
                    "INSERT INTO bookings (pick_up_address, pick_up_time, pick_up_date, Name, phone, email, drop_address, drop_time, Total_price, distance, vehicle_type, type_of_transport, order_number, delivery_type, drivers_note) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($_POST['address'], "text"),
                    GetSQLValueString($_POST['time'], "text"),
                    GetSQLValueString($_POST['date'], "text"),
                    GetSQLValueString($_POST['name'], "text"),
                    GetSQLValueString($_POST['phone'], "int"),
                    GetSQLValueString($_POST['email'], "text"),
                    GetSQLValueString($_POST['drop_address'], "text"),
                    GetSQLValueString($_POST['drop_time'], "text"),
                    GetSQLValueString($_POST['Total_price'], "text"),
                    GetSQLValueString($_POST['distance'], "text"),
                    GetSQLValueString($_POST['vehicle_type'], "text"),
                    GetSQLValueString($_POST['transport'], "text"),
                    GetSQLValueString($_POST['order_number'], "text"),
                    GetSQLValueString($_POST['delivery_type'], "text"),
                    GetSQLValueString($_POST['note'], "text")
                );

                mysql_select_db($database_Connect, $Connect);
                $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

                $uname = "Fasttrack1";
                $pwd = "Thelordismyshephered2017";
                $id = "FleetStar";
                $sms_to = $_POST['phone'];
                $book_num = $_POST['order_number'];

                $message_to_cust = "You've just booked a tow truck using Merchant Couriers. For more info check your email. Ref: $order_number, Price:$$Total_price . Pay for your booking on Paynow.";

                $data = "user=" . $uname . "&password=" . $pwd . "&sender=" . $id . "&SMSText=" . $message_to_cust . "&GSM=" . $sms_to;

                $ch = curl_init('http://api.infobip.com/api/v3/sendsms/plain?');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);

                $insertGoTo = "booking.php";
                if ($insertGoTo) {
                    echo "<script>alert('Booking was successful')</script>";
                    echo "<script>window.open('towtruck.invoice.php?towtruckbooking=$book_num','_self')</script>";
                } else {
                    echo "<script>alert('error!')</script>";
                }
            }
            ?>

        </div>
    </section>

    <!--Bottom-->
    <section id="bottom" class="main">
        <!--Container-->
        <div class="container">

            <!--row-fluids-->
            <div class="row-fluid">

                <!--Contact Form-->
                <div class="span3">
                    <h4>ADDRESS</h4>
                    <ul class="unstyled address">
                        <li>
                            <i class="icon-home"></i><strong>Address:</strong> Harare <br>Zimbabwe
                        </li>
                        <li>
                            <i class="icon-envelope"></i>
                            <strong>Email: </strong> admin@merchantcouriers.co.zw
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong> www.merchantcouriers.co.zw
                        </li>
                        <li>
                            <i class="icon-phone"></i>
                            <strong>Mobile No:</strong> +263772467352
                        </li>
                    </ul>
                </div>
                <!--End Contact Form-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>OUR COMPANY</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="about-us.php">About Us</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Copyright</a></li>
                            <li><a href="#">We are hiring</a></li>
                            <li><a href="#">News & Updates</a></li>
                        </ul>
                    </div>
                </div>
                <!--Important Links-->

                <!--Archives-->
                <div id="archives" class="span3">
                    <h4>SERVICES LOCATIONS</h4>
                    <div>
                        <img src="images/map.png" alt="map">

                    </div>
                </div>
                <!--End Archives-->

    </section>
    <!--/bottom-->

    <!--Footer-->
    <footer id="footer">
        <div class="container">
            <div class="row-fluid">
                <div class="span5 cp">
                    &copy; 2017 <a target="_blank" href="http://merchantcouriers.co.zw/">Merchant Couriers</a>. All Rights Reserved.
                </div>
                <!--/Copyright-->

                <div class="span6">
                    <ul class="social pull-right">
                        <li><a href="http://www.facebook.com/sharer.php?u=https://merchantcouriers.co.zw" target="_blank"><i class="icon-facebook"></i></a></li>
                        <li><a href="https://twitter.com/share?url=https://merchantcouriers.co.zw&amp;text=merchant%20couriers&amp;hashtags=merchantcouriers" target="_blank"><i class="icon-twitter"></i></a></li>
                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=https://merchantcouriers.co.zw" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <li><a href="https://plus.google.com/share?url=https://merchantcouriers.co.zw" target="_blank"><i class="icon-google-plus"></i></a></li>
                        <li><a href="#"><i class="icon-instagram"></i></a></li>
                        <li><a href="whatsapp://send?abid=username&text=HeyThere!"><img src="images/whatsapp.png" width="28px" alt="" /></a></li>
                    </ul>
                </div>

                <div class="span1">
                    <a id="gototop" class="gototop pull-right" href="#"><i class="icon-angle-up"></i></a>
                </div>
                <!--/Goto Top-->
            </div>
        </div>
    </footer>
    <!--/Footer-->

    <!--  Login form -->
    <div class="modal hide fade in" id="loginForm" aria-hidden="false">
        <div class="modal-header">
            <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
            <h4>Login Form</h4>
        </div>
        <!--Modal Body-->
        <div class="modal-body">
            <form class="form-inline" action="<?php echo $loginFormAction; ?>" method="POST" id="form-login">
                <input type="text" class="input-small" name="email" placeholder="Email">
                <input type="password" class="input-small" name="password" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox"> Remember me
                </label>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
            <a href="#">Forgot your password?</a>
            <p>Don't have an account? <a href="registration.php">register</a> </p>
        </div>
        <!--/Modal Body-->
    </div>
    <!--  /Login form -->

    <script src="js/vendor/jquery-1.9.1.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
