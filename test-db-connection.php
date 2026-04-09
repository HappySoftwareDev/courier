<?php
/**
 * Database Connection Test Script
 * Run this to diagnose database connectivity issues
 */

header('Content-Type: text/plain; charset=utf-8');

echo "=== DATABASE CONNECTION DIAGNOSTIC TEST ===\n\n";

// 1. Check PHP Version
echo "1. PHP Version: " . phpversion() . "\n";

// 2. Check Extensions
echo "\n2. Database Extensions:\n";
echo "   PDO: " . (extension_loaded('pdo') ? "✓ LOADED" : "✗ NOT LOADED") . "\n";
echo "   PDO MySQL: " . (extension_loaded('pdo_mysql') ? "✓ LOADED" : "✗ NOT LOADED") . "\n";
echo "   MySQLi: " . (extension_loaded('mysqli') ? "✓ LOADED" : "✗ NOT LOADED") . "\n";

// 3. Check if database.php exists and can be loaded
echo "\n3. Database Configuration File:\n";
$dbConfigPath = __DIR__ . '/config/database.php';
if (file_exists($dbConfigPath)) {
    echo "   ✓ Found at: " . $dbConfigPath . "\n";
    
    // Load the database class
    require_once $dbConfigPath;
    
    if (class_exists('Database')) {
        echo "   ✓ Database class loaded\n";
    } else {
        echo "   ✗ Database class not found\n";
    }
} else {
    echo "   ✗ NOT FOUND at: " . $dbConfigPath . "\n";
    exit;
}

// 4. Attempt connection
echo "\n4. Attempting Database Connection:\n";

try {
    $db = Database::getInstance();
    echo "   ✓ Successfully connected to database\n";
    
    // Try a simple query
    $result = $db->query("SELECT 1 as connected");
    if ($result) {
        echo "   ✓ Simple query executed successfully\n";
    }
} catch (Exception $e) {
    echo "   ✗ CONNECTION FAILED\n";
    echo "   Error: " . $e->getMessage() . "\n";
}

// 6. Test individual connection parameters
echo "\n6. Testing Direct MySQLi Connection:\n";

$config = [
    'host' => 'localhost',
    'user' => 'faithinf_courier',
    'password' => 'courier2026#$',
    'database' => 'faithinf_courier',
    'port' => 3306,
];

echo "   Host: " . $config['host'] . "\n";
echo "   User: " . $config['user'] . "\n";
echo "   Database: " . $config['database'] . "\n";

try {
    $mysqli = @mysqli_connect(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['database'],
        $config['port']
    );
    
    if (!$mysqli) {
        throw new Exception(mysqli_connect_error());
    }
    
    echo "   ✓ Direct MySQLi connection successful\n";
    mysqli_close($mysqli);
} catch (Exception $e) {
    echo "   ✗ Direct MySQLi connection failed\n";
    echo "   Error: " . $e->getMessage() . "\n";
}

// 6. Check logs directory
echo "\n7. Logs Directory:\n";
$logsPath = __DIR__ . '/logs';
if (is_dir($logsPath)) {
    echo "   ✓ Exists at: " . $logsPath . "\n";
    echo "   Writable: " . (is_writable($logsPath) ? "✓ YES" : "✗ NO") . "\n";
} else {
    echo "   ✗ Does NOT exist at: " . $logsPath . "\n";
}

// 7. Check storage/sessions directory
echo "\n8. Sessions Directory:\n";
$sessionsPath = __DIR__ . '/storage/sessions';
if (is_dir($sessionsPath)) {
    echo "   ✓ Exists at: " . $sessionsPath . "\n";
    echo "   Writable: " . (is_writable($sessionsPath) ? "✓ YES" : "✗ NO") . "\n";
} else {
    echo "   ✗ Does NOT exist at: " . $sessionsPath . "\n";
}

echo "\n=== END OF DIAGNOSTIC TEST ===\n";
?>
