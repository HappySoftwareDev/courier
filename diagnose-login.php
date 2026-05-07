<?php
/**
 * Comprehensive Login Diagnostics
 * Identify exactly where login is failing
 */

session_start();
require_once 'config/bootstrap.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Diagnostics</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .section { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #667eea; }
        .error { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .info { background: #e7f3ff; padding: 10px; border-radius: 3px; margin: 5px 0; }
        pre { background: #f0f0f0; padding: 10px; border-radius: 3px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 8px; text-align: left; border: 1px solid #ddd; }
        th { background: #667eea; color: white; }
    </style>
</head>
<body>

<h1>🔍 Login System Diagnostics</h1>

<div class="section">
    <h2>1. Environment Setup</h2>
    <?php
        echo "PHP Version: " . phpversion() . "<br>";
        echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? "<span class='success'>ACTIVE</span>" : "<span class='error'>INACTIVE</span>") . "<br>";
        echo "Session ID: " . session_id() . "<br>";
        echo "Session Save Path: " . ini_get('session.save_path') . "<br>";
        
        // Check session directory
        $sessionPath = dirname(__FILE__) . '/storage/sessions';
        echo "Custom Session Path: " . $sessionPath . "<br>";
        if (is_dir($sessionPath)) {
            echo "   Status: <span class='success'>EXISTS</span><br>";
            echo "   Writable: " . (is_writable($sessionPath) ? "<span class='success'>YES</span>" : "<span class='error'>NO</span>") . "<br>";
        } else {
            echo "   Status: <span class='error'>DOES NOT EXIST</span><br>";
        }
    ?>
</div>

<div class="section">
    <h2>2. Database Connection</h2>
    <?php
        try {
            global $DB;
            
            if (!$DB) {
                echo "<span class='error'>ERROR: Global \$DB is not set</span>";
            } else {
                echo "<span class='success'>✓ Database connection exists</span><br>";
                
                // Try a simple query
                $stmt = $DB->prepare("SELECT 1 as test");
                if ($stmt) {
                    echo "<span class='success'>✓ Prepared statements work</span><br>";
                } else {
                    echo "<span class='error'>✗ Failed to prepare statement</span><br>";
                }
            }
        } catch (Exception $e) {
            echo "<span class='error'>Exception: " . $e->getMessage() . "</span>";
        }
    ?>
</div>

<div class="section">
    <h2>3. Test User Records</h2>
    
    <h3>Admin Table</h3>
    <?php
        try {
            global $DB;
            
            $stmt = $DB->prepare("SELECT * FROM `admin` LIMIT 5");
            $stmt->execute();
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Email</th><th>Name</th><th>Password (first 20 chars)</th></tr>";
            
            $found = false;
            while ($row = $stmt->fetch()) {
                $found = true;
                $pwd = isset($row['Password']) ? substr($row['Password'], 0, 20) : 'N/A';
                echo "<tr>";
                echo "<td>" . ($row['ID'] ?? $row['Userid'] ?? 'N/A') . "</td>";
                echo "<td>" . ($row['Email'] ?? 'N/A') . "</td>";
                echo "<td>" . ($row['Name'] ?? 'N/A') . "</td>";
                echo "<td>" . $pwd . "</td>";
                echo "</tr>";
            }
            
            if (!$found) {
                echo "<tr><td colspan='4'><span class='warning'>⚠️ No admin users found!</span></td></tr>";
            }
            
            echo "</table>";
        } catch (Exception $e) {
            echo "<span class='error'>Error querying admin table: " . $e->getMessage() . "</span>";
        }
    ?>
    
    <h3>Driver Table</h3>
    <?php
        try {
            global $DB;
            
            $stmt = $DB->prepare("SELECT * FROM `driver` LIMIT 5");
            $stmt->execute();
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Password (first 20 chars)</th></tr>";
            
            $found = false;
            while ($row = $stmt->fetch()) {
                $found = true;
                $pwd = isset($row['password']) ? substr($row['password'], 0, 20) : (isset($row['Password']) ? substr($row['Password'], 0, 20) : 'N/A');
                echo "<tr>";
                echo "<td>" . ($row['id'] ?? $row['ID'] ?? $row['driverID'] ?? 'N/A') . "</td>";
                echo "<td>" . ($row['username'] ?? 'N/A') . "</td>";
                echo "<td>" . ($row['name'] ?? 'N/A') . "</td>";
                echo "<td>" . $pwd . "</td>";
                echo "</tr>";
            }
            
            if (!$found) {
                echo "<tr><td colspan='4'><span class='warning'>⚠️ No driver users found!</span></td></tr>";
            }
            
            echo "</table>";
        } catch (Exception $e) {
            echo "<span class='error'>Error querying driver table: " . $e->getMessage() . "</span>";
        }
    ?>
    
    <h3>Users Table</h3>
    <?php
        try {
            global $DB;
            
            $stmt = $DB->prepare("SELECT * FROM `users` LIMIT 5");
            $stmt->execute();
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Email</th><th>Name</th><th>Password (first 20 chars)</th></tr>";
            
            $found = false;
            while ($row = $stmt->fetch()) {
                $found = true;
                $pwd = isset($row['password']) ? substr($row['password'], 0, 20) : (isset($row['Password']) ? substr($row['Password'], 0, 20) : 'N/A');
                echo "<tr>";
                echo "<td>" . ($row['ID'] ?? $row['Userid'] ?? 'N/A') . "</td>";
                echo "<td>" . ($row['email'] ?? $row['Email'] ?? 'N/A') . "</td>";
                echo "<td>" . ($row['name'] ?? $row['Name'] ?? 'N/A') . "</td>";
                echo "<td>" . $pwd . "</td>";
                echo "</tr>";
            }
            
            if (!$found) {
                echo "<tr><td colspan='4'><span class='warning'>⚠️ No users found!</span></td></tr>";
            }
            
            echo "</table>";
        } catch (Exception $e) {
            echo "<span class='error'>Error querying users table: " . $e->getMessage() . "</span>";
        }
    ?>
</div>

<div class="section">
    <h2>4. Test Login Flow - Admin</h2>
    
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_admin'])) {
            $email = trim($_POST['admin_email'] ?? '');
            $password = trim($_POST['admin_password'] ?? '');
            
            echo "<div class='info'><strong>Testing admin login with:</strong><br>";
            echo "Email: " . htmlspecialchars($email) . "<br>";
            echo "Password: " . htmlspecialchars($password) . "</div>";
            
            try {
                global $DB;
                
                // Step 1: Query
                echo "<br><strong>Step 1: Query database</strong><br>";
                $query = "SELECT * FROM `admin` WHERE Email = ?";
                echo "Query: " . $query . "<br>";
                
                $stmt = $DB->prepare($query);
                if (!$stmt) {
                    echo "<span class='error'>✗ Failed to prepare statement</span>";
                } else {
                    echo "<span class='success'>✓ Statement prepared</span><br>";
                    
                    $stmt->execute([$email]);
                    echo "<span class='success'>✓ Query executed</span><br>";
                    
                    $user = $stmt->fetch();
                    
                    if (!$user) {
                        echo "<span class='error'>✗ No user found with email: " . htmlspecialchars($email) . "</span>";
                    } else {
                        echo "<span class='success'>✓ User found!</span><br>";
                        echo "User ID: " . ($user['ID'] ?? $user['Userid'] ?? 'N/A') . "<br>";
                        echo "User Name: " . ($user['Name'] ?? 'N/A') . "<br>";
                        
                        // Step 2: Check password
                        echo "<br><strong>Step 2: Check password</strong><br>";
                        
                        $storedPassword = $user['Password'] ?? $user['password'] ?? null;
                        
                        if (!$storedPassword) {
                            echo "<span class='error'>✗ No password field found</span>";
                        } else {
                            echo "Stored password type: " . gettype($storedPassword) . "<br>";
                            echo "Stored password length: " . strlen($storedPassword) . "<br>";
                            echo "Stored password (first 20 chars): " . substr($storedPassword, 0, 20) . "<br>";
                            
                            $match1 = ($storedPassword === $password);
                            $match2 = password_verify($password, $storedPassword);
                            
                            echo "Plain text match: " . ($match1 ? "<span class='success'>✓ YES</span>" : "<span class='error'>✗ NO</span>") . "<br>";
                            echo "Hash verify match: " . ($match2 ? "<span class='success'>✓ YES</span>" : "<span class='error'>✗ NO</span>") . "<br>";
                            
                            if ($match1 || $match2) {
                                echo "<br><span class='success'>✓ PASSWORD MATCHES - Login should succeed</span>";
                                
                                // Simulate session
                                echo "<br><strong>Step 3: Setting session variables</strong><br>";
                                $_SESSION['CC_Username'] = $email;
                                $_SESSION['admin_id'] = $user['ID'] ?? $user['Userid'] ?? 1;
                                $_SESSION['user_role'] = 'admin';
                                $_SESSION['user_name'] = $user['Name'] ?? 'Admin';
                                
                                session_write_close();
                                echo "<span class='success'>✓ Session variables set and written</span>";
                            } else {
                                echo "<br><span class='error'>✗ PASSWORD DOES NOT MATCH</span>";
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                echo "<span class='error'>Exception: " . $e->getMessage() . "</span>";
            }
        }
    ?>
    
    <form method="POST" style="margin-top: 15px; border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
        <h4>Manual Admin Login Test</h4>
        <label>Email: <input type="email" name="admin_email" required value="admin@app.wgroos.com"></label><br>
        <label>Password: <input type="password" name="admin_password" required value="12345#$"></label><br>
        <button type="submit" name="test_admin">Test Admin Login</button>
    </form>
</div>

<div class="section">
    <h2>5. Portal Login Pages Accessibility</h2>
    <?php
        $portals = [
            'Admin Portal' => 'portals/admin/pages/login.php',
            'Driver Portal' => 'portals/driver/signin.php',
            'Booking Portal' => 'portals/booking/signin.php',
        ];
        
        $basePath = dirname(__FILE__);
        
        foreach ($portals as $name => $path) {
            $fullPath = $basePath . '/' . $path;
            $exists = file_exists($fullPath);
            $readable = $exists && is_readable($fullPath);
            
            echo "<div>";
            echo "<strong>" . $name . "</strong>: " . $path . "<br>";
            echo "File exists: " . ($exists ? "<span class='success'>✓ YES</span>" : "<span class='error'>✗ NO</span>") . "<br>";
            echo "File readable: " . ($readable ? "<span class='success'>✓ YES</span>" : "<span class='error'>✗ NO</span>") . "<br>";
            echo "</div><br>";
        }
    ?>
</div>

<div class="section">
    <h2>6. Recommendations</h2>
    <ul>
        <li>If no users are found in tables, you need to create test users first</li>
        <li>If database connection fails, check config/database.php credentials</li>
        <li>If session directory doesn't exist/isn't writable, bootstrap.php should create it</li>
        <li>Use the test form above to verify the login flow works</li>
        <li>Check browser console and server error logs for any JavaScript or PHP errors</li>
    </ul>
</div>

</body>
</html>
