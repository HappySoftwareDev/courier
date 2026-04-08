<?php
/**
 * AJAX Endpoint: Get Payment Methods by Country
 * Returns available payment methods for selected country
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

// Load PaymentProcessor
require_once dirname(__DIR__) . '/app/classes/PaymentGatewayInterface.php';
require_once dirname(__DIR__) . '/app/classes/PaymentGateways.php';
require_once dirname(__DIR__) . '/app/classes/KonseGateway.php';
require_once dirname(__DIR__) . '/app/classes/PaymentProcessor.php';

try {
    $processor = new PaymentProcessor($DB, $CONFIG);
    $methods = $processor->getAvailableGateways($countryCode);

    echo json_encode([
        'success' => true,
        'country' => $countryCode,
        'methods' => $methods,
        'count' => count($methods)
    ]);
} catch (Exception $e) {
    error_log("Payment Methods Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load payment methods']);
}
