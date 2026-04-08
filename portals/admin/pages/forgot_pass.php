<?php include ('site_settings.php'); ?>

<?php require ("get-sql-value.php");

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
    $MM_redirectLoginSuccess = "index.php";
    $MM_redirectLoginFailed = "login.php";
    $MM_redirecttoReferrer = false;
    mysql_select_db($database_Connect, $Connect);

    $LoginRS__query = sprintf(
        "SELECT email, password FROM `affilate_user` WHERE email=%s AND password=%s",
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
        $_SESSION['affilate_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = $loginStrGroup;

        if (isset($_SESSION['PrevUrl']) && false) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }
        header("Location: " . $MM_redirectLoginSuccess);
    } else {
        echo "<script>alert('Login failed wrong password or email!')</script>";
        header("Location: " . $MM_redirectLoginFailed);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Change Password </title>


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
                            <center>Recover Password</center>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" role="form" name="adminlogin">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                                <p />
                                <p>Don't have an account? <a href="terms.php">Join Now</a></p>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


