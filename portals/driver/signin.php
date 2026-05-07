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
    session_start();
}

// Handle login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    error_log("Driver login attempt - Username: $username, Password length: " . strlen($password));
    
    if (empty($username) || empty($password)) {
        $loginError = 'Please enter both username and password';
    } else {
        try {
            global $DB;
            
            $stmt = $DB->prepare("SELECT * FROM `driver` WHERE username = ?");
            if (!$stmt) {
                error_log("Driver login: Failed to prepare statement");
                $loginError = 'Database error';
            } else {
                $stmt->execute([$username]);
                $driver = $stmt->fetch();
                
                error_log("Driver login: User found = " . ($driver ? 'YES' : 'NO'));
                
                if ($driver) {
                    $storedPassword = $driver['password'] ?? $driver['Password'] ?? null;
                    
                    error_log("Driver login: Stored password = " . (isset($storedPassword) ? substr($storedPassword, 0, 10) . "..." : "NULL") . ", Input = " . $password);
                    
                    if ($storedPassword && ($storedPassword === $password || password_verify($password, $storedPassword))) {
                        $_SESSION['MM_Username'] = $username;
                        $_SESSION['MM_UserGroup'] = $username;
                        $_SESSION['driver_id'] = $driver['driverID'] ?? $driver['id'] ?? '';
                        $_SESSION['driver_name'] = $driver['name'] ?? 'Driver';
                        $_SESSION['user_role'] = 'driver';
                        
                        error_log("Driver login: Password matches, session set, redirecting");
                        
                        session_write_close();
                        header('Location: index.php', true, 302);
                        exit;
                    } else {
                        error_log("Driver login: Password mismatch");
                        $loginError = 'Invalid username or password';
                    }
                } else {
                    error_log("Driver login: No driver found with username $username");
                    $loginError = 'Driver account not found';
                }
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
    <?php include 'head.php'; ?>
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
                                    <h1 class="text-primary mb-10">Driver Portal</h1>
                                    <p class="text-medium">
                                        Sign in to access your driver dashboard
                                    </p>
                                </div>
                                <div class="cover-image">
                                    <img src="assets/images/auth/signin-image.svg" alt="" onerror="this.style.display='none'"/>
                                </div>
                                <div class="shape-image">
                                    <img src="assets/images/auth/shape.svg" alt="" onerror="this.style.display='none'"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="signin-wrapper">
                            <div class="form-wrapper">
                                <h6 class="mb-15">Driver Sign In</h6>
                                <p class="text-sm mb-25">
                                    Enter your credentials to access your dashboard.
                                </p>
                                <?php if (!empty($loginError)): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($loginError); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                <form method="POST" action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" id="username" name="username" placeholder="Enter your username" class="form-control" required autofocus>
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
                                    <a href="../booking/signin.php" style="color: #667eea; font-size: 13px; text-decoration: none;">← Customer Login</a> | 
                                    <a href="../admin/pages/login.php" style="color: #667eea; font-size: 13px; text-decoration: none;">Admin Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
