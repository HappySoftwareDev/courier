<?php
/**
 * Booking Fields API
 * Returns field definitions for dynamic form generation
 * Used by JavaScript to render service-specific fields
 */

require_once '../../config/bootstrap.php';

header('Content-Type: application/json');

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $serviceType = $_GET['service_type'] ?? null;

    if (!$serviceType) {
        http_response_code(400);
        echo json_encode(['error' => 'Service type is required']);
        exit;
    }

    // Load field configuration
    $bookingFields = require_once dirname(__DIR__) . '/config/booking-fields-config.php';

    if (!isset($bookingFields[$serviceType])) {
        http_response_code(404);
        echo json_encode(['error' => 'Service type not found']);
        exit;
    }

    $config = $bookingFields[$serviceType];

    // Return fields configuration
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'service_type' => $serviceType,
        'service_name' => $config['service_name'],
        'icon' => $config['icon'],
        'description' => $config['description'],
        'common_fields' => $config['common_fields'],
        'service_fields' => $config['service_fields'],
        'pricing_factors' => $config['pricing_factors'] ?? []
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}

?>


