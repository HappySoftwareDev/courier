<?php
/**
 * Driver Portal Sign In Page
 */

require_once '../../config/bootstrap.php';

// Start session for driver authentication
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loginError = '';
$loginSuccess = false;

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    $_SESSION = [];
    session_destroy();
    session_start(); // Start new session for login page
}

// Handle login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($username) || empty($password)) {
        $loginError = 'Please enter both username and password';
    } else {
        try {
            global $DB;
            
            // Query driver table
            $stmt = $DB->prepare("SELECT * FROM `driver` WHERE username = ?");
            $stmt->execute([$username]);
            $driver = $stmt->fetch();
            
            if ($driver) {
                // Check password - support multiple field names
                $storedPassword = $driver['password'] ?? $driver['Password'] ?? null;
                
                if ($storedPassword && ($storedPassword === $password || password_verify($password, $storedPassword))) {
                    // Set session variables
                    $_SESSION['MM_Username'] = $username;
                    $_SESSION['MM_UserGroup'] = $username;
                    $_SESSION['driver_id'] = $driver['driverID'] ?? $driver['id'] ?? '';
                    $_SESSION['driver_name'] = $driver['name'] ?? 'Driver';
                    $_SESSION['user_role'] = 'driver';
                    
                    $loginSuccess = true;
                    // Redirect to dashboard
                    header('Location: index.php', true, 302);
                    exit;
                } else {
                    $loginError = 'Invalid username or password';
                }
            } else {
                $loginError = 'Driver account not found';
            }
        } catch (Exception $e) {
            error_log('Driver login error: ' . $e->getMessage());
            $loginError = 'An error occurred during login. Please try again.';
        }
    }
}

// Check if already logged in
if (isset($_SESSION['MM_Username']) && !empty($_SESSION['MM_Username'])) {
    header('Location: index.php', true, 302);
    exit;
}

$site_name = 'WG ROOS Courier';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Sign In | <?php echo $site_name; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .signin-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: 20px;
        }
        
        .signin-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 500px;
        }
        
        @media (max-width: 768px) {
            .signin-wrapper {
                grid-template-columns: 1fr;
            }
            .signin-branding {
                display: none;
            }
        }
        
        .signin-branding {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .signin-branding h1 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .signin-branding p {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 20px;
        }
        
        .signin-branding-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .signin-form {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .signin-form h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .signin-form > p {
            color: #999;
            font-size: 14px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .signin-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
        }
        
        .signin-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        }
        
        .signin-button:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .signin-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            font-size: 13px;
        }
        
        .signin-links a {
            color: #667eea;
            text-decoration: none;
        }
        
        .signin-links a:hover {
            text-decoration: underline;
        }
        
        .home-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .home-link:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <a href="../../" class="home-link">← Back Home</a>
    
    <div class="signin-container">
        <div class="signin-wrapper">
            <!-- Branding Side -->
            <div class="signin-branding">
                <div class="signin-branding-icon">🚗</div>
                <h1><?php echo $site_name; ?></h1>
                <p>Professional Driver Portal</p>
                <p style="font-size: 12px; opacity: 0.8;">Manage your deliveries and track earnings in real-time</p>
            </div>
            
            <!-- Login Form Side -->
            <div class="signin-form">
                <h2>Driver Sign In</h2>
                <p>Enter your credentials to access your dashboard</p>
                
                <?php if (!empty($loginError)): ?>
                    <div class="error-message">
                        <strong>Error:</strong> <?php echo htmlspecialchars($loginError); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    
                    <button type="submit" class="signin-button">Sign In</button>
                </form>
                
                <div class="signin-links">
                    <a href="../../portals/booking/signin.php">Customer Login</a>
                    <a href="../../portals/admin/pages/login.php">Admin Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
