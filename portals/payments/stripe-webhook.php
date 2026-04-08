<?php
/**
 * Stripe Webhook Handler
 * Receives and processes Stripe payment events
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
    $event = json_decode($input, true);

    if (!$event) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    // Verify webhook signature
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
    $webhook_secret = $CONFIG->get('stripe_webhook_secret', '');

    if (empty($webhook_secret)) {
        error_log("Stripe webhook secret not configured");
        http_response_code(403);
        echo json_encode(['error' => 'Webhook secret not configured']);
        exit;
    }

    // Initialize gateway
    $gateway = new StripeGateway($DB, $CONFIG);

    // Process webhook
    $result = $gateway->handleWebhook($event);

    if ($result['success']) {
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Webhook processed']);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => $result['error'] ?? 'Processing failed']);
    }

} catch (Exception $e) {
    error_log("Stripe Webhook Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error']);
}
