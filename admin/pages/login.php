<?php
require_once('db.php');

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}
//$response = array();

if ($_POST) {

    $username = trim($_POST['email']);
    $password = trim($_POST['password']);


    try {

        $stmt = $Connect->prepare("SELECT * FROM `admin` WHERE Email=:username and Password='$password'");
        $stmt->execute(array(":username" => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        $MM_UserGroup = "";
        //check if password is correct
        if ($count == 1) {
            $_SESSION['MM_Username'] = $username;
            $_SESSION['MM_UserGroup'] = $username;

            $go = "index.php";
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


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
                        <h2><a href="index.php">Merchant Couriers</a></h2>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form ACTION="login.php" METHOD="POST" role="form" name="adminlogin">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" required>
                                </div>
                                <div id="recaptcha-container"></div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Login">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyCSNGUwzJ0iXTz01MAWsfec5jbTWvbCYC8",
            authDomain: "merchant-booking.firebaseapp.com",
            databaseURL: "https://merchant-booking.firebaseio.com",
            projectId: "merchant-booking",
            storageBucket: "merchant-booking.appspot.com",
            messagingSenderId: "909204433162",
            appId: "1:909204433162:web:8421fcaf404eaf3eccb2f3"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    </script>
    <script>
        window.onload = function() {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }
    </script>

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
