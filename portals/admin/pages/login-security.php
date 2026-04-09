<?php
/**
 * Admin Portal Authentication & Security Layer
 * Handles session management and admin access control
 */

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    // Try to set a session save path if the default doesn't exist
    $sessionPath = sys_get_temp_dir() . '/php_sessions';
    if (!is_dir($sessionPath)) {
        @mkdir($sessionPath, 0755, true);
    }
    @ini_set('session.save_path', $sessionPath);
    
    try {
        session_start();
    } catch (Exception $e) {
        error_log('Session start error: ' . $e->getMessage());
    }
}

// Load bootstrap if not already loaded
if (!defined('APP_ROOT')) {
    require_once dirname(dirname(dirname(__DIR__))) . '/config/bootstrap.php';
}

// Handle logout
if (!empty($_GET['doLogout']) && $_GET['doLogout'] === 'true') {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php', true, 302);
    exit;
}

// Check admin authentication
$isAdminLoggedIn = isset($_SESSION['admin_id']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
$isUserLoggedIn = isset($_SESSION['CC_Username']);

// Public pages that don't require authentication
$publicPages = ['login.php', 'forgot_pass.php', 'login-security.php'];
$currentPage = basename($_SERVER['PHP_SELF']);

// If not logged in and not a public page, redirect to login
if (!$isAdminLoggedIn && !in_array($currentPage, $publicPages)) {
    header('Location: login.php?login_required=1', true, 302);
    exit;
}

// If logged in but not as admin, redirect away
if ($isUserLoggedIn && !$isAdminLoggedIn && !in_array($currentPage, $publicPages)) {
    header('Location: ../../booking/index.php', true, 302);
    exit;
}
?>
