<?php 
require_once '../../config/bootstrap.php';
require_once '../../function.php';

// Get site settings for branding
$site_name = defined('SITE_NAME') ? SITE_NAME : 'WG ROOS Courier';
$logo = 'logo.png';

// Handle driver login
$loginError = '';
if (!empty($_POST['email'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    try {
        global $DB;
        
        // Query driver table
        $query = "SELECT * FROM `driver` WHERE email = ? OR username = ?";
        $stmt = $DB->prepare($query);
        $stmt->execute([$email, $email]);
        $driver = $stmt->fetch();
        
        if ($driver) {
            // Verify password (check both Password and password fields for compatibility)
            $storedPassword = $driver['password'] ?? $driver['Password'] ?? null;
            if ($storedPassword === $password) {
                session_start();
                $_SESSION['CC_Username'] = $email;
                $_SESSION['user_email'] = $email;
                $_SESSION['driverID'] = $driver['ID'] ?? $driver['id'] ?? '';
                $_SESSION['driver_id'] = $_SESSION['driverID'];
                $_SESSION['driver_name'] = $driver['name'] ?? $driver['Name'] ?? 'Driver';
                $_SESSION['user_role'] = 'driver';
                $_SESSION['MM_Username'] = $email;
                $_SESSION['MM_UserGroup'] = $email;
                
                // Redirect to dashboard
                header("Location: new_orders.php", true, 302);
                exit;
            } else {
                $loginError = "Invalid password";
            }
        } else {
            $loginError = "Driver account not found";
        }
    } catch (Exception $e) {
        $loginError = "Login error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>
    <title>Driver Login | <?php echo $site_name ?></title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-wrapper {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        
        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 500px;
        }
        
        .login-cover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .login-cover h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .login-cover p {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .login-form-area {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-form-area h6 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        
        .login-form-area > p {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 25px;
        }
        
        .input-style-1,
        .input-style-2 {
            margin-bottom: 20px;
        }
        
        .input-style-1 label,
        .input-style-2 label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #374151;
        }
        
        .input-style-1 input,
        .input-style-2 input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            font-size: 13px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .input-style-1 input:focus,
        .input-style-2 input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .input-style-2 {
            position: relative;
        }
        
        .input-style-2 .icon {
            position: absolute;
            right: 15px;
            top: 35px;
            cursor: pointer;
            color: #9ca3af;
        }
        
        .forgot-password {
            text-align: right;
            margin-bottom: 25px;
        }
        
        .forgot-password a {
            font-size: 12px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn-signin {
            flex: 1;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .btn-signin:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
        }
        
        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .alert {
            margin-bottom: 20px;
            padding: 12px 15px;
            border-radius: 5px;
            font-size: 13px;
        }
        
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }
            
            .login-cover {
                display: none;
            }
            
            .login-form-area {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Home Navigation -->
    <div style="position: absolute; top: 20px; left: 20px; z-index: 100;">
        <a href="../../" class="btn" style="background: white; color: #667eea; border: 1px solid #e5e7eb; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-block; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">← Back to Home</a>
    </div>
    
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-cover">
                <div>
                    <h2>Welcome Back</h2>
                    <p>Sign in to your driver account to manage deliveries, track earnings, and more.</p>
                    <div style="margin-top: 40px;">
                        <i class="lni lni-driver" style="font-size: 60px;"></i>
                    </div>
                </div>
            </div>
            
            <div class="login-form-area">
                <h6>Driver Sign In</h6>
                <p>Enter your credentials to continue</p>
                
                <?php if (!empty($loginError)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="lni lni-close-line" style="margin-right: 8px;"></i>
                        <?php echo htmlspecialchars($loginError); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form action="index.php" method="post" role="form">
                    <div class="input-style-1">
                        <label>Email or Username</label>
                        <input type="text" name="email" placeholder="Enter your email or username" required />
                    </div>
                    
                    <div class="input-style-2">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter your password" id="password" required />
                        <span class="icon">
                            <a href="javascript:void(0);" onclick="togglePassword()" class="toggle-password">
                                <i class="lni lni-eye"></i>
                            </a>
                        </span>
                    </div>
                    
                    <div class="forgot-password">
                        <a href="forgot_pass.php">Forgot Password?</a>
                    </div>
                    
                    <div class="button-group d-flex justify-content-center flex-wrap">
                        <button type="submit" class="btn-signin">Sign In</button>
                    </div>
                </form>
                
                <div class="signup-link">
                    Don't have an account? <a href="driver_registration.php">Register here</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer_scripts.php'; ?>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'lni lni-eye-off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'lni lni-eye';
            }
        }
    </script>
</body>
</html>


