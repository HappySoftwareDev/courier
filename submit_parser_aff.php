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
    <title>Partnership | Merchant Couriers</title>
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
                    <h1>Partnership</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li class="active">Partnership</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->


    <section Style="background-color:#193b50" id="services">
        <div class="container">

            <?php require ("get-sql-value.php"); 

            $editFormAction = $_SERVER['PHP_SELF'];
            if (isset($_SERVER['QUERY_STRING'])) {
                $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
            }

            if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "partnerform")) {
                $insertSQL = sprintf(
                    "INSERT INTO businesspartners (businessName, email, phone, businessLocation, businessType, software_packages, estimateDeliveries, pick_up_address, deliveryTime, PreferedTransport, company_logo, NameOfContact, PersonPhone, password, affiliate_no) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($_POST['businessName'], "text"),
                    GetSQLValueString($_POST['email'], "text"),
                    GetSQLValueString($_POST['phone'], "int"),
                    GetSQLValueString($_POST['businesslLocation'], "text"),
                    GetSQLValueString($_POST['businessType'], "text"),
                    GetSQLValueString($_POST['software_package'], "text"),
                    GetSQLValueString($_POST['estDeliver'], "text"),
                    GetSQLValueString($_POST['drop_address'], "text"),
                    GetSQLValueString($_POST['deliveryTime'], "text"),
                    GetSQLValueString($_POST['PreferedType'], "text"),
                    GetSQLValueString($_POST['company_logo'], "text"),
                    GetSQLValueString($_POST['pick_name'], "text"),
                    GetSQLValueString($_POST['drop_phone'], "int"),
                    GetSQLValueString($_POST['pass'], "text"),
                    GetSQLValueString($_POST['affiliate_no'], "text")
                );

                mysql_select_db($database_Connect, $Connect);
                $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

                $insertGoTo = "partner.php";
                if ($insertGoTo) {
                    echo "<script>alert('Account Created successful!')</script>";
                } else {
                    echo "<script>alert('error!')</script>";
                }
            }
            ?>
            <?php


            /*$to = "bamhara1@gmail.com";
$from = "mre@hdiientertainment.com";
$message = $_POST['book'];
$headers = "From: $from\n";
mail($to, '', $message, $headers );8*/

            ?>
            <?php

            if (isset($_POST['MM_insert'])) {
                // EDIT THE 2 LINES BELOW AS REQUIRED

                $email_to = "admin@merchantcouriers.com";

                $email_subject = "New business partnership request.";

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

                    !isset($_POST['businesslLocation']) ||

                    !isset($_POST['businessType']) ||

                    !isset($_POST['phone']) ||

                    !isset($_POST['estDeliver']) ||

                    !isset($_POST['drop_address']) ||

                    !isset($_POST['deliveryTime']) ||

                    !isset($_POST['PreferedType']) ||

                    !isset($_POST['drop_phone']) ||

                    !isset($_POST['pick_name']) ||

                    !isset($_POST['businessName'])
                ) {

                    died('We are sorry, but there appears to be a problem with the form you submitted.');
                }
                $email_from = "registrations@merchantcouriers.com";

                $email_business = $_POST['email'];

                $address = $_POST['businesslLocation'];

                $businessType = $_POST['businessType'];

                $phone = $_POST['phone'];

                $estDeliver = $_POST['estDeliver'];

                $drop_address = $_POST['drop_address'];

                $time = $_POST['deliveryTime'];

                $PreferedType = $_POST['PreferedType'];

                $drop_phone = $_POST['drop_phone'];

                $pick_name = $_POST['pick_name'];

                $businessName = $_POST['businessName'];


                $error_message = "";

                $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

                if (!preg_match($email_exp, $email_from)) {

                    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
                }

                $string_exp = "/^[A-Za-z .'-]+$/";

                if (!preg_match($string_exp, $pick_name)) {

                    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
                }

                if (strlen($businessName) < 2) {

                    $error_message .= 'The business name you entered do not appear to be valid.<br />';
                }

                if (strlen($error_message) > 0) {

                    died($error_message);
                }

                $email_message = "Form details below.\n\n";

                function clean_string($string)
                {

                    $bad = array("content-type", "bcc:", "to:", "cc:", "href");

                    return str_replace($bad, "", $string);
                }

                $email_message .= "Company Name: " . clean_string($businessName) . "\n";

                $email_message .= "Address: " . clean_string($address) . "\n";

                $email_message .= "Email: " . clean_string($email_business) . "\n";

                $email_message .= "Telephone: " . clean_string($phone) . "\n";

                $email_message .= "Prefered Transport Type: " . clean_string($PreferedType) . "\n";

                $email_message .= "Pick up Time: " . clean_string($time) . "\n";

                $email_message .= "To:" . "\n";

                $email_message .= "First Name: " . clean_string($pick_name) . "\n";

                $email_message .= "Address: " . clean_string($drop_address) . "\n";

                $email_message .= "Estimated Weekly Deliveries: " . clean_string($estDeliver) . "\n";

                $email_message .= "Business Type: " . clean_string($businessType) . "\n";


                // create email headers

                $headers = 'From: ' . $email_from . "\r\n" .

                    'Reply-To: ' . $email_from . "\r\n" .

                    'X-Mailer: PHP/' . phpversion();

                @mail($email_to, $email_subject, $email_message, $headers);

            ?>

                <h2>Thank you for your interest to deliver with us, we will be in touch within 24hrs.</h2> <br /><br />

            <?php

            }

            ?>
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
                            <strong>Email: </strong> admin@merchantcouriers.com
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong> www.merchantcouriers.com
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
                    <h4>SERVICED LOCATIONS</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="#">Harare, Zimbabwe</a></li>
                        </ul>
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
                    &copy; 2017 <a target="_blank" href="http://merchantcouriers.com/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">Merchant Couriers</a>. All Rights Reserved.
                </div>
                <!--/Copyright-->

                <div class="span6">
                    <ul class="social pull-right">
                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                        <li><a href="#"><i class="icon-linkedin"></i></a></li>
                        <li><a href="#"><i class="icon-google-plus"></i></a></li>
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
