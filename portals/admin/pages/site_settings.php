<?php
/**
 * Site Settings - Shared Settings File
 * Provides basic site variables to all portals
 * 
 * Usage: include this file to get $site_name, $web_url, etc.
 */

// Prevent redeclaration if already loaded
if (defined('SITE_SETTINGS_LOADED')) {
    return;
}
define('SITE_SETTINGS_LOADED', true);

// Default values
$site_name = 'WG ROOS Courier';
$web_url = 'app.faithinfused.com';
$support_email = 'support@example.com';
$support_phone = '+1-800-000-0000';
$currency = 'USD';

// Try to load from database config if available
if (isset($CONFIG) && is_object($CONFIG)) {
    $site_name = $CONFIG->get('app_name', $site_name);
    $web_url = $CONFIG->get('app_url', $web_url);
    $support_email = $CONFIG->get('support_email', $support_email);
    $support_phone = $CONFIG->get('support_phone', $support_phone);
    $currency = $CONFIG->get('currency', $currency);
}

// Override with environment variables if set
if (!empty(getenv('APP_NAME'))) {
    $site_name = getenv('APP_NAME');
}
if (!empty(getenv('APP_URL'))) {
    $web_url = getenv('APP_URL');
}
