<?php
/**
 * PayNow Webhook Handler
 * Receives and processes PayNow payment callbacks
 */

header('Content-Type: application/json');

try {
    // Load configuration
    require_once dirname(dirname(__DIR__)) . '/config/bootstrap.php';

    // Load PaymentGateway classes
    require_once dirname(__DIR__) . '/app/classes/PaymentGatewayInterface.php';
    require_once dirname(__DIR__) . '/app/classes/PaymentGateways.php';

    // Get POST data
    $data = file_get_contents('php://input');
    $payload = json_decode($data, true);

    if (!$payload) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    // Initialize gateway
    $gateway = new PayNowGateway($DB, $CONFIG);

    // Process webhook
    $result = $gateway->handleWebhook($payload);

    if ($result['success']) {
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Webhook processed']);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => $result['error'] ?? 'Processing failed']);
    }

} catch (Exception $e) {
    error_log("PayNow Webhook Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error']);
}
