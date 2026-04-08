<?php
/**
 * Application Bootstrap
 * Initializes all core components and configurations
 * Unified system for admin, book, and driver portals
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Define app constants
// APP_ROOT should be the /app/ directory in /public_html/app/
// This works whether you access from public_html/ or public_html/app/
define('APP_ROOT', defined('APP_ROOT') ? APP_ROOT : dirname(dirname(__FILE__)));
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
require_once APP_ROOT . '/config/database.php';

// Create PDO database instance for new system
$DB = Database::getInstance();

// CRITICAL: Create backward-compatible MySQLi connection for legacy code
// This allows old code using $Connect to work while we transition to new system
require_once APP_ROOT . '/Connections/db-connection.php';

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

// Force HTTPS if configured
if ((isset($CONFIG) && is_object($CONFIG)) && $CONFIG->getSecurity()['force_https'] && empty($_SERVER['HTTPS'])) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

// Helper function to generate base URLs
if (!function_exists('baseUrl')) {
    function baseUrl($path = '') {
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . '://' . $host . $path;
    }
}

// Determine current portal for theming
$CURRENT_PORTAL = 'book'; // default
if (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {
    $CURRENT_PORTAL = 'admin';
} elseif (strpos($_SERVER['REQUEST_URI'], '/driver/') !== false) {
    $CURRENT_PORTAL = 'driver';
}

?>


