<?php require ("get-sql-value.php");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addDriver")) {
    $insertSQL = sprintf(
        "INSERT INTO `admin` (Name, Email, phone, Password) VALUES (%s, %s, %s, %s)",
        GetSQLValueString($_POST['userName'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['phone'], "text"),
        GetSQLValueString($_POST['password'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $insertGoTo = "loginaffiliate.php";
    if ($insertGoTo) {
        echo "<script>alert('You are now registered as admin ')</script>";
        echo "<script>window.open('login.php','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
}
?>
<?php
if (isset($_POST['MM_insert'])) {
    $name = $_POST['userName'];
    $to = "admin@merchantcouriers.co.zw";
    $from = "registrations@merchantcouriers.co.zw";
    $message = "$name has just registered as admin ";
    $headers = 'From: ' . $from;
    mail($to, $from, $message, $headers);

?>
<?php
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

    <title>Merchant Couriers - Driver Registration</title>

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
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register as admin with Merchant Couriers</h3>
                    </div>
                    <div class="panel-body">
                        <form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" role="form" name="addDriver">
                            <fieldset>
                                <div class="form-group">
                                    <label>
                                        <h4>Contact Info</h4>
                                    </label><br />
                                    <label>Full name</label>
                                    <input class="form-control" name="userName" type="text" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="email" type="email" required>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" name="phone" type="tel" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" name="password" type="password" required>
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Register">
                            </fieldset>
                            <input type="hidden" name="MM_insert" value="addDriver">
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
