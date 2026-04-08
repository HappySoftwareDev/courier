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

require_once '../config/bootstrap.php';
require_once '../function.php'; 

require_once('../admin/pages/get-sql-value.php'); 




$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['phone'])) {

    $sms_phone = $_POST['phone'];
    $MM_redirect = "sms:$sms_phone?body=" . urlencode("Hey there! You are being invited to try our delivery driver services. If you own a motorbike, car, van, or truck, signup today and start earning extra money. Visit our website: $web_url/driver/ and register your vehicle today.");
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
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" value="+263" name="phone" id="userName" required />
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


