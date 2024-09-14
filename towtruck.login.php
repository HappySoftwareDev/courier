<?php require ("get-sql-value.php"); 

<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
    $loginUsername = $_POST['email'];
    $password = $_POST['password'];
    $MM_fldUserAuthorization = "";
    $MM_redirectLoginSuccess = "towtruck.booking.php";
    $MM_redirectLoginFailed = "towtruck.login.php";
    $MM_redirecttoReferrer = false;
    mysql_select_db($database_Connect, $Connect);

    $LoginRS__query = sprintf(
        "SELECT Email, Password FROM clients WHERE Email=%s AND Password=%s",
        GetSQLValueString($loginUsername, "text"),
        GetSQLValueString($password, "text")
    );

    $LoginRS = mysql_query($LoginRS__query, $Connect) or die(mysql_error());
    $loginFoundUser = mysql_num_rows($LoginRS);
    if ($loginFoundUser) {
        $loginStrGroup = "";

        if (PHP_VERSION >= 5.1) {
            session_regenerate_id(true);
        } else {
            session_regenerate_id();
        }
        //declare two session variables and assign them
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = $loginStrGroup;

        if (isset($_SESSION['PrevUrl']) && false) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }
        header("Location: " . $MM_redirectLoginSuccess);
    } else {
        echo "<script>alert('Login failed try again!')</script>";
        header("Location: " . $MM_redirectLoginFailed);
    }
}
?>
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
    <title>Login | Merchant Couriers</title>
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
                    <h1>Login</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li><a href="#">Pages</a> <span class="divider">/</span></li>
                        <li class="active">Login</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->


    <section id="registration-page" class="container">
        <form name="loginform" class="center" action='<?php echo $loginFormAction; ?>' method="POST">
            <fieldset class="registration-form">

                <div class="control-group">
                    <!-- E-mail -->
                    <div class="controls">
                        <input type="email" id="email" name="email" placeholder="E-mail" class="input-xlarge">
                    </div>
                </div>

                <div class="control-group">
                    <!-- Password-->
                    <div class="controls">
                        <input type="password" id="password" name="password" placeholder="Password" class="input-xlarge">
                    </div>
                </div>

                <div class="control-group">
                    <!-- Button -->
                    <div class="controls">
                        <button class="btn btn-success btn-large btn-block">Login</button>
                    </div>
                </div>
            </fieldset>
            <input type="hidden" name="MM_insert" value="form">
            <p>Don't have an account? <a href="registration.php">Register</a></p>
        </form>
    </section>
    <!-- /#registration-page -->

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
                            <i class="icon-home"></i><strong>Address:</strong> 1032 Wayback Lane, Wantagh<br>NY 11793
                        </li>
                        <li>
                            <i class="icon-envelope"></i>
                            <strong>Email: </strong> support@email.com
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong> www.domain.com
                        </li>
                        <li>
                            <i class="icon-phone"></i>
                            <strong>Toll Free:</strong> 631-409-3105
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
                            <li><a href="terms.php">Terms of Use</a></li>
                            <li><a href="privacy.php">Privacy Policy</a></li>
                            <li><a href="#">Copyright</a></li>
                    </div>
                </div>
                <!--Important Links-->

                <!--Archives-->
                <div id="archives" class="span3">
                    <h4>SERVICES LOCATIONS</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="#">Harare, Zimbabwe</a></li>
                        </ul>
                    </div>
                </div>
                <!--End Archives-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>Other Pages</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="about-us.php">News & Updates</a></li>
                            <li><a href="#">We're Hiring</a></li>
                        </ul>
                    </div>
                </div>
                <!--Important Links-->


            </div>

        </div>
        <!--/row-fluid-->
        </div>
        <!--/container-->

    </section>
    <!--/bottom-->

    <!--Footer-->
    <footer id="footer">
        <div class="container">
            <div class="row-fluid">
                <div class="span5 cp">
                    &copy; <?php echo date("Y"); ?> <a target="_blank" href="http://merchantcouriers.co.zw/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">Merchant Couriers</a>. All Rights Reserved.
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
            <form class="form-inline" action="index.html" method="post" id="form-login">
                <input type="text" class="input-small" placeholder="Email">
                <input type="password" class="input-small" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox"> Remember me
                </label>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
            <a href="#">Forgot your password?</a>
        </div>
        <!--/Modal Body-->
    </div>
    <!--  /Login form -->

    <script src="js/vendor/jquery-1.9.1.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
