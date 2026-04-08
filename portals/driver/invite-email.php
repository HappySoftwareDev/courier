<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}

// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include ("../admin/pages/site_settings.php");

require_once('../admin/pages/get-sql-value.php');

require_once '../config/bootstrap.php';
require_once '../function.php';



$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
    $email_client = $_POST['email'];
    $subject = "Invitation";

    $htmlContent = '
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>' . $site_name . '</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00"><?php echo $site_name ?></h1>
        <h3></h3>
		<p>Hello<p/>
		<p>You are being invited to try our delivery driver services ' . $web_url . '/driver/</p>

		<p>Below is a list of our services.</p>

		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
            <tr style="background-color: #e0e0e0;">
			<th>Parcel delivery:</th><td>Motorbikes & Small cars</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Light Freight:</th><td>Vans & Small trucks</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Heavy haulage:</th><td>30t trucks & Box trucks</td>
			</tr>

        </table>

        <h3><a href="' . $web_url . '/driver/">Signup today and start earning extra money in no time.</a></h3>



		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		<p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
        <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
        <h4 style="color:#FF8C00">' . $site_name . '</h4>
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
    $headers .= 'From: <?php echo $site_name ?><admin@' . $web_url . '>' . "\r\n";

    // Send email
    if (mail($email_client, $subject, $htmlContent, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $MM_redirect = "index.php";
    echo "<script>alert('Invitation sent thank you for sharing our services!')</script>";
    header("Location: " . $MM_redirect);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Driver - <?php echo $site_name ?></title>
    
    <script type="text/javascript" src="jquery-3.1.1.min.js" charset="UTF-8"></script>

    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="validation.min.js"></script>
    <script type="text/javascript" src="index.js"></script>
    <link href="style.css" rel="stylesheet" media="screen">

    <script>
        function _(x) {
            return document.getElementById(x);
        }

        function login() {
            _('outputDiv').value = "Please wait...";
        }
    </script>
</head>

<body>

    <!-------------------------------------------------------------------------
  1) Create some html content that can be accessed by jquery
  -------------------------------------------------------------------------->


    <div class="container  container-fluid col-md-6" style="padding-top:0px;">
        <div class="col-md-12 " role="document">
            <form class="form-signin" METHOD="POST" id="login-form" action="<?php echo $loginFormAction; ?>" name="loginForm">
                <div class="form-header">
                    <!--Page Heading -->
                    <!--<center class="fa fa-user"><img src="logo.png" height="80" width="150" alt=""></center>-->
                    <h3 class="form-title ">
                        <center class="fa fa-user">Invite Friends</center><span class=" pull pull-right"></span>
                    </h3>
                    <hr />
                </div>

                <!-- error will be shown here ! -->
                <div id="error">

                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" class="form-control" placeholder="name@gmail.com" name="email" id="userName" required />
                    <span class="help-block" id="error"></span>
                </div>

                <p>
                    <input class="btn btn-large btn-primary form-control" type="submit" name="btn-login" id="btn-login" onClick="login()" id="outputDiv" value="Invite">
                </p>



                <hr />

            </form>

            <center>
                <a href="index.php" class="btn btn-large btn-warning">Back</a>
            </center>
        </div>
    </div>
    </div>


</body>

</html>


