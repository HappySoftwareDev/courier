<?php
require_once('../db.php');

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}

//$response = array();
if ($_POST['password']) {
    $password= $_POST['password'];
    $email =$_POST['email'];
    try {
         $stmt = $Connect->prepare("UPDATE users SET password ='$password' WHERE email='$email'");
        //check if password is correct
        if ($stmt->execute()) {
            $subject = "Password Updated";
            $content = '
                    <html>
                    <head>
                        <title>Merchant Couriers</title>
                    </head>
                    <body>
                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                        <h1 style="color:#FF8C00">Merchant Couriers</h1>
                        <h3>Password Updated</h3>
                		<p>
                	    You have successfully upadated your password.
                		</p>
                		<footer>
                		<div style="background-color:#CCC; padding:10px;">
                		<p>
                		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
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
                    $headers .= 'From: Merchant Couriers<noreply@merchantcouriers.com>' . "\r\n";
                    //$headers .= 'Cc: merchantcouriers1@gmail.com' . "\r\n";
                    //$headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";

                    // Send email
                    if (mail($email, $subject, $content, $headers)) :
                        $successMsg = 'Email has sent successfully.';
                    else :
                        $errorMsg = 'Email sending fail.';
                    endif;
                    
            echo " <div class='success-alert'>
                      <div class='alert'>
                        You have successfully updated your password.
                      </div>
                    </div>
                    ";
            // $go = "forgot_pass.php";
            //set session
            // header("Location: " . $go);
        } else {
            echo " <div class='danger-alert'>
                      <div class='alert'>
                        Your email does not exist.
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

          <div class="row g-0 auth-row justify-content-center">
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signin-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Update Password</h6>
                  <p class="text-sm mb-25">
                    Please enter your email address
                  </p>
                  <form action="update_pass.php" method="post" role="form" name="updateform">
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-2">
                          <label>Enter New Password</label>
                          <input type="password" name="password" placeholder="Password"  id="password"/>
                          <span class="icon"> <a href="#" onclick="togglePassword()" id='togglePasswordCheckBox'> <i class="lni lni-eye"></i></a> </span>
                        </div>
                        <input type="hidden" name="email" value="<?php echo $_REQUEST['email'] ?>"/>
                      </div>
                  
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap" >
                          <button class="main-btn primary-btn btn-hover w-100 text-center">
                            Update
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                  <div class="singin-option pt-40">
                    <p class="text-sm text-medium text-dark text-center">
                      Want to go back?
                      <a href="signin.php">Sign In</a>
                    </p>
                  </div>
                  
                  
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
