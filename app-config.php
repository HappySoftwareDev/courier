<?php
/**
 * Application Configuration Helper
 * 
 * This file defines APP_ROOT for the entire application
 * Can be included from any file to get correct base paths
 * 
 * Works when application is installed in /public_html/app/
 * (WordPress compatible subdirectory installation)
 */

if (!defined('APP_ROOT')) {
    // Determine APP_ROOT based on current file
    // This file should be in the app root directory
    define('APP_ROOT', dirname(__FILE__));
}

if (!defined('APP_CONFIGURED')) {
    // Load the main bootstrap
    require_once APP_ROOT . '/config/bootstrap.php';
    define('APP_CONFIGURED', true);
}
?>
