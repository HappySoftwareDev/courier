<?php
/**
 * Global Helper Functions
 * 
 * Commonly used functions throughout the application.
 */

/**
 * Sanitize input string
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Get current base URL
 */
function baseUrl($path = '') {
    $url = BASE_URL;
    if ($path) {
        $url .= '/' . ltrim($path, '/');
    }
    return $url;
}

/**
 * Redirect user
 */
function redirect($url, $statusCode = 302) {
    header('Location: ' . $url, true, $statusCode);
    exit;
}

/**
 * Generate CSRF input field
 */
function csrfField() {
    $token = AuthMiddleware::generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Check if user is authenticated
 */
function isAuth() {
    return AuthMiddleware::isAuthenticated();
}

/**
 * Get current user
 */
function currentUser() {
    return AuthMiddleware::getCurrentUser();
}

/**
 * Get current user ID
 */
function userId() {
    $user = currentUser();
    return $user ? $user['id'] : null;
}

/**
 * Format currency value
 */
function formatCurrency($amount, $currency = 'USD') {
    $symbols = [
        'USD' => '$',
        'ZWL' => 'Z$',
        'ZAR' => 'R'
    ];
    
    $symbol = $symbols[$currency] ?? '$';
    return $symbol . number_format($amount, 2);
}

/**
 * Format date
 */
function formatDate($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

/**
 * Format phone number
 */
function formatPhone($phone) {
    $cleaned = preg_replace('/[^\d]/', '', $phone);
    if (strlen($cleaned) === 10) {
        return '(' . substr($cleaned, 0, 3) . ') ' . substr($cleaned, 3, 3) . '-' . substr($cleaned, 6);
    }
    return $phone;
}

/**
 * Get service type label
 */
function getServiceLabel($serviceType) {
    return SERVICE_TYPES[$serviceType] ?? $serviceType;
}

/**
 * Get user role label
 */
function getRoleLabel($role) {
    return USER_ROLES[$role] ?? $role;
}

/**
 * Check if current user has role
 */
function hasRole($role) {
    $user = currentUser();
    return $user && $user['role'] === $role;
}

/**
 * Check if current user has any of the roles
 */
function hasAnyRole($roles = []) {
    $user = currentUser();
    return $user && in_array($user['role'], $roles);
}

/**
 * Get file upload path
 */
function uploadPath($filename) {
    return STORAGE_PATH . '/uploads/' . $filename;
}

/**
 * Get invoice path
 */
function invoicePath($filename) {
    return STORAGE_PATH . '/invoices/' . $filename;
}

/**
 * Generate random string
 */
function generateRandomString($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Get time difference in human readable format
 */
function timeAgo($date) {
    $timestamp = strtotime($date);
    $diff = time() - $timestamp;

    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return formatDate($date);
    }
}

/**
 * Get HTTP status message
 */
function httpStatusMessage($code) {
    $messages = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        409 => 'Conflict',
        422 => 'Unprocessable Entity',
        429 => 'Too Many Requests',
        500 => 'Internal Server Error',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable'
    ];

    return $messages[$code] ?? 'Unknown Status';
}

/**
 * Send JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    header('Content-Type: application/json', true, $statusCode);
    echo json_encode($data);
    exit;
}

/**
 * Log message
 */
function logMessage($message, $level = 'info') {
    $logFile = LOGS_PATH . '/' . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] [$level] $message\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

/**
 * Get page title
 */
function getPageTitle($page = '') {
    $titles = [
        'home' => 'Home',
        'dashboard' => 'Dashboard',
        'bookings' => 'My Bookings',
        'profile' => 'My Profile',
        'signin' => 'Sign In',
        'signup' => 'Sign Up',
        'orders' => 'Orders',
        'settings' => 'Settings',
        'admin' => 'Admin Panel'
    ];

    return ($titles[$page] ?? $page) . ' | ' . APP_NAME;
}

/**
 * Truncate text
 */
function truncate($text, $limit = 100, $suffix = '...') {
    if (strlen($text) <= $limit) {
        return $text;
    }
    return substr($text, 0, $limit) . $suffix;
}

/**
 * Convert seconds to readable format
 */
function secondsToTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $secs = $seconds % 60;

    if ($hours > 0) {
        return "$hours h $minutes m";
    } elseif ($minutes > 0) {
        return "$minutes m $secs s";
    } else {
        return "$secs seconds";
    }
}

/**
 * Get weather emoji based on status
 */
function getStatusBadge($status) {
    $badges = [
        'pending' => '<span class="badge badge-warning">Pending</span>',
        'confirmed' => '<span class="badge badge-info">Confirmed</span>',
        'assigned' => '<span class="badge badge-primary">Assigned</span>',
        'in_transit' => '<span class="badge badge-primary">In Transit</span>',
        'completed' => '<span class="badge badge-success">Completed</span>',
        'cancelled' => '<span class="badge badge-danger">Cancelled</span>',
        'active' => '<span class="badge badge-success">Active</span>',
        'inactive' => '<span class="badge badge-secondary">Inactive</span>'
    ];

    return $badges[$status] ?? '<span class="badge">' . ucfirst($status) . '</span>';
}


