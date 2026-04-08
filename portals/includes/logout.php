<?php
/**
 * Logout Handler
 * Clears user session and redirects to home page
 * @package app.wgroos.com
 * @subpackage Portals Includes
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current user info for logging
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

// Load database connection for logging
require_once '../../config/bootstrap.php';

// Log logout activity
if ($user_id) {
    try {
        $stmt = $DB->prepare("
            INSERT INTO activity_logs (user_id, user_role, action, details, ip_address, user_agent, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $user_id,
            isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'unknown',
            'logout',
            'User logged out',
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    } catch (Exception $e) {
        error_log('Logout logging failed: ' . $e->getMessage());
    }
}

// Clear all session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to home page with logout message
header('Location: ../../index.php?logout=success');
exit;
