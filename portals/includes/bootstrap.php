<?php
/**
 * Portal Bootstrap File
 * Initialize all shared includes and set up common environment for all portals
 * @package app.wgroos.com
 * @subpackage Portals
 * 
 * Works from /public_html/app/ subdirectory (WordPress compatible)
 */

// Define APP_ROOT based on current file location
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(dirname(dirname(__FILE__))));
}

// Set base path for includes
define('PORTAL_BASE', APP_ROOT);
define('PORTALS_BASE', APP_ROOT . '/portals');
define('CONFIG_BASE', APP_ROOT . '/config');

// Load configuration
require_once CONFIG_BASE . '/bootstrap.php';

// Load shared authentication functions
require_once PORTALS_BASE . '/includes/auth.php';

// Load shared helper functions
require_once PORTALS_BASE . '/includes/helpers.php';

// Set default timezone
date_default_timezone_set('Africa/Johannesburg');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
    // Set session timeout (30 minutes)
    $timeout_duration = 1800;
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
        clearUserSession();
        header('Location: ' . PORTAL_BASE . '/index.php?session=expired');
        exit;
    }
    $_SESSION['last_activity'] = time();
}

// Set security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Handle CORS for API endpoints (if needed)
if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
    header('Access-Control-Allow-Origin: ' . (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*'));
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
}

// Global error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // Log error
    error_log("[$errno] $errstr in $errfile on line $errline");
    
    // Display user-friendly error in development
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<strong>Error:</strong> $errstr";
        echo "</div>";
    } else {
        // In production, show generic error message
        echo "<div class='alert alert-danger' role='alert'>";
        echo "An error occurred. Please contact support.";
        echo "</div>";
    }
});

// Global exception handler
set_exception_handler(function($exception) {
    error_log('Exception: ' . $exception->getMessage());
    
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<strong>Exception:</strong> " . $exception->getMessage();
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "An error occurred. Please contact support.";
        echo "</div>";
    }
});
