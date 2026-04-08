<?php include ('../admin/pages/site_settings.php'); ?>

<?php
require_once('../admin/pages/db.php');
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}

//$response = array();
if (isset($_POST['email'])) {
    $username = trim($_POST['email']);

    try {
        $stmt = $Connect->prepare("SELECT * FROM `users` WHERE email=:username");
        $stmt->execute(array(":username" => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        $userid = $row['Userid'];
        $MM_UserGroup = "";
        //check if password is correct
        if ($count == 1) {
            $subject = "Update Password";
            $email_to = $username;
            $content = '
                    <html>
                    <head>
                        <title><?php echo $site_name ?></title>
                    </head>
                    <body>
                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                        <h1 style="color:#FF8C00"><?php echo $site_name ?></h1>
                        <h3>Update Password Link</h3>
                		<p>
                	    Please click the link below to update your password.
                		</p>
                        <a href="https://<?php echo $web_url ?>/book_new/update_pass.php?email='.$email_to.'"><h2>Link</h2></a>
                		<footer>
                		<div style="background-color:#CCC; padding:10px;">

                		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

                    PLEASE DO NOT REPLY TO THIS EMAIL.
                    </p>
                
                		<h4 style="color:#FF8C00"><?php echo $site_name ?></h4>
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
                    $headers .= '<?php echo $site_name ?><noreply@' . $web_url . '>' . "\r\n";
                    
                    // Send email
                    if (mail($email_to, $subject, $content, $headers)) :
                        $successMsg = 'Email has sent successfully.';
                    else :
                        $errorMsg = 'Email sending fail.';
                    endif;
                    
            echo " <div class='success-alert'>
                      <div class='alert'>
                        A link was sent to your email, please check your email to update your password.
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

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title>Sign In | <?php echo $site_name ?></title>

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
                  <form action="forgot_pass.php" method="post" role="form" name="forgotform">
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Email</label>
                          <input type="email" name="email" placeholder="Email" />
                        </div>
                      </div>
                  
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap" >
                          <button class="main-btn primary-btn btn-hover w-100 text-center">
                            Submit
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
        // Load Firebase configuration from site management
        <?php include '../../web_push/firebase-config.php'; ?>
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    </script>
    

    <script src="recaptcha.js"></script>

    <!-- ========= All Javascript files linkup ======== -->

    <?php include 'footerscripts.php'; ?>

  </body>
</html>


