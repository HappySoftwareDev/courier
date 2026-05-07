<?php
/**
 * Quick Test - Check if database and users are still working
 */

echo "<pre>";

// Test 1: Check bootstrap loads
try {
    require_once 'config/bootstrap.php';
    echo "✅ Bootstrap loaded successfully\n";
} catch (Exception $e) {
    echo "❌ Bootstrap failed: " . $e->getMessage() . "\n";
    exit;
}

// Test 2: Check database connection
try {
    global $DB;
    if (!$DB) {
        echo "❌ Database connection failed - \$DB is null\n";
        exit;
    }
    echo "✅ Database connected\n";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    exit;
}

// Test 3: Check admin user exists
try {
    $stmt = $DB->prepare("SELECT * FROM `admin` WHERE Email = ?");
    $stmt->execute(['admin@app.wgroos.com']);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "✅ Admin user found: admin@app.wgroos.com\n";
        echo "   Password field: " . (isset($user['Password']) ? substr($user['Password'], 0, 10) . "..." : "NOT FOUND") . "\n";
    } else {
        echo "❌ Admin user NOT found\n";
    }
} catch (Exception $e) {
    echo "❌ Error checking admin user: " . $e->getMessage() . "\n";
}

// Test 4: Check customer user exists
try {
    $stmt = $DB->prepare("SELECT * FROM `users` WHERE email = ?");
    $stmt->execute(['customer@app.wgroos.com']);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "✅ Customer user found: customer@app.wgroos.com\n";
        echo "   Password field: " . (isset($user['password']) ? substr($user['password'], 0, 10) . "..." : (isset($user['Password']) ? substr($user['Password'], 0, 10) . "..." : "NOT FOUND")) . "\n";
    } else {
        echo "❌ Customer user NOT found\n";
    }
} catch (Exception $e) {
    echo "❌ Error checking customer user: " . $e->getMessage() . "\n";
}

// Test 5: Check driver user exists
try {
    $stmt = $DB->prepare("SELECT * FROM `driver` WHERE username = ?");
    $stmt->execute(['testdriver']);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "✅ Driver user found: testdriver\n";
        echo "   Password field: " . (isset($user['password']) ? substr($user['password'], 0, 10) . "..." : "NOT FOUND") . "\n";
    } else {
        echo "❌ Driver user NOT found\n";
    }
} catch (Exception $e) {
    echo "❌ Error checking driver user: " . $e->getMessage() . "\n";
}

echo "\nAll systems operational!\n";
echo "</pre>";
?>
