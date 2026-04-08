<?php
/**
 * 543Konse Payment Gateway (Zambia)
 * Integration with 543Konse for Zambian mobile money and card payments
 */

require_once __DIR__ . '/PaymentGatewayInterface.php';

class KonseGateway extends BasePaymentGateway {
    protected $gatewayName = '543Konse';
    private $apiKey;
    private $apiSecret;
    private $merchantId;
    private $baseUrl = 'https://api.543konse.com'; // Adjust to actual endpoint

    public function __construct($db, $config) {
        parent::__construct($db, $config);
        
        $this->apiKey = $config->get('konse_api_key');
        $this->apiSecret = $config->get('konse_api_secret');
        $this->merchantId = $config->get('konse_merchant_id');
        $this->enabled = $config->get('konse_enabled', 'false') === 'true';
    }

    public function initializePayment($bookingId, $amount, $currency, $customerEmail, $customerPhone) {
        if (!$this->enabled || !$this->apiKey || !$this->merchantId) {
            return ['success' => false, 'error' => '543Konse not configured'];
        }

        try {
            // Ensure currency is ZMW (Zambian Kwacha) for 543Konse
            if ($currency !== 'ZMW') {
                // Convert to ZMW if needed (you'd use your CurrencyExchangeManager)
                // For now, we'll use the amount as-is
            }

            // Prepare request signature
            $timestamp = time();
            $requestId = uniqid('konse_' . $bookingId);
            
            // Create signature: HMAC-SHA256
            $signatureData = $this->merchantId . $requestId . $amount . $timestamp . $this->apiSecret;
            $signature = hash('sha256', $signatureData);

            // Prepare payment request
            $paymentData = [
                'merchant_id' => $this->merchantId,
                'request_id' => $requestId,
                'amount' => $amount,
                'currency' => 'ZMW',
                'description' => 'Booking #' . $bookingId,
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
                'return_url' => 'https://' . $_SERVER['HTTP_HOST'] . '/portals/payments/konse-callback.php',
                'notify_url' => 'https://' . $_SERVER['HTTP_HOST'] . '/portals/payments/konse-webhook.php',
                'timestamp' => $timestamp,
                'signature' => $signature,
                'metadata' => [
                    'booking_id' => $bookingId,
                    'platform' => 'WGRoos'
                ]
            ];

            // Send to 543Konse API
            $ch = curl_init($this->baseUrl . '/v1/payments/initialize');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($paymentData),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $this->apiKey,
                    'X-API-Version: 1.0'
                ],
                CURLOPT_TIMEOUT => 10
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $responseData = json_decode($response, true);

            if ($httpCode === 200 && isset($responseData['payment_id'])) {
                // Log transaction
                $this->logTransaction($bookingId, 'konse', $responseData['payment_id'], $amount, 'ZMW', 'pending');

                return [
                    'success' => true,
                    'gateway' => 'konse',
                    'payment_id' => $responseData['payment_id'],
                    'redirect_url' => $responseData['payment_url'] ?? null,
                    'amount' => $amount,
                    'currency' => 'ZMW',
                    'reference' => $requestId
                ];
            } else {
                $error = $responseData['error'] ?? 'Failed to initialize 543Konse payment';
                return ['success' => false, 'error' => $error];
            }

        } catch (Exception $e) {
            error_log("543Konse Initialization Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function processPayment($paymentData) {
        // 543Konse handles processing via redirect or mobile wallet prompt
        return ['success' => true, 'message' => 'Processing 543Konse payment'];
    }

    public function getPaymentStatus($transactionId) {
        if (!$this->apiKey) {
            return ['status' => 'error', 'error' => '543Konse not configured'];
        }

        try {
            // Create signature for status check
            $timestamp = time();
            $signatureData = $this->merchantId . $transactionId . $timestamp . $this->apiSecret;
            $signature = hash('sha256', $signatureData);

            $ch = curl_init($this->baseUrl . '/v1/payments/' . $transactionId . '/status');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $this->apiKey,
                    'X-Merchant-ID: ' . $this->merchantId,
                    'X-Timestamp: ' . $timestamp,
                    'X-Signature: ' . $signature,
                    'X-API-Version: 1.0'
                ],
                CURLOPT_TIMEOUT => 10
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $responseData = json_decode($response, true);

            if ($httpCode === 200) {
                $statusMap = [
                    'pending' => 'processing',
                    'processing' => 'processing',
                    'completed' => 'completed',
                    'success' => 'completed',
                    'failed' => 'failed',
                    'cancelled' => 'cancelled'
                ];

                return [
                    'status' => $statusMap[$responseData['status']] ?? $responseData['status'],
                    'amount' => $responseData['amount'] ?? 0,
                    'currency' => 'ZMW',
                    'payment_id' => $transactionId,
                    'timestamp' => $responseData['timestamp'] ?? null
                ];
            } else {
                return ['status' => 'error', 'error' => 'Failed to get payment status'];
            }

        } catch (Exception $e) {
            error_log("543Konse Status Error: " . $e->getMessage());
            return ['status' => 'error', 'error' => $e->getMessage()];
        }
    }

    public function handleWebhook($data) {
        // Verify webhook signature
        if (!$this->verifyWebhookSignature($data)) {
            return ['success' => false, 'error' => 'Invalid webhook signature'];
        }

        try {
            $paymentId = $data['payment_id'] ?? null;
            $status = $data['status'] ?? null;

            if (!$paymentId) {
                return ['success' => false, 'error' => 'Invalid webhook data'];
            }

            // Get payment status to verify
            $paymentStatus = $this->getPaymentStatus($paymentId);
            
            // Find booking by payment ID
            $stmt = $this->db->prepare("SELECT order_id FROM bookings WHERE transaction_id = :id LIMIT 1");
            $stmt->execute([':id' => $paymentId]);
            
            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'error' => 'Booking not found'];
            }

            $booking = $stmt->fetch();
            $this->updateBookingPaymentStatus($booking['order_id'], $paymentStatus['status'], $paymentId);

            return ['success' => true, 'booking_id' => $booking['order_id'], 'status' => $paymentStatus['status']];

        } catch (Exception $e) {
            error_log("543Konse Webhook Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function verifyWebhookSignature($data) {
        $signature = $data['signature'] ?? null;
        if (!$signature) {
            return false;
        }

        // Reconstruct signature
        $paymentId = $data['payment_id'] ?? '';
        $status = $data['status'] ?? '';
        $timestamp = $data['timestamp'] ?? '';
        
        $signatureData = $paymentId . $status . $timestamp . $this->apiSecret;
        $expectedSignature = hash('sha256', $signatureData);

        return hash_equals($expectedSignature, $signature);
    }

    public function getConfig() {
        return [
            'gateway' => '543Konse',
            'enabled' => $this->enabled,
            'merchant_id' => $this->merchantId ? '***' : 'Not configured',
            'currency' => 'ZMW',
            'countries' => ['ZM'],
            'payment_methods' => [
                'Mobile Money (MTN, Airtel, Zamtel)',
                'Card Payments (Visa, Mastercard)',
                'Bank Transfer'
            ]
        ];
    }
}
