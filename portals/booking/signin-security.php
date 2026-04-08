<?php
/**
 * Authentication & Security Layer for Book Portal
 * 
 * Handles session management, logout, and access control.
 * Uses centralized AuthManager from config/bootstrap.php
 */

// Load centralized bootstrap (includes session_start)
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(dirname(__DIR__)));
    require_once APP_ROOT . '/config/bootstrap.php';
}

// Handle logout action
if (!empty($_GET['doLogout']) && $_GET['doLogout'] === 'true') {
    AuthManager::logout();
    
    $returnUrl = isset($_GET['return']) ? urldecode($_GET['return']) : 'signin.php';
    header('Location: ' . $returnUrl);
    exit;
}

// Check if user is authenticated and authorized
function checkBookingPortalAccess($userRole = 'customer') {
    // Allow guests to access booking pages
    if (strpos($_SERVER['PHP_SELF'], 'index.php') !== false || 
        strpos($_SERVER['PHP_SELF'], 'submit.php') !== false ||
        strpos($_SERVER['PHP_SELF'], 'signup.php') !== false ||
        strpos($_SERVER['PHP_SELF'], 'signin.php') !== false) {
        return true; // Public pages
    }
    
    // Require authentication for protected pages
    if (!AuthManager::isAuthenticated()) {
        $currentUrl = urlencode($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        header('Location: signin.php?accesscheck=' . $currentUrl);
        exit;
    }
    
    // Check user role if specified
    if ($userRole !== '*') {
        $userRoles = explode(',', $userRole);
        $userRole = $_SESSION['user_role'] ?? null;
        
        if (!in_array($userRole, $userRoles)) {
            header('Location: signin.php?error=unauthorized');
            exit;
        }
    }
    
    return true;
}

// Initialize session variables from auth manager
if (AuthManager::isAuthenticated()) {
    $_SESSION['user_email'] = AuthManager::getUserEmail();
    $_SESSION['user_role'] = AuthManager::getUserRole() ?? 'customer';
    $_SESSION['user_id'] = AuthManager::getUserId();
    $_SESSION['user_name'] = $_SESSION['user_name'] ?? 'User';
}

// Auto logout if session expires
$sessionTimeout = defined('SESSION_TIMEOUT') ? SESSION_TIMEOUT : 3600;
$sessionLastActivity = $_SESSION['last_activity'] ?? time();
$_SESSION['last_activity'] = time();

if ((time() - $sessionLastActivity) > $sessionTimeout) {
    AuthManager::logout();
    header('Location: signin.php?expired=1');
    exit;
}
?>

