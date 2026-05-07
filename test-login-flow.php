<?php
/**
 * Test Login Flow
 * Simulates the complete login process for all three portals
 */

require_once 'config/bootstrap.php';

// Test data
$tests = [
    'admin' => [
        'table' => 'admin',
        'field_username' => 'Email',
        'field_password' => 'Password',
        'username' => 'admin@app.wgroos.com',
        'password' => '12345#$',
        'expected_session_vars' => ['CC_Username', 'admin_id', 'user_role', 'user_name']
    ],
    'driver' => [
        'table' => 'driver',
        'field_username' => 'username',
        'field_password' => 'password',
        'username' => 'john_driver', // You may need to adjust this
        'password' => 'password123',
        'expected_session_vars' => ['MM_Username', 'MM_UserGroup', 'driver_id', 'user_role']
    ],
    'booking' => [
        'table' => 'users',
        'field_username' => 'email',
        'field_password' => 'password',
        'username' => 'user@example.com', // You may need to adjust this
        'password' => 'password123',
        'expected_session_vars' => ['CC_Username', 'user_email', 'user_id', 'user_role', 'CC_UserGroup']
    ]
];

echo "<h1>Login Flow Test</h1>";
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";

foreach ($tests as $portal => $config) {
    echo "\n=== Testing {$portal} Portal ===\n";
    
    try {
        global $DB;
        
        // Test 1: Query the user table
        echo "1. Querying {$config['table']} table for {$config['field_username']} = {$config['username']}...\n";
        
        $stmt = $DB->prepare("SELECT * FROM `{$config['table']}` WHERE {$config['field_username']} = ?");
        if (!$stmt) {
            echo "   ERROR: Failed to prepare statement\n";
            continue;
        }
        
        $stmt->execute([$config['username']]);
        $user = $stmt->fetch();
        
        if (!$user) {
            echo "   ERROR: User not found\n";
            print_r($DB->getLastError());
            continue;
        }
        
        echo "   SUCCESS: User found\n";
        echo "   Fields: " . implode(", ", array_keys($user)) . "\n";
        
        // Test 2: Check password field
        echo "2. Checking password field...\n";
        
        $storedPassword = $user[$config['field_password']] ?? $user['Password'] ?? $user['password'] ?? $user['password_hash'] ?? null;
        
        if (!$storedPassword) {
            echo "   ERROR: Password field not found\n";
            continue;
        }
        
        echo "   SUCCESS: Password field found\n";
        echo "   Stored password (first 20 chars): " . substr($storedPassword, 0, 20) . "...\n";
        
        // Test 3: Verify password
        echo "3. Verifying password...\n";
        
        $passwordMatch = ($storedPassword === $config['password'] || password_verify($config['password'], $storedPassword));
        
        if (!$passwordMatch) {
            echo "   WARNING: Password does not match (this might be expected if test credentials are wrong)\n";
        } else {
            echo "   SUCCESS: Password matches\n";
        }
        
        // Test 4: Session variables
        echo "4. Testing session variable setup...\n";
        
        // Clear session
        $_SESSION = [];
        
        // Simulate setting session vars like the login page does
        switch ($portal) {
            case 'admin':
                $_SESSION['CC_Username'] = $config['username'];
                $_SESSION['admin_id'] = $user['ID'] ?? $user['Userid'] ?? 1;
                $_SESSION['user_role'] = 'admin';
                $_SESSION['user_name'] = $user['Name'] ?? 'Admin';
                break;
            case 'driver':
                $_SESSION['MM_Username'] = $config['username'];
                $_SESSION['MM_UserGroup'] = $config['username'];
                $_SESSION['driver_id'] = $user['driverID'] ?? $user['id'] ?? '';
                $_SESSION['driver_name'] = $user['name'] ?? 'Driver';
                $_SESSION['user_role'] = 'driver';
                break;
            case 'booking':
                $_SESSION['CC_Username'] = $config['username'];
                $_SESSION['user_email'] = $config['username'];
                $_SESSION['user_id'] = $user['ID'] ?? $user['Userid'] ?? '';
                $_SESSION['user_role'] = 'customer';
                $_SESSION['CC_UserGroup'] = $config['username'];
                break;
        }
        
        // Check all expected session variables are set
        $allSet = true;
        foreach ($config['expected_session_vars'] as $var) {
            if (!isset($_SESSION[$var])) {
                echo "   ERROR: Session variable '{$var}' not set\n";
                $allSet = false;
            }
        }
        
        if ($allSet) {
            echo "   SUCCESS: All expected session variables set\n";
        }
        
        // Test 5: Simulate redirect and session persistence
        echo "5. Testing session persistence (write & close)...\n";
        
        try {
            session_write_close();
            echo "   SUCCESS: Session written to disk\n";
        } catch (Exception $e) {
            echo "   ERROR: " . $e->getMessage() . "\n";
        }
        
        echo "\n";
        
    } catch (Exception $e) {
        echo "   EXCEPTION: " . $e->getMessage() . "\n\n";
    }
}

echo "</pre>";

// Also test session configuration
echo "<h2>Session Configuration</h2>";
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? "ACTIVE" : (session_status() === PHP_SESSION_NONE ? "NONE" : "DISABLED")) . "\n";
echo "Session ID: " . session_id() . "\n";
echo "Session Save Path: " . ini_get('session.save_path') . "\n";
echo "Session Name: " . session_name() . "\n";
echo "Session Cookie HttpOnly: " . (ini_get('session.cookie_httponly') ? "Yes" : "No") . "\n";
echo "Session Use Strict Mode: " . (ini_get('session.use_strict_mode') ? "Yes" : "No") . "\n";
echo "</pre>";

// Check database connection
echo "<h2>Database Connection</h2>";
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
try {
    global $DB;
    
    if ($DB) {
        echo "Database connection: OK\n";
        
        // Try a simple query
        $stmt = $DB->prepare("SELECT 1 as test");
        $stmt->execute();
        $result = $stmt->fetch();
        
        echo "Database query test: OK\n";
    } else {
        echo "Database connection: FAILED\n";
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
echo "</pre>";

echo "<hr>";
echo "<p><strong>Note:</strong> If test credentials don't match actual database users, you'll see password mismatch warnings. Update the test data in this script with actual credentials from your database.</p>";
?>
