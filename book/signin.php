<?php
require_once('../db.php');

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}

//$response = array();
if (isset($_POST['email'])) {
    $username = trim($_POST['email']);
    $password = trim($_POST['password']);
    try {
        $stmt = $Connect->prepare("SELECT * FROM `users` WHERE email=:username and password='$password'");
        $stmt->execute(array(":username" => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        $userid = $row['Userid'];
        $MM_UserGroup = "";
        //check if password is correct
        if ($count == 1) {
            $_SESSION['MM_Username'] = $username;
            $_SESSION['MM_UserGroup'] = $username;
            $_SESSION['Userid'] = $userid;
            $go = "index.php";
            //set session
            header("Location: " . $go);
        } else {
            echo " <div class='danger-alert'>
                      <div class='alert'>
                        Invalid password
                      </div>
                    </div>
                    ";
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="assets/images/favicon.png"
      type="image/x-icon"
    />
    <title>Sign In | Merchant Couriers</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
  </head>
  <body>
    <!-- ======== sidebar-nav start =========== -->
   
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main >
      

      <!-- ========== signin-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
         
          <!-- ========== title-wrapper end ========== -->

          <div class="row g-0 auth-row">
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    <h1 class="text-primary mb-10">Welcome Back</h1>
                    <p class="text-medium">
                      Sign in to your Existing account to continue
                    </p>
                  </div>
                  <div class="cover-image">
                    <img src="assets/images/auth/signin-image.svg" alt="" />
                  </div>
                  <div class="shape-image">
                    <img src="assets/images/auth/shape.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signin-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Sign In Form</h6>
                  <p class="text-sm mb-25">
                    We are happy to have you back.
                  </p>
                  <form action="signin.php" method="post" role="form" name="loginform">
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Email</label>
                          <input type="email" name="email" placeholder="Email" />
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-2">
                          <label>Password</label>
                          <input type="password" name="password" placeholder="Password"  id="password"/>
                          <span class="icon"> <a href="#" onclick="togglePassword()" id='togglePasswordCheckBox'> <i class="lni lni-eye"></i></a> </span>
                        </div>
                      </div>
                      <!-- end col -->
                     
                      <div class="col-xxl-6 col-lg-12 col-md-6">
                        <div
                          class="text-start text-md-end text-lg-start text-xxl-end mb-30"
                        >
                          <a href="forgot_pass.php">Forgot Password?</a>
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap" >
                          <button class="main-btn primary-btn btn-hover w-100 text-center">
                            Sign In
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                  <div class="singin-option pt-40">
                    <p class="text-sm text-medium text-dark text-center">
                      Don’t have any account yet?
                      <a href="signup.php">Create an account</a>
                    </p>
                  </div>
                  
                  <!-- Share -->
                   <div class="justify-content-center row col-md-6">
                       <hr>
                            <h4>Invite friends.</h4>
                            <div class="col-3">
                            <button class="main-btn light-btn-outline btn-sm" id="notification" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="lni lni-comments"></i></button>
                                <!--sms invite-->
                                <div class="dropdown-menu " aria-labelledby="notification">
                                    <div class="ml-15 mr-15">
                                    <form action="invite-sms.php" method="post">
                                    <div class="input-style-1">
                                      <label>Phonenumber</label>
                                      <input type="tel" name="phone" placeholder="+263" />
                                    </div>
                                    <button class="main-btn dark-btn "> Send </button>
                                     </form> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                            <button class="main-btn light-btn-outline btn-sm" id="notification-email" data-bs-toggle="dropdown" aria-expanded="false"><i class="lni lni-envelope"></i></button>
                            <!--Email invite-->
                            <div class="dropdown-menu " aria-labelledby="notification-email">
                                    <div class="ml-15 mr-15">
                                    <form action="invite-email.php" method="post">
                                    <div class="input-style-1">
                                      <label>Email</label>
                                      <input type="email" name="email" placeholder="email@domain.com" />
                                    </div>
                                    <button class="main-btn dark-btn "> Send </button>
                                     </form> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                            <a href="http://www.facebook.com/sharer.php?u=http://bit.ly/2KRRi6E" class="main-btn light-btn-outline btn-sm">
                                <i class="lni lni-facebook"></i></a>
                            </div>
                            <div class="col-3">
                            <a href="whatsapp://send?abid=&text=Plan to ship your parcels, freight or move 
                            furniture the easy way? Try Merchant Couriers. Whether you are busy at work, 
                            can't leave home or you're out of town. Just book and we'l pick it up and 
                            deliver it for you! That's why with our new, fast and convenient app, you 
                            can now book and have your delivery done at a good price. New clients are
                            invited to signup for free and send your first delivery; Plus you're Awarded 
                            a 10% Discount on your first delivery. Visit bit.ly/2KRRi6E We Deliver With Speed!" class="main-btn light-btn-outline main-btn light-btn-outline btn-sm">
                                <i class="lni lni-whatsapp"></i></a>
                            </div>
                    </div>
                  <!--End Share-->
                  
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signin-section end ========== -->

     
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->
    
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
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

    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/dynamic-pie-chart.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/fullcalendar.js"></script>
    <script src="assets/js/jvectormap.min.js"></script>
    <script src="assets/js/world-merc.js"></script>
    <script src="assets/js/polyfill.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
