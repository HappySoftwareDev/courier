<?php
/**
 * 543Konse Callback Handler
 * Handles customer return from 543Konse payment page (redirect callback)
 */

try {
    // Load configuration
    require_once dirname(dirname(__DIR__)) . '/config/bootstrap.php';

    // Load PaymentGateway classes
    require_once dirname(__DIR__) . '/app/classes/PaymentGatewayInterface.php';
    require_once dirname(__DIR__) . '/app/classes/KonseGateway.php';

    // Get query parameters
    $transactionId = isset($_GET['transaction_id']) ? trim($_GET['transaction_id']) : '';
    $bookingId = isset($_GET['booking_id']) ? trim($_GET['booking_id']) : '';
    $status = isset($_GET['status']) ? trim($_GET['status']) : '';
    $signature = isset($_GET['signature']) ? trim($_GET['signature']) : '';

    if (empty($transactionId) || empty($bookingId)) {
        die('Invalid callback parameters');
    }

    // Initialize gateway
    $gateway = new KonseGateway($DB, $CONFIG);

    // Verify callback signature
    $callbackData = [
        'transaction_id' => $transactionId,
        'booking_id' => $bookingId,
        'status' => $status
    ];

    if (!$gateway->verifyWebhookSignature($callbackData, $signature)) {
        error_log("Invalid 543Konse callback signature for booking: $bookingId");
        die('Invalid signature');
    }

    // Check payment status
    $paymentStatus = $gateway->getPaymentStatus($transactionId);

    if ($paymentStatus['status'] === 'completed') {
        // Payment successful - redirect to success page
        header('Location: /portals/booking/payment-success.php?booking_id=' . urlencode($bookingId) . '&transaction_id=' . urlencode($transactionId));
        exit;
    } else if ($paymentStatus['status'] === 'pending') {
        // Payment still pending
        header('Location: /portals/booking/payment-pending.php?booking_id=' . urlencode($bookingId) . '&transaction_id=' . urlencode($transactionId));
        exit;
    } else {
        // Payment failed
        header('Location: /portals/booking/payment-failed.php?booking_id=' . urlencode($bookingId) . '&error=' . urlencode($paymentStatus['error'] ?? 'Unknown error'));
        exit;
    }

} catch (Exception $e) {
    error_log("543Konse Callback Error: " . $e->getMessage());
    die('Payment verification failed');
}
