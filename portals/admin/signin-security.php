<?php
/**
 * Admin Portal Security & Authentication
 * Handles login/logout and session management for admin users
 */

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle logout
if (isset($_GET['doLogout']) && $_GET['doLogout'] === 'true') {
    $_SESSION = [];
    session_destroy();
    header('Location: pages/login.php', true, 302);
    exit;
}

// Check if user is already logged in - if so, allow admin access
$isLoggedIn = isset($_SESSION['CC_Username']) || isset($_SESSION['admin_id']);
$isAdmin = isset($_SESSION['admin_id']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');

// For now, redirect non-admins attempting direct admin access
if (!$isAdmin && $isLoggedIn) {
    // User is logged in but not an admin
    header('Location: ../../portals/booking/index.php', true, 302);
    exit;
}

// If not logged in at all, redirect to login
if (!$isLoggedIn) {
    header('Location: pages/login.php', true, 302);
    exit;
}
?>