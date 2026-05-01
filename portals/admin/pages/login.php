<?php
/**
 * Admin Portal Login Page - Modern Version
 */

require_once '../../../config/bootstrap.php';

// Check if already logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['CC_Username']) || isset($_SESSION['admin_id']);
if ($isLoggedIn) {
    header('Location: ../index.php', true, 302);
    exit;
}

$error = '';
$success = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        try {
            global $DB;
            
            // Check in users table for admin accounts
            $query = "SELECT * FROM `users` WHERE email = ? OR username = ? LIMIT 1";
            $stmt = $DB->prepare($query);
            $stmt->execute([$email, $email]);
            $user = $stmt->fetch();
            
            if ($user) {
                // Check password - support multiple field names and both plain text and hashed passwords
                $passwordMatch = false;
                $storedPassword = null;
                
                // Try to find password in different field names
                if (isset($user['Password'])) {
                    $storedPassword = $user['Password'];
                } elseif (isset($user['password'])) {
                    $storedPassword = $user['password'];
                } elseif (isset($user['password_hash'])) {
                    $storedPassword = $user['password_hash'];
                }
                
                if ($storedPassword) {
                    // Try plain text comparison first
                    if ($storedPassword === $password) {
                        $passwordMatch = true;
                    }
                    // Try password_verify (for bcrypt hashes)
                    elseif (password_verify($password, $storedPassword)) {
                        $passwordMatch = true;
                    }
                } else {
                    error_log('Admin login: No password field found for user: ' . $email);
                }
                
                if ($passwordMatch) {
                    // Valid admin user
                    $_SESSION['CC_Username'] = $email;
                    $_SESSION['admin_id'] = $user['ID'] ?? $user['Userid'] ?? 1;
                    $_SESSION['user_role'] = 'admin';
                    $_SESSION['user_name'] = $user['Name'] ?? 'Admin';
                    
                    header('Location: ../index.php', true, 302);
                    exit;
                } else {
                    $error = 'Invalid email or password';
                }
            } else {
                $error = 'Invalid email or password';
            }
        } catch (Exception $e) {
            error_log('Admin login error: ' . $e->getMessage());
            $error = 'An error occurred during login. Please try again.';
        }
    }
}

$site_name = 'WG ROOS Courier';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login | <?php echo $site_name; ?></title>
    <?php include '../head.php'; ?>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }
        
        .login-card h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        
        .btn-login:hover {
            opacity: 0.9;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .login-footer {
            text-align: center;
            color: white;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            <h2>Admin Login</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="admin@example.com" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn-login">Sign In</button>
            </form>
            
            <p style="text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
                <a href="../../booking/signin.php" style="color: #667eea; text-decoration: none;">Back to Customer Login</a>
            </p>
        </div>
    </div>
    
    <div class="login-footer" style="position: fixed; bottom: 20px; width: 100%;">
        &copy; 2026 <?php echo $site_name; ?>. All rights reserved.
    </div>

</body>

</html>


