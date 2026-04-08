<?php
/**
 * Unified Authentication Include
 * Handles login verification and session management for all portals
 * @package app.wgroos.com
 * @subpackage Shared Includes
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION['user_role']);
}

// Check if user has specific role
function hasRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

// Check if user has specific permission
function hasPermission($permission) {
    if (!isset($_SESSION['permissions'])) {
        return false;
    }
    return in_array($permission, $_SESSION['permissions']);
}

// Get current user ID
function getCurrentUserId() {
    return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
}

// Get current user email
function getCurrentUserEmail() {
    return isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
}

// Get current user role
function getCurrentUserRole() {
    return isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'guest';
}

// Get current user name
function getCurrentUserName() {
    return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
}

// Get current portal
function getCurrentPortal() {
    return isset($_SESSION['portal']) ? $_SESSION['portal'] : 'booking';
}

// Redirect to login if not authenticated
function requireLogin($portal = null) {
    if (!isLoggedIn()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: ../../index.php?login=required');
        exit;
    }
    
    // If portal is specified, check if user has access
    if ($portal && !hasRole($portal) && !hasRole('admin')) {
        http_response_code(403);
        die('Access Denied: You do not have permission to access this portal.');
    }
}

// Redirect to admin only if not admin
function requireAdmin() {
    requireLogin();
    if (!hasRole('admin')) {
        http_response_code(403);
        die('Access Denied: Admin access required.');
    }
}

// Redirect to driver only if not driver
function requireDriver() {
    requireLogin();
    if (!hasRole('driver')) {
        http_response_code(403);
        die('Access Denied: Driver access required.');
    }
}

// Redirect to customer only if not customer/booking user
function requireCustomer() {
    requireLogin();
    if (!hasRole('customer') && !hasRole('booking')) {
        http_response_code(403);
        die('Access Denied: Customer access required.');
    }
}

// Set user session after successful login
function setUserSession($user_id, $user_email, $user_role, $user_name, $permissions = []) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $user_email;
    $_SESSION['user_role'] = $user_role;
    $_SESSION['user_name'] = $user_name;
    $_SESSION['permissions'] = $permissions;
    $_SESSION['portal'] = $user_role;
    $_SESSION['login_time'] = time();
}

// Clear user session on logout
function clearUserSession() {
    $_SESSION = [];
    session_destroy();
}

// Log user activity for security auditing
function logActivity($action, $details = '') {
    global $DB;
    
    if (!isLoggedIn()) {
        return false;
    }
    
    try {
        $stmt = $DB->prepare("
            INSERT INTO activity_logs (user_id, user_role, action, details, ip_address, user_agent, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        return $stmt->execute([
            getCurrentUserId(),
            getCurrentUserRole(),
            $action,
            $details,
            $ip_address,
            $user_agent
        ]);
    } catch (Exception $e) {
        // Log error but don't interrupt flow
        error_log('Activity logging failed: ' . $e->getMessage());
        return false;
    }
}

// Check CSRF token
function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// Generate CSRF token
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Get CSRF token for forms
function getCSSRFToken() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generateCSRFToken()) . '">';
}
