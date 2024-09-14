<?php
// Helper function to safely get JSON data
function getJsonData($filePath) {
    $jsonContent = @file_get_contents($filePath);
    if ($jsonContent === false) {
        // Handle the error or log it
        return null;
    }
    $data = json_decode($jsonContent);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle JSON decode error or log it
        return null;
    }
    return $data;
}

// Get JSON data from files
$aData = getJsonData(__DIR__ . '/website.json');
$aLogoData = getJsonData(__DIR__ . '/logo.json');

// Extract values with fallback to empty string
$site_name = !empty($aData->site_name) ? $aData->site_name : "";
$web_url = !empty($aData->url) ? $aData->url : "";
$logo = !empty($aLogoData->logo->name) ? $aLogoData->logo->name : "";
$bus_address = !empty($aData->bus_address) ? $aData->bus_address : "";
$bus_phone = !empty($aData->bus_phone) ? $aData->bus_phone : "";
$bus_email = !empty($aData->bus_email) ? $aData->bus_email : "";
$firebase_config = !empty($aData->firebase_config) ? $aData->firebase_config : "";
$firebase_push_key = !empty($aData->firebase_push_key) ? $aData->firebase_push_key : "";
$recapcha_key = !empty($aData->recapcha_key) ? $aData->recapcha_key : "";

// Optionally, handle the case where $aData or $aLogoData is null
if ($aData === null) {
    echo "Error reading or decoding website.json.";
}

if ($aLogoData === null) {
    echo "Error reading or decoding logo.json.";
}
?>
