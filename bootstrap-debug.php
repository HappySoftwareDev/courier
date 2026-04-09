<?php
/**
 * Detailed Bootstrap Debug - Find where it fails
 */

header('Content-Type: text/html; charset=utf-8');

// Enable ALL errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Detailed Bootstrap Debug</h1>";
echo "<style>
    body { font-family: monospace; padding: 20px; background: #f5f5f5; }
    .step { margin: 15px 0; padding: 10px; background: white; border-left: 4px solid #ddd; }
    .success { border-left-color: #4caf50; background: #e8f5e9; }
    .error { border-left-color: #f44336; background: #ffebee; }
    .process { border-left-color: #ff9800; background: #fff3e0; }
</style>";

try {
    echo "<div class='step process'>Step 1: Setting APP_ROOT</div>";
    define('APP_ROOT', dirname(__FILE__));
    echo "✅ APP_ROOT = " . APP_ROOT . "\n<br>";
    
    echo "<div class='step process'>Step 2: Checking database.php</div>";
    $dbPath = APP_ROOT . '/config/database.php';
    if (file_exists($dbPath)) {
        echo "✅ database.php exists at $dbPath\n<br>";
    } else {
        throw new Exception("database.php NOT FOUND at $dbPath");
    }
    
    echo "<div class='step process'>Step 3: Loading database.php</div>";
    require_once $dbPath;
    echo "✅ database.php loaded\n<br>";
    
    if (!class_exists('Database')) {
        throw new Exception("Database class not found after loading database.php");
    }
    echo "✅ Database class exists\n<br>";
    
    echo "<div class='step process'>Step 4: Creating Database instance</div>";
    try {
        $DB = Database::getInstance();
        echo "✅ Database instance created\n<br>";
        
        $conn = $DB->getConnection();
        if ($conn) {
            echo "✅ MySQLi connection active\n<br>";
            
            // Test a query
            $result = $DB->query("SELECT 1 as test");
            echo "✅ Test query successful\n<br>";
        } else {
            throw new Exception("Connection object is null");
        }
    } catch (Exception $e) {
        throw new Exception("Database::getInstance() failed: " . $e->getMessage());
    }
    
    echo "<div class='step process'>Step 5: Checking ConfigManager</div>";
    $configPath = APP_ROOT . '/config/ConfigManager.php';
    if (file_exists($configPath)) {
        echo "✅ ConfigManager.php exists\n<br>";
        require_once $configPath;
        if (class_exists('ConfigManager')) {
            echo "✅ ConfigManager class exists\n<br>";
        } else {
            throw new Exception("ConfigManager class NOT found after loading");
        }
    } else {
        echo "⚠️ ConfigManager.php not found (optional)\n<br>";
    }
    
    echo "<div class='step process'>Step 6: Checking AuthManager</div>";
    $authPath = APP_ROOT . '/app/classes/AuthManager.php';
    if (file_exists($authPath)) {
        echo "✅ AuthManager.php exists at $authPath\n<br>";
        require_once $authPath;
        if (class_exists('AuthManager')) {
            echo "✅ AuthManager class exists\n<br>";
            
            // Check methods
            if (method_exists('AuthManager', 'isAuthenticated')) {
                echo "✅ AuthManager::isAuthenticated() exists\n<br>";
            } else {
                echo "❌ AuthManager::isAuthenticated() NOT found\n<br>";
            }
            
            if (method_exists('AuthManager', 'getUserRole')) {
                echo "✅ AuthManager::getUserRole() exists\n<br>";
            } else {
                echo "❌ AuthManager::getUserRole() NOT found\n<br>";
            }
        } else {
            throw new Exception("AuthManager class NOT found after loading");
        }
    } else {
        throw new Exception("AuthManager.php NOT found at $authPath");
    }
    
    echo "<div class='step process'>Step 7: Checking Session Status</div>";
    
    // Configure session like bootstrap.php does
    if (session_status() === PHP_SESSION_NONE) {
        $sessionPath = APP_ROOT . '/storage/sessions';
        if (!is_dir($sessionPath)) {
            @mkdir($sessionPath, 0755, true);
        }
        
        if (is_dir($sessionPath) && is_writable($sessionPath)) {
            ini_set('session.save_path', $sessionPath);
            session_save_path($sessionPath);
        } else {
            ini_set('session.save_path', '/tmp');
            @session_save_path('/tmp');
        }
        
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_strict_mode', 1);
        @session_start();
    }
    
    if (session_status() === PHP_SESSION_ACTIVE) {
        echo "✅ Session is active (ID: " . session_id() . ")\n<br>";
    } else {
        echo "⚠️ Session could not be started\n<br>";
    }
    
    echo "<div class='step success'><h2>✅ ALL CHECKS PASSED!</h2></div>";
    echo "<p>Bootstrap should be working. Try visiting <a href='index.php'>index.php</a></p>";
    
} catch (Exception $e) {
    echo "<div class='step error'>";
    echo "<h2>❌ ERROR FOUND</h2>";
    echo "<p><strong>" . $e->getMessage() . "</strong></p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}

echo "<hr>";
echo "<p><a href='debug.php'>← Back to Full Debug</a> | <a href='index.php'>Go to Homepage →</a></p>";
?>
