<?php
/**
 * Debug Admin Login - Test Authentication
 */

require_once '../../../config/bootstrap.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$debug_info = [];

// Test database connection
try {
    global $DB;
    $stmt = $DB->prepare("SELECT 1");
    $stmt->execute();
    $result = $stmt->fetch();
    $debug_info['db_connection'] = 'OK';
} catch (Exception $e) {
    $debug_info['db_connection'] = 'ERROR: ' . $e->getMessage();
}

// Test query
try {
    global $DB;
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM `admin`");
    $stmt->execute();
    $result = $stmt->fetch();
    $debug_info['admin_table_count'] = $result['total'] ?? 'N/A';
} catch (Exception $e) {
    $debug_info['admin_table'] = 'ERROR: ' . $e->getMessage();
}

// Test specific admin lookup
if ($_POST) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    try {
        global $DB;
        $stmt = $DB->prepare("SELECT * FROM `admin` WHERE Email = ?");
        $debug_info['query'] = "SELECT * FROM `admin` WHERE Email = ?";
        $debug_info['email_param'] = $email;
        
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            $debug_info['user_found'] = true;
            $debug_info['user_data'] = $user;
            $debug_info['stored_password'] = $user['Password'] ?? 'NO PASSWORD FIELD';
            $debug_info['password_match'] = ($user['Password'] === $password);
            
            if ($user['Password'] === $password) {
                $_SESSION['admin_id'] = $user['ID'];
                $_SESSION['CC_Username'] = $email;
                $_SESSION['user_role'] = 'admin';
                $debug_info['session_set'] = true;
                $debug_info['redirect'] = 'Redirecting to ../index.php';
                header('Location: ../index.php', true, 302);
                exit;
            }
        } else {
            $debug_info['user_found'] = false;
        }
    } catch (Exception $e) {
        $debug_info['query_error'] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Debug Admin Login</title>
    <style>
        body { font-family: monospace; background: #f0f0f0; padding: 20px; }
        pre { background: white; padding: 20px; border-radius: 5px; overflow-x: auto; }
        form { background: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        input { padding: 8px; width: 200px; display: block; margin: 10px 0; }
        button { padding: 8px 20px; }
    </style>
</head>
<body>
    <h1>Debug: Admin Login</h1>
    
    <h2>System Status</h2>
    <pre><?php print_r($debug_info); ?></pre>
    
    <h2>Session Status</h2>
    <pre><?php print_r($_SESSION); ?></pre>
    
    <h2>Test Login</h2>
    <form method="POST">
        <input type="text" name="email" placeholder="Email (admin@app.wgroos.com)" value="admin@app.wgroos.com">
        <input type="password" name="password" placeholder="Password (12345#$)" value="12345#$">
        <button type="submit">Test Login</button>
    </form>
</body>
</html>
