<?php
/**
 * Application Bootstrap
 * Initializes all core components and configurations
 * Unified system for admin, book, and driver portals
 */

// Debug: Log that bootstrap is starting
if (php_sapi_name() !== 'cli') {
    error_log("Bootstrap starting at " . date('Y-m-d H:i:s'));
}

// Configure session handler BEFORE starting session
// This fixes the "No such file or directory" error when session path doesn't exist
if (session_status() === PHP_SESSION_NONE) {
    // Get the application root directory
    $appRoot = dirname(dirname(__FILE__));
    $sessionPath = $appRoot . '/storage/sessions';
    
    // Create session directory if it doesn't exist
    if (!is_dir($sessionPath)) {
        @mkdir($sessionPath, 0755, true);
    }
    
    // Determine where to save sessions
    $savePath = null;
    
    // Priority 1: Use application storage/sessions
    if (is_dir($sessionPath) && is_writable($sessionPath)) {
        $savePath = $sessionPath;
        ini_set('session.save_path', $sessionPath);
        session_save_path($sessionPath);
    }
    // Priority 2: Use system temp directory
    elseif (is_writable(sys_get_temp_dir())) {
        $savePath = sys_get_temp_dir();
        ini_set('session.save_path', $savePath);
        session_save_path($savePath);
    }
    // Priority 3: Use PHP's temp ini or default (may fail but try anyway)
    else {
        ini_set('session.save_path', '/tmp');
        @session_save_path('/tmp');
    }
    
    // Set additional session configuration
    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 100);
    ini_set('session.gc_maxlifetime', 3600);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    
    // Start session - suppress errors if session path fails
    @session_start();
}

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(dirname(__FILE__)) . '/logs/error.log');

// Define app constants
// APP_ROOT should be the /app/ directory in /public_html/app/
// This works whether you access from public_html/ or public_html/app/
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(dirname(__FILE__)));
}
define('APP_NAME', 'Merchant Couriers');
define('APP_VERSION', '3.0.0');
define('TEMPLATE_PATH', APP_ROOT . '/templates');
define('APP_PATH', APP_ROOT . '/app');
define('CONFIG_PATH', APP_ROOT . '/config');

// For WordPress compatibility - detect if running from /app/ subdirectory
if (strpos(__DIR__, '/app/config') !== false || strpos(__DIR__, '\app\config') !== false) {
    // Running from /public_html/app/, so APP_ROOT is already correct
    // No adjustment needed
} else {
    // If somehow running from elsewhere, make sure APP_ROOT is correct
    if (!defined('APP_ROOT_FINAL')) {
        define('APP_ROOT_FINAL', APP_ROOT);
    }
}

// Require core database - MUST BE FIRST
if (!file_exists(APP_ROOT . '/config/database.php')) {
    die('Fatal Error: Database configuration file not found at ' . APP_ROOT . '/config/database.php');
}
require_once APP_ROOT . '/config/database.php';

// Create PDO database instance for new system
try {
    $DB = Database::getInstance();
} catch (Exception $e) {
    die('Fatal Error: Could not initialize database: ' . $e->getMessage());
}

// CRITICAL: Create backward-compatible MySQLi connection for legacy code
// This allows old code using $Connect to work while we transition to new system
// Skip if the file doesn't exist - it's optional for the new architecture
if (file_exists(APP_ROOT . '/Connections/db-connection.php')) {
    require_once APP_ROOT . '/Connections/db-connection.php';
}

// Require configuration and helper classes
if (file_exists(CONFIG_PATH . '/ConfigManager.php')) {
    require_once CONFIG_PATH . '/ConfigManager.php';
    $CONFIG = new ConfigManager($DB);
    $CONFIG->load();
} else {
    // Fallback config if ConfigManager doesn't exist
    $CONFIG = new stdClass();
    $CONFIG->settings = [];
}

// Require core classes (only if they exist)
$coreClasses = [
    APP_ROOT . '/app/classes/AuthManager.php',
    APP_ROOT . '/app/classes/BookingProcessor.php',
    APP_ROOT . '/app/classes/PricingEngine.php',
    APP_ROOT . '/app/classes/CurrencyExchangeManager.php',
    APP_ROOT . '/app/classes/CountryManager.php',
    APP_ROOT . '/app/classes/EmailTemplateManager.php',
    APP_ROOT . '/app/helpers/ValidationHelper.php',
    APP_ROOT . '/app/helpers/EmailHelper.php',
];

foreach ($coreClasses as $classFile) {
    if (file_exists($classFile)) {
        require_once $classFile;
    }
}

// Require legacy functions for backward compatibility
if (file_exists(APP_ROOT . '/function.php')) {
    require_once APP_ROOT . '/function.php';
}

// Initialize authentication
if (class_exists('AuthManager')) {
    $auth = new AuthManager($DB);
} else {
    $auth = null;
}

// Initialize email templates if available
if (class_exists('EmailTemplateManager')) {
    $emailTemplates = new EmailTemplateManager($DB, isset($CONFIG) && is_object($CONFIG) ? $CONFIG->getAll() : []);
} else {
    $emailTemplates = null;
}

// Set timezone
if (isset($CONFIG) && is_object($CONFIG)) {
    date_default_timezone_set($CONFIG->get('timezone', 'UTC'));
} else {
    date_default_timezone_set('UTC');
}

// Check session timeout for authenticated users
if (class_exists('AuthManager') && AuthManager::isAuthenticated()) {
    $sessionTimeout = (isset($CONFIG) && is_object($CONFIG)) ? $CONFIG->getSecurity()['session_timeout'] ?? 3600 : 3600;
    if (!AuthManager::checkSessionTimeout($sessionTimeout)) {
        session_destroy();
        header('Location: /book/signin.php?expired=1');
        exit;
    }
}

// Force HTTPS if configured (skip if running from CLI)
if (php_sapi_name() !== 'cli' && (isset($CONFIG) && is_object($CONFIG)) && $CONFIG->getSecurity()['force_https'] && empty($_SERVER['HTTPS'])) {
    if (!empty($_SERVER['HTTP_HOST']) && !empty($_SERVER['REQUEST_URI'])) {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// Helper function to generate base URLs
if (!function_exists('baseUrl')) {
    function baseUrl($path = '') {
        // Handle CLI mode - return placeholder
        if (php_sapi_name() === 'cli') {
            return 'http://localhost' . $path;
        }
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $protocol . '://' . $host . $path;
    }
}

// Determine current portal for theming (skip for CLI)
$CURRENT_PORTAL = 'book'; // default
if (php_sapi_name() !== 'cli' && !empty($_SERVER['REQUEST_URI'])) {
    if (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {
        $CURRENT_PORTAL = 'admin';
    } elseif (strpos($_SERVER['REQUEST_URI'], '/driver/') !== false) {
        $CURRENT_PORTAL = 'driver';
    }
}
