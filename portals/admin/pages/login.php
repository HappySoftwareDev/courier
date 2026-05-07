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
    
    // DEBUG: Log the attempt
    error_log("Admin login attempt - Email: $email, Password length: " . strlen($password));
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        try {
            global $DB;
            
            // Check in admin table for admin accounts (separate from users table)
            $query = "SELECT * FROM `admin` WHERE Email = ? LIMIT 1";
            $stmt = $DB->prepare($query);
            if (!$stmt) {
                error_log("Admin login: Failed to prepare statement");
                $error = 'Database error during login';
            } else {
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                error_log("Admin login: User found = " . ($user ? 'YES' : 'NO'));
                
                if ($user) {
                    // Check password - admin table uses Password field with plain text
                    $passwordMatch = false;
                    $storedPassword = $user['Password'] ?? null;
                    
                    error_log("Admin login: Stored password = " . substr($storedPassword, 0, 10) . "..., Input = " . $password);
                    
                    if (isset($user['Password']) && $user['Password'] === $password) {
                        $passwordMatch = true;
                        error_log("Admin login: Plain text match = TRUE");
                    } else {
                        // Also support hashed passwords for future use
                        if (isset($user['Password']) && password_verify($password, $user['Password'])) {
                            $passwordMatch = true;
                            error_log("Admin login: Hash verify match = TRUE");
                        } else {
                            error_log("Admin login: Password match = FALSE");
                        }
                    }
                    
                    if ($passwordMatch) {
                        // Valid admin user
                        $_SESSION['CC_Username'] = $email;
                        $_SESSION['admin_id'] = $user['ID'] ?? $user['Userid'] ?? 1;
                        $_SESSION['user_role'] = 'admin';
                        $_SESSION['user_name'] = $user['Name'] ?? 'Admin';
                        
                        error_log("Admin login: Session set, redirecting to ../index.php");
                        
                        // Ensure session is written before redirect
                        session_write_close();
                        header('Location: ../index.php', true, 302);
                        exit;
                    } else {
                        $error = 'Invalid email or password';
                    }
                } else {
                    error_log("Admin login: No user found with email $email");
                    $error = 'Invalid email or password';
                }
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
    <title>Admin Sign In | <?php echo $site_name; ?></title>
    <?php include '../head.php'; ?>
</head>
<body>
    <!-- Home Navigation -->
    <div style="position: absolute; top: 20px; left: 20px; z-index: 100;">
        <a href="../../" class="btn" style="background: white; color: #667eea; border: 1px solid #e5e7eb; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-block; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.background='#f3f4f6'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'" onmouseout="this.style.background='white'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">← Back to Home</a>
    </div>

    <main>
        <section class="signin-section">
            <div class="container-fluid">
                <div class="row g-0 auth-row">
                    <div class="col-lg-6">
                        <div class="auth-cover-wrapper bg-primary-100">
                            <div class="auth-cover">
                                <div class="title text-center">
                                    <h1 class="text-primary mb-10">Admin Panel</h1>
                                    <p class="text-medium">
                                        Sign in to access the admin dashboard
                                    </p>
                                </div>
                                <div class="cover-image">
                                    <img src="../assets/images/auth/signin-image.svg" alt="" onerror="this.style.display='none'"/>
                                </div>
                                <div class="shape-image">
                                    <img src="../assets/images/auth/shape.svg" alt="" onerror="this.style.display='none'"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="signin-wrapper">
                            <div class="form-wrapper">
                                <h6 class="mb-15">Admin Sign In</h6>
                                <p class="text-sm mb-25">
                                    Enter your credentials to access the admin dashboard.
                                </p>
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($error); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($success)): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($success); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                <form method="POST" action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" id="email" name="email" placeholder="admin@example.com" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mb-10">Sign In</button>
                                </form>
                                <div style="text-align: center; margin-top: 15px;">
                                    <a href="../../booking/signin.php" style="color: #667eea; font-size: 13px; text-decoration: none;">← Back to Customer Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


