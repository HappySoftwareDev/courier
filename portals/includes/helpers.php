<?php
/**
 * Unified Helper Functions Include
 * Common utilities used across all portals
 * @package app.wgroos.com
 * @subpackage Shared Includes
 */

/**
 * Sanitize user input
 */
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email format
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (South African format)
 */
function isValidPhoneNumber($phone) {
    // Remove spaces and dashes
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    // Check for valid format
    return preg_match('/^(\+27|0)[1-9]\d{8,9}$/', $phone) === 1;
}

/**
 * Format currency (South African Rand)
 */
function formatCurrency($amount, $symbol = 'R') {
    return $symbol . ' ' . number_format($amount, 2, '.', ',');
}

/**
 * Format date in user-friendly format
 */
function formatDate($date, $format = 'd M Y') {
    if (empty($date) || $date === '0000-00-00 00:00:00') {
        return 'N/A';
    }
    return date($format, strtotime($date));
}

/**
 * Format time relative to now (e.g., "2 hours ago")
 */
function timeAgo($date) {
    $time = strtotime($date);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return 'just now';
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
 * Get status badge HTML
 */
function getStatusBadge($status, $type = 'primary') {
    $status_types = [
        'pending' => 'warning',
        'active' => 'success',
        'completed' => 'info',
        'cancelled' => 'danger',
        'approved' => 'success',
        'rejected' => 'danger',
        'on-hold' => 'secondary'
    ];
    
    $badge_type = isset($status_types[strtolower($status)]) 
        ? $status_types[strtolower($status)] 
        : $type;
    
    return '<span class="badge bg-' . htmlspecialchars($badge_type) . '">' . 
           htmlspecialchars(ucfirst($status)) . '</span>';
}

/**
 * Get role badge HTML
 */
function getRoleBadge($role) {
    $role_colors = [
        'admin' => 'danger',
        'driver' => 'primary',
        'customer' => 'success',
        'booking' => 'success'
    ];
    
    $color = isset($role_colors[$role]) ? $role_colors[$role] : 'secondary';
    return '<span class="badge bg-' . htmlspecialchars($color) . '">' . 
           htmlspecialchars(ucfirst($role)) . '</span>';
}

/**
 * Generate pagination HTML
 */
function generatePagination($current_page, $total_pages, $url_pattern) {
    if ($total_pages <= 1) {
        return '';
    }
    
    $html = '<nav aria-label="Page navigation"><ul class="pagination">';
    
    // Previous button
    if ($current_page > 1) {
        $prev_page = $current_page - 1;
        $html .= '<li class="page-item"><a class="page-link" href="' . 
                 str_replace('{page}', $prev_page, $url_pattern) . '">Previous</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
    }
    
    // Page numbers
    for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++) {
        if ($i === $current_page) {
            $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . 
                     str_replace('{page}', $i, $url_pattern) . '">' . $i . '</a></li>';
        }
    }
    
    // Next button
    if ($current_page < $total_pages) {
        $next_page = $current_page + 1;
        $html .= '<li class="page-item"><a class="page-link" href="' . 
                 str_replace('{page}', $next_page, $url_pattern) . '">Next</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    }
    
    $html .= '</ul></nav>';
    return $html;
}

/**
 * Send JSON response
 */
function sendJsonResponse($success, $message = '', $data = null) {
    header('Content-Type: application/json');
    exit(json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]));
}

/**
 * Redirect with message
 */
function redirectWithMessage($url, $message, $type = 'success') {
    $_SESSION['alert'] = [
        'type' => $type,
        'message' => $message
    ];
    header('Location: ' . $url);
    exit;
}

/**
 * Get and clear alert message
 */
function getAlertMessage() {
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
        return $alert;
    }
    return null;
}

/**
 * Generate unique token
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Validate if value is numeric and positive
 */
function isPositiveNumber($value) {
    return is_numeric($value) && $value > 0;
}

/**
 * Get distance between two coordinates in kilometers
 */
function getDistance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; // Radius of the earth in km
    
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earth_radius * $c;
    
    return round($distance, 2);
}
