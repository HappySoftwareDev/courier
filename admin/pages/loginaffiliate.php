<?php
require_once('../../db.php');

$loginFormAction = $_SERVER['PHP_SELF'];

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}
//$response = array();

if ($_POST) {

    $username = trim($_POST['email']);
    $password = trim($_POST['password']);


    try {

        $stmt = $Connect->prepare("SELECT * FROM `affilate_user` WHERE email=:username and password='$password'");
        $stmt->execute(array(":username" => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        $MM_UserGroup = "";
        //check if password is correct
        if ($count == 1) {
            $_SESSION['affilate_Username'] = $username;
            $_SESSION['MM_UserGroup'] = $username;

            $go = "indexaffiliate.php";
            //set session
            header("Location: " . $go);
        } else {

            echo "Invalid password";
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} //end post
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
                            <center>Sign In</center>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" role="form" name="adminlogin">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
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
