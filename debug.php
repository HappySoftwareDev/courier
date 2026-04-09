<?php
/**
 * Debug Script - Check what's failing
 */

header('Content-Type: text/html; charset=utf-8');

// Enable all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h1>🔍 Application Debug Info</h1>";

echo "<h2>1. Basic PHP Info</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "</pre>";

echo "<h2>2. Loading Bootstrap</h2>";
try {
    define('APP_ROOT', dirname(__FILE__));
    echo "APP_ROOT: " . APP_ROOT . "\n";
    echo "Bootstrap path: " . APP_ROOT . '/config/bootstrap.php' . "\n";
    
    require_once APP_ROOT . '/config/bootstrap.php';
    echo "✅ Bootstrap loaded successfully\n";
} catch (Exception $e) {
    echo "❌ Bootstrap Error: " . $e->getMessage() . "\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    exit;
}

echo "<h2>3. Check Defined Constants</h2>";
echo "<pre>";
echo "APP_NAME: " . (defined('APP_NAME') ? APP_NAME : 'NOT DEFINED') . "\n";
echo "APP_VERSION: " . (defined('APP_VERSION') ? APP_VERSION : 'NOT DEFINED') . "\n";
echo "TEMPLATE_PATH: " . (defined('TEMPLATE_PATH') ? TEMPLATE_PATH : 'NOT DEFINED') . "\n";
echo "</pre>";

echo "<h2>4. Check Classes Loaded</h2>";
echo "<pre>";
echo "AuthManager exists: " . (class_exists('AuthManager') ? "✅ YES" : "❌ NO") . "\n";
echo "Database exists: " . (class_exists('Database') ? "✅ YES" : "❌ NO") . "\n";
echo "ConfigManager exists: " . (class_exists('ConfigManager') ? "✅ YES" : "❌ NO") . "\n";
echo "</pre>";

echo "<h2>5. Test Database Connection</h2>";
try {
    $DB = Database::getInstance();
    $result = $DB->query("SELECT 1");
    echo "✅ Database connected successfully\n";
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
}

echo "<h2>6. Test AuthManager Static Methods</h2>";
echo "<pre>";
echo "AuthManager::isAuthenticated() exists: " . (method_exists('AuthManager', 'isAuthenticated') ? "✅ YES" : "❌ NO") . "\n";
echo "AuthManager::hashPassword() exists: " . (method_exists('AuthManager', 'hashPassword') ? "✅ YES" : "❌ NO") . "\n";
echo "</pre>";

echo "<h2>7. Check Session</h2>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? "Active" : "Not Active") . "\n";
echo "Session Data: ";
print_r($_SESSION);
echo "</pre>";

echo "<h2>✅ Debug Complete</h2>";
echo "<p><a href='index.php'>Go to Homepage</a></p>";
?>
