<?php
// Start the session before any output is sent to the browser
session_start();

// Load centralized bootstrap
require_once('../../config/bootstrap.php');
require_once('../../function.php');

// *** Validate request to login to this site.
if ($_POST) {

    $username = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {

        // Use prepared statements for security
        $stmt = $Connect->prepare("SELECT * FROM `admin` WHERE Email=:username and Password=:password");
        $stmt->execute(array(":username" => $username, ":password" => $password));  // Fix to bind password safely
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        $MM_UserGroup = "";
        
        // Check if password is correct
        if ($count == 1) {
            $_SESSION['_Username'] = $username;
            $_SESSION['_UserGroup'] = $username;

            $go = "index.php";
            // Redirect using header() (Ensure no output has been sent before this line)
            header("Location: " . $go);
            exit(); // Always call exit() after header to ensure no further code is executed
        } else {
            echo "Invalid password";
        }
    } // End of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} // End of POST check
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Login</title>


</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                 <div class="text-center">
                        <a href="#"><img src="custom_files/<?php echo $logo ?>" alt="logo" width="200" ></a>
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
        // Load Firebase configuration from site management
        <?php include '../../web_push/firebase-config.php'; ?>
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

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


