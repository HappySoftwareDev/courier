<?php
/**
 * Ensure Test Users Exist
 * Creates default test users if they don't already exist
 */

require_once 'config/bootstrap.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Setup Test Users</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .success { background: #d4edda; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745; color: #155724; }
        .error { background: #f8d7da; padding: 15px; border-radius: 5px; border-left: 4px solid #dc3545; color: #721c24; }
        .info { background: #e7f3ff; padding: 15px; border-radius: 5px; border-left: 4px solid #17a2b8; color: #0c5460; }
        button { padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #5568d3; }
    </style>
</head>
<body>

<h1>Test User Setup</h1>

<?php

try {
    global $DB;
    
    if (!$DB) {
        echo "<div class='error'>ERROR: Database connection failed</div>";
        exit;
    }
    
    // Check and create admin user
    echo "<h2>1. Admin Portal User</h2>";
    
    $stmt = $DB->prepare("SELECT * FROM `admin` WHERE Email = ?");
    $stmt->execute(['admin@app.wgroos.com']);
    $adminUser = $stmt->fetch();
    
    if ($adminUser) {
        echo "<div class='success'>✓ Admin user already exists: admin@app.wgroos.com</div>";
    } else {
        echo "<div class='info'>Creating admin user...</div>";
        
        try {
            $stmt = $DB->prepare("INSERT INTO `admin` (`date`, `Name`, `Email`, `phone`, `Password`, `push_token`) VALUES (NOW(), 'System Admin', 'admin@app.wgroos.com', '+000000000000', '12345#$', NULL)");
            $stmt->execute();
            echo "<div class='success'>✓ Admin user created successfully!</div>";
            echo "<div class='info'><strong>Credentials:</strong> admin@app.wgroos.com / 12345#$</div>";
        } catch (Exception $e) {
            echo "<div class='error'>Error creating admin user: " . $e->getMessage() . "</div>";
        }
    }
    
    // Check and create customer user
    echo "<h2>2. Booking Portal User</h2>";
    
    $stmt = $DB->prepare("SELECT * FROM `users` WHERE email = ?");
    $stmt->execute(['customer@app.wgroos.com']);
    $customerUser = $stmt->fetch();
    
    if ($customerUser) {
        echo "<div class='success'>✓ Customer user already exists: customer@app.wgroos.com</div>";
    } else {
        echo "<div class='info'>Creating customer user...</div>";
        
        try {
            $stmt = $DB->prepare("INSERT INTO `users` (`date`, `Name`, `email`, `phone`, `password`, `days`, `affiliate_no`) VALUES (NOW(), 'Test Customer', 'customer@app.wgroos.com', '+000000000000', '12345#$', 14, NULL)");
            $stmt->execute();
            echo "<div class='success'>✓ Customer user created successfully!</div>";
            echo "<div class='info'><strong>Credentials:</strong> customer@app.wgroos.com / 12345#$</div>";
        } catch (Exception $e) {
            echo "<div class='error'>Error creating customer user: " . $e->getMessage() . "</div>";
        }
    }
    
    // Check and create driver user
    echo "<h2>3. Driver Portal User</h2>";
    
    $stmt = $DB->prepare("SELECT * FROM `driver` WHERE username = ?");
    $stmt->execute(['testdriver']);
    $driverUser = $stmt->fetch();
    
    if ($driverUser) {
        echo "<div class='success'>✓ Driver user already exists: testdriver</div>";
    } else {
        echo "<div class='info'>Creating driver user...</div>";
        
        try {
            $stmt = $DB->prepare("INSERT INTO `driver` (
                `driver_number`, `date`, `name`, `company_name`, `phone`, `address`, `city`, 
                `vehicleMake`, `model`, `year`, `engineCapacity`, `RegNo`, `DOB`, `occupation`, 
                `email`, `mode_of_transport`, `type_of_service`, `truckType`, `username`, 
                `password`, `profileImage`, `online`, `info`
            ) VALUES (
                10001, NOW(), 'Test Driver', 'Test Company', '+000000000000', 'Test Address', 'Test City', 
                'Test Make', 'Test Model', '2020', '2000cc', 'TEST001', '1990-01-01', 'Driver', 
                'driver@app.wgroos.com', 'Car', 'Parcel Delivery', 'Standard', 'testdriver', 
                '12345#$', 'profilePic', 'offline', '....'
            )");
            $stmt->execute();
            echo "<div class='success'>✓ Driver user created successfully!</div>";
            echo "<div class='info'><strong>Credentials:</strong> testdriver / 12345#$</div>";
        } catch (Exception $e) {
            echo "<div class='error'>Error creating driver user: " . $e->getMessage() . "</div>";
        }
    }
    
    echo "<h2>Summary</h2>";
    echo "<div class='info'>";
    echo "<strong>Portal Login Credentials:</strong><br><br>";
    echo "<strong>Admin Portal:</strong> <a href='portals/admin/pages/login.php'>portals/admin/pages/login.php</a><br>";
    echo "Email: admin@app.wgroos.com<br>";
    echo "Password: 12345#$<br><br>";
    echo "<strong>Booking Portal:</strong> <a href='portals/booking/signin.php'>portals/booking/signin.php</a><br>";
    echo "Email: customer@app.wgroos.com<br>";
    echo "Password: 12345#$<br><br>";
    echo "<strong>Driver Portal:</strong> <a href='portals/driver/signin.php'>portals/driver/signin.php</a><br>";
    echo "Username: testdriver<br>";
    echo "Password: 12345#$<br>";
    echo "</div>";
    
    echo "<h2>Next Steps</h2>";
    echo "<ol>";
    echo "<li>Try logging into each portal with the credentials above</li>";
    echo "<li>If login still doesn't work, visit <a href='diagnose-login.php'>diagnose-login.php</a> for detailed diagnostics</li>";
    echo "<li>Check browser console (F12) for any JavaScript errors</li>";
    echo "<li>Check server error logs for PHP errors</li>";
    echo "</ol>";
    
} catch (Exception $e) {
    echo "<div class='error'>Fatal error: " . $e->getMessage() . "</div>";
}

?>

</body>
</html>
