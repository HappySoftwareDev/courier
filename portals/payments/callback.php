<?php
/**
 * Unified Payment Gateway Callback Handler
 * Handles callbacks from all payment gateways:
 * - Paynow (local mobile money/transfers)
 * - Stripe (credit/debit cards)
 * - PayPal (international payments)
 */

session_start();
require_once '../../config/bootstrap.php';

// Load legacy dependencies for compatibility
if (file_exists('../../admin/pages/login-security.php')) {
    require('../../admin/pages/login-security.php');
}
if (file_exists('../../admin/pages/site_settings.php')) {
    include('../../admin/pages/site_settings.php');
}
if (file_exists('../../get-sql-value.php')) {
    require('../../get-sql-value.php');
}

require_once '../../paynow/autoloader.php';

/**
 * Payment Status Logger
 * Logs all payment attempts for debugging and auditing
 */
function logPaymentStatus($method, $status, $details = []) {
    $logEntry = sprintf(
        "[%s] [%s] Payment Status: %s | Reference: %s | Details: %s\n",
        date('Y-m-d H:i:s'),
        strtoupper($method),
        is_array($status) ? ($status['status'] ?? 'unknown') : ($status->status() ?? 'unknown'),
        is_array($status) ? ($status['reference'] ?? 'unknown') : ($status->paynowReference() ?? 'unknown'),
        json_encode($details)
    );
    
    $logFile = dirname(__FILE__) . '/logs/payment_callbacks.log';
    if (!is_dir(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

/**
 * Update booking payment status in database
 */
function updateBookingPaymentStatus($bookingId, $status, $transactionData = []) {
    global $DB;
    try {
        $stmt = $DB->prepare(
            "UPDATE bookings SET payment_status = 'PAID', 
             transaction_details = ?, updated_at = NOW() 
             WHERE order_number = ? OR order_id = ?"
        );
        $stmt->execute([
            json_encode($transactionData),
            $bookingId,
            $bookingId
        ]);
        return true;
    } catch (Exception $e) {
        error_log('Payment database update failed: ' . $e->getMessage());
        logPaymentStatus('database', ['status' => 'error'], ['error' => $e->getMessage()]);
        return false;
    }
}

// Initialize data structure for all payment methods
$data = ['status' => false, 'msg' => '', 'data' => [], 'method' => 'unknown'];

// Detect which payment method triggered the callback
$paymentMethod = $_GET['method'] ?? $_POST['method'] ?? 'paynow';

if ($paymentMethod === 'stripe') {
    /**
     * STRIPE PAYMENT CALLBACK
     * Handles Stripe webhook callbacks
     */
    $stripeSecret = $aData->stripeSk ?? '';
    $data['method'] = 'stripe';
    
    // This would be called from stripe/payment.php AJAX response
    // The actual Stripe response handling happens in stripe/payment.php
    if (!empty($_POST['stripeData'])) {
        $stripeData = json_decode($_POST['stripeData'], true);
        if ($stripeData && $stripeData['status'] === true) {
            $data['status'] = true;
            $data['msg'] = 'Stripe payment successful';
            $data['data'] = $stripeData['data'];
            logPaymentStatus('stripe', $data, $stripeData);
        }
    }
} elseif ($paymentMethod === 'paypal') {
    /**
     * PAYPAL PAYMENT CALLBACK
     * Handles PayPal IPN (Instant Payment Notification)
     */
    $data['method'] = 'paypal';
    
    // Verify IPN message is genuine
    $verify = 'cmd=_notify-validate';
    foreach ($_POST as $key => $value) {
        $verify .= '&' . urlencode($key) . '=' . urlencode($value);
    }
    
    $ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $verify);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response == 'VERIFIED') {
        // PayPal transaction verified
        if ($_POST['payment_status'] == 'Completed' || $_POST['payment_status'] == 'Processed') {
            $data['status'] = true;
            $data['msg'] = 'PayPal payment completed';
            $data['data'] = $_POST;
            logPaymentStatus('paypal', $data, $_POST);
            
            // Update booking with PayPal transaction info
            if (!empty($_POST['invoice'])) {
                updateBookingPaymentStatus($_POST['invoice'], 'PAID', $_POST);
            }
        }
    } else {
        $data['msg'] = 'PayPal verification failed';
        logPaymentStatus('paypal', $data, ['error' => 'Verification failed']);
    }
} else {
    /**
     * PAYNOW PAYMENT CALLBACK (Default)
     * Handles Paynow poll URL status checks
     */
    $data['method'] = 'paynow';
    
    // Initialize Paynow gateway
    $paynow = new Paynow\Payments\Paynow(
        '3983',
        '35ae8280-ff18-4c62-af87-c83ce1d9c44c',
        'https://' . ($web_url ?? $_SERVER['HTTP_HOST']) . '/portals/payments/callback.php?method=paynow',
        'https://' . ($web_url ?? $_SERVER['HTTP_HOST']) . '/portals/payments/callback.php?method=paynow'
    );
    
    // Process payment status if poll URL exists
    if (!empty($_SESSION['pollurl'])) {
        $pollUrl = $_SESSION['pollurl'];
        $status = $paynow->pollTransaction($pollUrl);
        
        logPaymentStatus('paynow', $status);
        
        if ($status->paid()) {
            unset($_SESSION['pollurl']);
            
            $data['status'] = true;
            $data['msg'] = 'PayNow payment successful';
            $data['data'] = [
                'status' => $status->status(),
                'reference' => $status->reference(),
                'paynowReference' => $status->paynowReference(),
            ];
            
            // Update booking in database
            if (isset($DB) && !empty($_SESSION['booking_id'])) {
                updateBookingPaymentStatus($_SESSION['booking_id'], 'PAID', $data['data']);
            }
        }
    } elseif (!empty($_GET['ref'])) {
        // Handle Paynow return from payment link
        $data['status'] = true;
        $data['msg'] = 'PayNow payment initiated - awaiting confirmation';
        $data['data'] = ['reference' => $_GET['ref']];
    }
}

// Store payment data in session for client-side handling
$_SESSION['payment'] = json_encode($data);

// Unified redirect mapping - routes to appropriate booking service endpoint
$serviceType = $_GET['service'] ?? $_POST['service'] ?? $_GET['ref'] ?? 'parcel';
$orderNumber = $_GET['orderD'] ?? $_POST['orderD'] ?? $_SESSION['orderD'] ?? $_GET['order_id'] ?? '';

$redirectMap = [
    'parcel'    => '/portals/booking/index.php?service=parcel',
    'freight'   => '/portals/booking/index.php?service=freight',
    'furniture' => '/portals/booking/index.php?service=furniture',
    'taxi'      => '/portals/booking/index.php?service=taxi',
    'towtruck'  => '/portals/booking/index.php?service=towtruck',
    'invoice'   => '/portals/invoicing/index.php?orderD=' . urlencode($orderNumber),
];

// Default: return to booking portal
$redirectUrl = $redirectMap[$serviceType] ?? '/portals/booking/index.php';

// Add payment status to redirect
$redirectUrl .= (strpos($redirectUrl, '?') !== false ? '&' : '?') . 'payment=' . ($data['status'] ? 'success' : 'pending');

// Store order number for follow-up queries
if (!empty($orderNumber)) {
    $_SESSION['orderD'] = $orderNumber;
}

// Redirect to appropriate page
header("Location: " . $redirectUrl);
exit;

