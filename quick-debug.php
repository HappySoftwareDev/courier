<?php
/**
 * Quick Database & Login Debug Test
 */
session_start();
require_once 'config/bootstrap.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Quick Login Debug</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #667eea; }
        .success { border-left-color: #28a745; color: #155724; }
        .error { border-left-color: #dc3545; color: #721c24; }
        .warning { border-left-color: #ffc107; color: #856404; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background: #667eea; color: white; }
        code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>

<h1>🔧 Quick Login Debug</h1>

<div class="box">
    <h2>Step 1: Database Check</h2>
    <?php
        try {
            global $DB;
            
            if (!$DB) {
                echo "<div class='error'>❌ Database connection FAILED - \$DB is null</div>";
            } else {
                echo "<div class='success'>✅ Database connection OK</div>";
                
                // Try simple query
                $test = $DB->prepare("SELECT 1 as test");
                if ($test) {
                    $test->execute();
                    echo "<div class='success'>✅ Query execution OK</div>";
                } else {
                    echo "<div class='error'>❌ Failed to prepare statement</div>";
                }
            }
        } catch (Exception $e) {
            echo "<div class='error'>❌ Exception: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    ?>
</div>

<div class="box">
    <h2>Step 2: Check Which Users Exist</h2>
    
    <h3>Admin Table:</h3>
    <?php
        try {
            global $DB;
            $stmt = $DB->prepare("SELECT COUNT(*) as count FROM `admin`");
            $stmt->execute();
            $result = $stmt->fetch();
            $count = $result['count'] ?? 0;
            
            if ($count > 0) {
                echo "<div class='success'>✅ Found $count admin user(s)</div>";
                
                $stmt = $DB->prepare("SELECT ID, Email, Name FROM `admin` LIMIT 10");
                $stmt->execute();
                
                echo "<table>";
                echo "<tr><th>ID</th><th>Email</th><th>Name</th></tr>";
                while ($row = $stmt->fetch()) {
                    echo "<tr><td>" . $row['ID'] . "</td><td>" . $row['Email'] . "</td><td>" . $row['Name'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='error'>❌ No admin users found</div>";
            }
        } catch (Exception $e) {
            echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    ?>
    
    <h3>Users Table (Booking/Customer):</h3>
    <?php
        try {
            global $DB;
            $stmt = $DB->prepare("SELECT COUNT(*) as count FROM `users`");
            $stmt->execute();
            $result = $stmt->fetch();
            $count = $result['count'] ?? 0;
            
            if ($count > 0) {
                echo "<div class='success'>✅ Found $count user(s)</div>";
                
                $stmt = $DB->prepare("SELECT ID, email, Name FROM `users` LIMIT 10");
                $stmt->execute();
                
                echo "<table>";
                echo "<tr><th>ID</th><th>Email</th><th>Name</th></tr>";
                while ($row = $stmt->fetch()) {
                    echo "<tr><td>" . ($row['ID'] ?? $row['Userid'] ?? '') . "</td><td>" . ($row['email'] ?? $row['Email'] ?? '') . "</td><td>" . ($row['Name'] ?? $row['name'] ?? '') . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='error'>❌ No users found</div>";
            }
        } catch (Exception $e) {
            echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    ?>
    
    <h3>Driver Table:</h3>
    <?php
        try {
            global $DB;
            $stmt = $DB->prepare("SELECT COUNT(*) as count FROM `driver`");
            $stmt->execute();
            $result = $stmt->fetch();
            $count = $result['count'] ?? 0;
            
            if ($count > 0) {
                echo "<div class='success'>✅ Found $count driver(s)</div>";
                
                $stmt = $DB->prepare("SELECT id, username, name FROM `driver` LIMIT 10");
                $stmt->execute();
                
                echo "<table>";
                echo "<tr><th>ID</th><th>Username</th><th>Name</th></tr>";
                while ($row = $stmt->fetch()) {
                    echo "<tr><td>" . ($row['id'] ?? $row['ID'] ?? $row['driverID'] ?? '') . "</td><td>" . ($row['username'] ?? '') . "</td><td>" . ($row['name'] ?? '') . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='error'>❌ No drivers found</div>";
            }
        } catch (Exception $e) {
            echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    ?>
</div>

<div class="box">
    <h2>Step 3: Create Test Users</h2>
    <p>If no users were found above, click the button to create them:</p>
    <form method="POST" style="margin-top: 15px;">
        <button type="submit" name="create_users" style="padding: 10px 20px; background: #667eea; color: white; border: none; cursor: pointer; border-radius: 5px; font-size: 16px;">Create Test Users Now</button>
    </form>
    
    <?php
        if (isset($_POST['create_users'])) {
            try {
                global $DB;
                
                // Create admin user
                echo "<h3>Creating Users...</h3>";
                
                // Check if admin exists
                $stmt = $DB->prepare("SELECT ID FROM `admin` WHERE Email = ?");
                $stmt->execute(['admin@app.wgroos.com']);
                if (!$stmt->fetch()) {
                    $stmt = $DB->prepare("INSERT INTO `admin` (`date`, `Name`, `Email`, `phone`, `Password`) VALUES (NOW(), 'System Admin', 'admin@app.wgroos.com', '+000000000000', '12345#$')");
                    $stmt->execute();
                    echo "<div class='success'>✅ Created admin@app.wgroos.com</div>";
                } else {
                    echo "<div class='warning'>⚠️ Admin user already exists</div>";
                }
                
                // Check if customer exists
                $stmt = $DB->prepare("SELECT ID FROM `users` WHERE email = ?");
                $stmt->execute(['customer@app.wgroos.com']);
                if (!$stmt->fetch()) {
                    $stmt = $DB->prepare("INSERT INTO `users` (`date`, `Name`, `email`, `phone`, `password`) VALUES (NOW(), 'Test Customer', 'customer@app.wgroos.com', '+000000000000', '12345#$')");
                    $stmt->execute();
                    echo "<div class='success'>✅ Created customer@app.wgroos.com</div>";
                } else {
                    echo "<div class='warning'>⚠️ Customer user already exists</div>";
                }
                
                // Check if driver exists
                $stmt = $DB->prepare("SELECT id FROM `driver` WHERE username = ?");
                $stmt->execute(['testdriver']);
                if (!$stmt->fetch()) {
                    $stmt = $DB->prepare("INSERT INTO `driver` (`driver_number`, `date`, `name`, `username`, `password`, `email`, `phone`) VALUES (10001, NOW(), 'Test Driver', 'testdriver', '12345#$', 'driver@app.wgroos.com', '+000000000000')");
                    $stmt->execute();
                    echo "<div class='success'>✅ Created driver testdriver</div>";
                } else {
                    echo "<div class='warning'>⚠️ Driver user already exists</div>";
                }
                
                echo "<p><strong>Test Credentials:</strong></p>";
                echo "<code>Admin: admin@app.wgroos.com / 12345#$</code><br>";
                echo "<code>Customer: customer@app.wgroos.com / 12345#$</code><br>";
                echo "<code>Driver: testdriver / 12345#$</code><br>";
                
            } catch (Exception $e) {
                echo "<div class='error'>❌ Error creating users: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    ?>
</div>

<div class="box">
    <h2>Step 4: Test Each Login</h2>
    <p>After users are created, test each portal:</p>
    <ul>
        <li><a href="portals/admin/pages/login.php" target="_blank">Admin Login</a> (Use: admin@app.wgroos.com / 12345#$)</li>
        <li><a href="portals/booking/signin.php" target="_blank">Customer Login</a> (Use: customer@app.wgroos.com / 12345#$)</li>
        <li><a href="portals/driver/signin.php" target="_blank">Driver Login</a> (Use: testdriver / 12345#$)</li>
    </ul>
</div>

</body>
</html>
