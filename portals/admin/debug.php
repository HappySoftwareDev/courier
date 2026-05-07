<?php
/**
 * Simple Login Debug - Place this in portals/admin/ directory
 */
session_start();
require_once '../../config/bootstrap.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Login</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #667eea; }
        .success { border-left-color: #28a745; color: #155724; background: #d4edda; }
        .error { border-left-color: #dc3545; color: #721c24; background: #f8d7da; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background: #667eea; color: white; }
        button { padding: 10px 20px; background: #667eea; color: white; border: none; cursor: pointer; border-radius: 5px; }
    </style>
</head>
<body>

<h1>🔍 Login Debug</h1>

<div class="box success">
    <h2>Step 1: Database Connection</h2>
    <?php
        try {
            global $DB;
            if ($DB) {
                echo "✅ Database connected!<br>";
                $stmt = $DB->prepare("SELECT 1");
                $stmt->execute();
                echo "✅ Query test passed!";
            } else {
                echo "<span style='color:red'>❌ No database connection</span>";
            }
        } catch (Exception $e) {
            echo "<span style='color:red'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</span>";
        }
    ?>
</div>

<div class="box">
    <h2>Step 2: Check Existing Users</h2>
    
    <h3>Admin Users:</h3>
    <?php
        try {
            global $DB;
            $stmt = $DB->prepare("SELECT * FROM `admin`");
            $stmt->execute();
            echo "<table><tr><th>ID</th><th>Email</th><th>Name</th></tr>";
            $found = 0;
            while ($row = $stmt->fetch()) {
                $found++;
                echo "<tr><td>" . $row['ID'] . "</td><td>" . $row['Email'] . "</td><td>" . $row['Name'] . "</td></tr>";
            }
            if ($found == 0) echo "<tr><td colspan='3'>No admin users</td></tr>";
            echo "</table>";
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    ?>
    
    <h3>Users (Customers):</h3>
    <?php
        try {
            global $DB;
            $stmt = $DB->prepare("SELECT * FROM `users` LIMIT 10");
            $stmt->execute();
            echo "<table><tr><th>ID</th><th>Email</th><th>Name</th></tr>";
            $found = 0;
            while ($row = $stmt->fetch()) {
                $found++;
                echo "<tr><td>" . ($row['ID'] ?? $row['Userid']) . "</td><td>" . ($row['email'] ?? $row['Email']) . "</td><td>" . ($row['name'] ?? $row['Name']) . "</td></tr>";
            }
            if ($found == 0) echo "<tr><td colspan='3'>No users</td></tr>";
            echo "</table>";
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    ?>
    
    <h3>Drivers:</h3>
    <?php
        try {
            global $DB;
            $stmt = $DB->prepare("SELECT * FROM `driver` LIMIT 10");
            $stmt->execute();
            echo "<table><tr><th>ID</th><th>Username</th><th>Name</th></tr>";
            $found = 0;
            while ($row = $stmt->fetch()) {
                $found++;
                echo "<tr><td>" . ($row['id'] ?? $row['driverID']) . "</td><td>" . ($row['username'] ?? '') . "</td><td>" . ($row['name'] ?? '') . "</td></tr>";
            }
            if ($found == 0) echo "<tr><td colspan='3'>No drivers</td></tr>";
            echo "</table>";
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    ?>
</div>

<div class="box">
    <h2>Step 3: Create Test Users</h2>
    <form method="POST">
        <button type="submit" name="create">Create Test Users</button>
    </form>
    
    <?php
        if (isset($_POST['create'])) {
            try {
                global $DB;
                
                // Admin
                $stmt = $DB->prepare("INSERT IGNORE INTO `admin` (`date`, `Name`, `Email`, `phone`, `Password`) VALUES (NOW(), 'Admin', 'admin@app.wgroos.com', '+1', '12345#$')");
                $stmt->execute();
                echo "<div class='success'>✅ Ensured admin@app.wgroos.com exists</div>";
                
                // Customer
                $stmt = $DB->prepare("INSERT IGNORE INTO `users` (`date`, `Name`, `email`, `phone`, `password`) VALUES (NOW(), 'Customer', 'customer@app.wgroos.com', '+1', '12345#$')");
                $stmt->execute();
                echo "<div class='success'>✅ Ensured customer@app.wgroos.com exists</div>";
                
                // Driver
                $stmt = $DB->prepare("INSERT IGNORE INTO `driver` (`driver_number`, `date`, `name`, `username`, `password`, `email`, `phone`, `company_name`, `vehicleMake`, `model`, `year`) VALUES (10001, NOW(), 'Driver', 'testdriver', '12345#$', 'driver@app.wgroos.com', '+1', 'Test', 'Test', 'Test', '2020')");
                $stmt->execute();
                echo "<div class='success'>✅ Ensured testdriver exists</div>";
                
                echo "<div class='success'><strong>Test Credentials:</strong><br>";
                echo "Admin: admin@app.wgroos.com / 12345#$<br>";
                echo "Customer: customer@app.wgroos.com / 12345#$<br>";
                echo "Driver: testdriver / 12345#$</div>";
                
            } catch (Exception $e) {
                echo "<div class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    ?>
</div>

<div class="box">
    <h2>Step 4: Check Server Logs</h2>
    <p>SSH into your server and check the PHP error log:</p>
    <code>tail -f /path/to/logs/error.log</code><br><br>
    <p>Then try logging in and watch for debug messages.</p>
</div>

</body>
</html>
