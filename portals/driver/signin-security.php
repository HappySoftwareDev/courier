<?php
/**
 * Driver Portal Authentication & Authorization
 * 
 * Handles driver session management, logout, and role-based access control.
 * Uses centralized AuthManager from config/bootstrap.php
 */

// Load centralized bootstrap (includes session_start)
if (!defined('APP_ROOT')) {
    require_once dirname(dirname(__FILE__)) . '/config/bootstrap.php';
}

// Handle driver logout
if (!empty($_GET['doLogout']) && $_GET['doLogout'] === 'true') {
    AuthManager::logout();
    
    $returnUrl = 'index.php';
    header('Location: ' . $returnUrl);
    exit;
}

/**
 * Check Driver Portal Access
 * Requires authentication and driver role
 */
function checkDriverAccess($requiredRole = 'driver') {
    // Public pages that don't require authentication
    $publicPages = ['index.php', 'driver_registration.php'];
    $currentPage = basename($_SERVER['PHP_SELF']);
    
    if (in_array($currentPage, $publicPages)) {
        return true; // Public pages
    }
    
    // Require driver authentication
    if (!AuthManager::isAuthenticated()) {
        $currentUrl = urlencode($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        header('Location: index.php?login_required=1&return=' . $currentUrl);
        exit;
    }
    
    // Check driver role
    $userRole = AuthManager::getUserRole() ?? $_SESSION['driver_role'] ?? 'driver';
    $allowedRoles = explode(',', $requiredRole);
    
    if (!in_array($userRole, $allowedRoles)) {
        // User is authenticated but doesn't have required role
        header('Location: index.php?error=unauthorized');
        exit;
    }
    
    return true;
}

// Legacy compatibility: sync session variables for old driver code
if (AuthManager::isAuthenticated() && !isset($_SESSION['driverID'])) {
    $_SESSION['driverID'] = AuthManager::getUserId() ?? $_SESSION['user_id'] ?? null;
    $_SESSION['driver_email'] = AuthManager::getUserEmail() ?? $_SESSION['user_email'] ?? null;
    $_SESSION['driver_role'] = AuthManager::getUserRole() ?? 'driver';
}

// Auto logout if session expires
$sessionTimeout = defined('SESSION_TIMEOUT') ? SESSION_TIMEOUT : 3600;
$sessionLastActivity = $_SESSION['last_activity'] ?? time();
$_SESSION['last_activity'] = time();

if ((time() - $sessionLastActivity) > $sessionTimeout) {
    AuthManager::logout();
    header('Location: index.php?expired=1');
    exit;
}

// Apply access control by default (unless in a public page)
checkDriverAccess();
?>


