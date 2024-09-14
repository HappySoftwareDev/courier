<?php require ("get-sql-value.php");?>

<?php

$loginFormAction = $_SERVER['PHP_SELF'];
// *** Redirect if username exists
$MM_flag = "MM_insert";
if (isset($_POST[$MM_flag])) {
    $MM_dupKeyRedirect = "signup.php";
    $loginUsername = $_POST['email'];
    $LoginRS__query = sprintf("SELECT email FROM affilate_user WHERE email=%s", GetSQLValueString($loginUsername, "text"));
    mysql_select_db($database_Connect, $Connect);
    $LoginRS = mysql_query($LoginRS__query, $Connect) or die(mysql_error());
    $loginFoundUser = mysql_num_rows($LoginRS);

    //if there is a row in the database, the username was found - can not add the requested username
    if ($loginFoundUser) {
        echo "<span style='color:red'>Email is taken go back and try a different email.</span>";
        return false;
    }
}

if (isset($_POST['email'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $affiate_no = $_POST['affiate_no'];
    $password = $_POST['password'];

    $insertSQL = sprintf(
        "INSERT INTO `affilate_user`(`name`, `email`, `phone`, `password`, `affialte_no`, `address`) VALUES (%s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['name'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['phone'], "text"),
        GetSQLValueString($_POST['password'], "text"),
        GetSQLValueString($_POST['affiliate_no'], "text"),
        GetSQLValueString($_POST['address'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $subject = "Welcome to Our Affiliate Program";
    $subject2 = "New Affiliate Signup";
    $affiliate_name = $_POST['name'];
    $affiliate_email = $_POST['email'];
    $admin_email = "merchantcouriers1@gmail.com";
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
	     A new Affiliate ' . $affiliate_name . ' has just sign up.
		</p>

       <h3> Click <a href="https://www.merchantcouriers.co.zw/admin/"><b>View details</b></a> to see more details.</h3>

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
    $headers .= 'From: Merchant Couriers<registrations@merchantcouriers.co.zw>' . "\r\n";
    $headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";

    // Send email
    if (mail($admin_email, $subject2, $htmlContent2, $headers)) :
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
	     Hi ' . $affiliate_name . '
		</p>
		<p> Welcome to our Affiliate Program. Thank you for signing up. To make the most and be a success at this program. Share with your network via social media facebook, twitter, google plus, messaging platforms whatsapp, sms and also via email plus more sharing platforms.

        Set daily goals, find new leads and share.

        For help and tools on how to share. Visit your dashboard and start sharing.

        Earn 10% lifetime earnings from reffered clients who signup and place orders via your links. </p>

       <p> Go to <a href="https://www.merchantcouriers.co.zw/affiliate.user">Dashboard</a></p>

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
    $headers .= 'From: Merchant Couriers<registrations@merchantcouriers.co.zw>' . "\r\n";

    // Send email
    if (mail($affiliate_email, $subject, $htmlContent, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $insertGoTo = "login.php";
    if ($insertGoTo) {
        echo "<script>alert('Registration was successful!')</script>";
        echo "<script>window.open('login.php','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
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

    <title>Merchant Couriers - Login</title>

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

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="text-center">
                        <a href="index.php"> <img src="../../images/logo.png" width="200px" alt=" Logo" /></a>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <center><b>Join Now</b></center>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" role="form" name="adminlogin">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Name" name="name" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email">
                                </div>

                                <div class="form-group">
                                    <input class="form-control" placeholder="Phone" name="phone" type="text">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Address" name="address" type="text" value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    <?php $random = substr(md5(mt_rand()), 0, 7); ?>
                                    <input class="form-control" placeholder="Password" name="affiliate_no" type="hidden" value="<?php echo $random; ?>">
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Sign Up">
                                <p />
                                <p>Already have an account? <a href="login.php">Login</a></p>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
