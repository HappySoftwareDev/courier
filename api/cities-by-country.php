<?php
/**
 * AJAX Endpoint: Get Cities by Country
 * Returns cities for selected country in JSON format
 */

header('Content-Type: application/json');

// Load configuration
require_once dirname(dirname(__DIR__)) . '/config/bootstrap.php';

$countryCode = isset($_GET['country']) ? trim($_GET['country']) : '';

if (empty($countryCode)) {
    http_response_code(400);
    echo json_encode(['error' => 'Country code required']);
    exit;
}

// Load CityManager
require_once dirname(__DIR__) . '/classes/CityManager.php';
$cityManager = new CityManager();

// Get cities for country
$cities = $cityManager->getCitiesForCountry($countryCode);

if (empty($cities)) {
    http_response_code(404);
    echo json_encode(['error' => 'No cities found for country']);
    exit;
}

// Return cities as JSON
echo json_encode([
    'success' => true,
    'country' => $countryCode,
    'cities' => $cities,
    'count' => count($cities)
]);
