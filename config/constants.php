<?php
/**
 * Application Constants
 */

// Application
define('APP_NAME', 'WGroos Courier');
define('APP_VERSION', '2.0.0');
define('APP_ENV', getenv('APP_ENV') ?: 'production');

// Paths
define('APP_ROOT', dirname(dirname(__FILE__)));
define('CONFIG_PATH', APP_ROOT . '/config');
define('APP_PATH', APP_ROOT . '/app');
define('TEMPLATE_PATH', APP_ROOT . '/templates');
define('STORAGE_PATH', APP_ROOT . '/storage');
define('LOGS_PATH', APP_ROOT . '/logs');

// URLs
define('BASE_URL', getenv('BASE_URL') ?: 'https://app.wgroos.com');
define('ADMIN_URL', BASE_URL . '/admin');
define('BOOK_URL', BASE_URL . '/book');
define('DRIVER_URL', BASE_URL . '/driver');

// Session
define('SESSION_TIMEOUT', 3600); // 1 hour
define('SESSION_NAME', 'wgroos_session');

// File uploads
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
define('ALLOWED_UPLOAD_TYPES', ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);

// Service types
define('SERVICE_TYPES', [
    'parcel' => 'Parcel Delivery',
    'freight' => 'Freight Shipping',
    'furniture' => 'Furniture Moving',
    'taxi' => 'Taxi Service',
    'towtruck' => 'Tow Truck Service'
]);

// Currencies
define('CURRENCIES', [
    'USD' => 'US Dollar',
    'ZWL' => 'Zimbabwe Dollar',
    'ZAR' => 'South African Rand'
]);

// User roles
define('USER_ROLES', [
    'admin' => 'Administrator',
    'driver' => 'Driver',
    'customer' => 'Customer',
    'affiliate' => 'Affiliate'
]);

// Commission rates (percentage)
define('COMMISSION_RATES', [
    'parcel' => 15,
    'freight' => 20,
    'furniture' => 25,
    'taxi' => 18,
    'towtruck' => 22
]);

// Email settings
define('MAIL_FROM', getenv('MAIL_FROM') ?: 'noreply@app.wgroos.com');
define('MAIL_FROM_NAME', APP_NAME);

// Security
define('PASSWORD_MIN_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes


