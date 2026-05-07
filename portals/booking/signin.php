<?php
// Start the session before anything else is output
if (session_status() === PHP_SESSION_NONE) {
    // Try to set a session save path if the default doesn't exist
    $sessionPath = sys_get_temp_dir() . '/php_sessions';
    if (!is_dir($sessionPath)) {
        @mkdir($sessionPath, 0755, true);
    }
    @ini_set('session.save_path', $sessionPath);
    
    try {
        session_start();
    } catch (Exception $e) {
        error_log('Session start error: ' . $e->getMessage());
    }
}

require_once '../../config/bootstrap.php';
require_once '../admin/pages/site_settings.php';

// *** Validate request to login to this site.
if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    error_log("Booking login attempt - Email: $email, Password length: " . strlen($password));
    
    try {
        global $DB;
        
        // Query users table
        $get = "SELECT * FROM `users` WHERE email = ?";
        $stmt = $DB->prepare($get);
        if (!$stmt) {
            error_log("Booking login: Failed to prepare statement");
            $loginError = "Database error";
        } else {
            $stmt->execute([$email]);
            $row = $stmt->fetch();
            
            error_log("Booking login: User found = " . ($row ? 'YES' : 'NO'));
            
            if ($row) {
                // Find password field (try multiple possible field names)
                $storedPassword = $row['Password'] ?? $row['password'] ?? $row['password_hash'] ?? null;
                
                error_log("Booking login: Stored password = " . (isset($storedPassword) ? substr($storedPassword, 0, 10) . "..." : "NULL") . ", Input = " . $password);
                
                if ($storedPassword && ($storedPassword === $password || password_verify($password, $storedPassword))) {
                    $_SESSION['CC_Username'] = $email;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_id'] = $row['ID'] ?? $row['Userid'] ?? '';
                    $_SESSION['user_role'] = 'customer';
                    $_SESSION['CC_UserGroup'] = $email;
                    
                    error_log("Booking login: Password matches, session set, redirecting");
                    
                    // Ensure session is written before redirect
                    session_write_close();
                    // Redirect to booking portal
                    header("Location: index.php", true, 302);
                    exit;
                } else {
                    error_log("Booking login: Password mismatch");
                    $loginError = "Invalid email or password";
                }
            } else {
                error_log("Booking login: No user found with email $email");
                $loginError = "Invalid email or password";
            }
        }
    } catch (Exception $e) {
        error_log("Booking login error: " . $e->getMessage());
        $loginError = "Login error: " . $e->getMessage();
    }
}

$loginError = $loginError ?? '';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    
    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title>Sign In | <?php echo $site_name ?></title>

    
  </head>
  <body>
    <!-- Home Navigation -->
    <div style="position: absolute; top: 20px; left: 20px; z-index: 100;">
        <a href="../../" class="btn" style="background: white; color: #667eea; border: 1px solid #e5e7eb; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-block; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.background='#f3f4f6'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'" onmouseout="this.style.background='white'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">← Back to Home</a>
    </div>
    
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
                  <?php if (!empty($loginError)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <?php echo htmlspecialchars($loginError); ?>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  <?php endif; ?>
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
                            <a href="whatsapp://send?abid=&text=  Plan to ship your parcels, freight or move furniture the easy way? Use <?php echo $site_name ?>. Whether you are busy at work, can`t leave home or you`re out of town. Just book and we`l pick it up and deliver it for you! That`s why with our new, fast and convenient service, you can have your delivery done at a good price. Signup for free and send with a 10%  Discount on your first delivery. Visit <?php echo $site_name ?>" class="main-btn light-btn-outline main-btn light-btn-outline btn-sm">
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
        // Load Firebase configuration from site management
        <?php include '../../web_push/firebase-config.php'; ?>
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    </script>

    <!-- Recaptcha container where the Recaptcha widget will be rendered -->
    <script src="recaptcha.js"></script>

    <!-- ========= All Javascript files linkup ======== -->
    <?php include 'footerscripts.php'; ?>

  </body>
</html>

