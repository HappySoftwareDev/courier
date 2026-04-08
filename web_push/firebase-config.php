<?php
/**
 * Firebase Configuration Loader
 * Dynamically loads Firebase configuration from Site Management (website.json)
 * No hardcoded credentials - all config managed via Admin Settings
 */

$websiteJsonPath = __DIR__ . '/../portals/admin/pages/website.json';
$firebaseConfig = null;

// Read from Site Management configuration
if (file_exists($websiteJsonPath)) {
    $websiteData = json_decode(file_get_contents($websiteJsonPath), true);
    if (isset($websiteData['firebase_config']) && !empty($websiteData['firebase_config'])) {
        $firebaseConfig = $websiteData['firebase_config'];
    }
}

// If no config found, throw error or log warning
if (empty($firebaseConfig)) {
    error_log("WARNING: Firebase configuration not found in Site Management (website.json). Please configure Firebase settings in Admin > Settings.");
    // Output an empty config object to prevent JavaScript errors
    $firebaseConfig = 'const firebaseConfig = {}; // Firebase not configured in Site Management';
}

// Output as JavaScript variable for embedding
echo $firebaseConfig;
?>
