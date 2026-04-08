<?php
/**
 * PayPal Webhook Handler
 * Receives and processes PayPal Instant Payment Notifications
 */

header('Content-Type: application/json');

try {
    // Load configuration
    require_once dirname(dirname(__DIR__)) . '/config/bootstrap.php';

    // Load PaymentGateway classes
    require_once dirname(__DIR__) . '/app/classes/PaymentGatewayInterface.php';
    require_once dirname(__DIR__) . '/app/classes/PaymentGateways.php';

    // Get POST data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        // PayPal also sends form-encoded data
        $data = $_POST;
    }

    if (empty($data)) {
        http_response_code(400);
        echo json_encode(['error' => 'No data received']);
        exit;
    }

    // Initialize gateway
    $gateway = new PayPalGateway($DB, $CONFIG);

    // Process webhook
    $result = $gateway->handleWebhook($data);

    if ($result['success']) {
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Webhook processed']);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => $result['error'] ?? 'Processing failed']);
    }

} catch (Exception $e) {
    error_log("PayPal Webhook Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error']);
}
