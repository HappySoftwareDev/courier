<?php require_once('../Connections/Connect.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['phone'])) {

    $sms_phone = $_POST['phone'];
    $MM_redirect = "sms:$sms_phone?body=Hey there! You are being invited to try our delivery driver app. If you own a Motorbike, Small cars, Vans, Small trucks, 30t trucks and Box trucks. Go ahead and signup and start earning extra money. Visit our website www.merchantcouriers.co.zw and register your vehicle today.";
    header("Location: " . $MM_redirect);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Merchant Couriers</title>
    <!-- jquery -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
    <!-- Latest compiled and minified CSS -->

    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->

    <!-- Optional theme -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->

    <!-- Latest compiled and minified JavaScript -->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->

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
