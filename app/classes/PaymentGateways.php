<?php
/**
 * PayNow Payment Gateway (Zimbabwe)
 * Integration with PayNow for Zimbabwean payments
 */

require_once __DIR__ . '/PaymentGatewayInterface.php';

class PayNowGateway extends BasePaymentGateway {
    protected $gatewayName = 'PayNow';
    private $integrationId;
    private $integrationKey;
    private $baseUrl = 'https://www.paynow.co.zw';

    public function __construct($db, $config) {
        parent::__construct($db, $config);
        
        $this->integrationId = $config->get('paynow_integration_id');
        $this->integrationKey = $config->get('paynow_integration_key');
        $this->enabled = $config->get('paynow_enabled', 'false') === 'true';
    }

    public function initializePayment($bookingId, $amount, $currency, $customerEmail, $customerPhone) {
        if (!$this->enabled || !$this->integrationId) {
            return ['success' => false, 'error' => 'PayNow not configured'];
        }

        try {
            // Load PayNow library
            require_once dirname(__DIR__) . '/../paynow/autoloader.php';
            
            // Create Paynow instance
            $paynow = new \Paynow\Payments\Paynow(
                $this->integrationId,
                $this->integrationKey,
                $_SERVER['HTTP_HOST'],
                $_SERVER['HTTP_HOST']
            );

            // Create payment
            $payment = $paynow->createPayment($bookingId, $customerEmail);
            $payment->add('Booking #' . $bookingId, $amount);
            $payment->setDescription('Booking Payment for Order #' . $bookingId);

            // Get payment link
            $link = $paynow->send($payment);

            if ($link->success()) {
                // Log transaction
                $this->logTransaction($bookingId, 'paynow', $link->redirectUrl(), $amount, $currency, 'pending');

                return [
                    'success' => true,
                    'gateway' => 'paynow',
                    'redirect_url' => $link->redirectUrl(),
                    'reference' => $link->reference(),
                    'amount' => $amount,
                    'currency' => $currency
                ];
            } else {
                return ['success' => false, 'error' => 'Failed to initialize PayNow payment'];
            }

        } catch (Exception $e) {
            error_log("PayNow Initialization Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function processPayment($paymentData) {
        // PayNow handles redirect, we process callback in handleWebhook
        return ['success' => true, 'message' => 'Redirecting to PayNow'];
    }

    public function getPaymentStatus($transactionId) {
        try {
            require_once dirname(__DIR__) . '/../paynow/autoloader.php';
            
            $paynow = new \Paynow\Payments\Paynow(
                $this->integrationId,
                $this->integrationKey,
                $_SERVER['HTTP_HOST'],
                $_SERVER['HTTP_HOST']
            );

            $status = $paynow->pollTransaction($transactionId);
            
            return [
                'status' => $status->paid() ? 'completed' : 'pending',
                'amount' => $status->amount(),
                'reference' => $status->reference()
            ];

        } catch (Exception $e) {
            error_log("PayNow Status Error: " . $e->getMessage());
            return ['status' => 'error', 'error' => $e->getMessage()];
        }
    }

    public function handleWebhook($data) {
        // PayNow sends callback with reference and status
        $reference = $data['reference'] ?? null;
        $status = $data['status'] ?? null;

        if (!$reference) {
            return ['success' => false, 'error' => 'Invalid callback data'];
        }

        try {
            // Get booking by reference
            $stmt = $this->db->prepare("SELECT order_id FROM bookings WHERE transaction_id = :ref LIMIT 1");
            $stmt->execute([':ref' => $reference]);
            
            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'error' => 'Booking not found'];
            }

            $booking = $stmt->fetch();
            $bookingId = $booking['order_id'];

            // Update payment status
            $paymentStatus = ($status === 'Delivered') ? 'completed' : 'failed';
            $this->updateBookingPaymentStatus($bookingId, $paymentStatus, $reference);

            return ['success' => true, 'booking_id' => $bookingId, 'status' => $paymentStatus];

        } catch (Exception $e) {
            error_log("PayNow Webhook Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getConfig() {
        return [
            'integration_id' => $this->integrationId,
            'enabled' => $this->enabled,
            'currency' => 'ZWL',
            'countries' => ['ZW']
        ];
    }
}

/**
 * Stripe Payment Gateway (Global)
 */
class StripeGateway extends BasePaymentGateway {
    protected $gatewayName = 'Stripe';
    private $publishableKey;
    private $secretKey;

    public function __construct($db, $config) {
        parent::__construct($db, $config);
        
        $this->publishableKey = $config->get('stripe_public_key');
        $this->secretKey = $config->get('stripe_secret_key');
        $this->enabled = $config->get('stripe_enabled', 'false') === 'true';

        // Check if keys are production (not test keys)
        if ($this->publishableKey && strpos($this->publishableKey, 'pk_test_') === 0) {
            error_log("Warning: Stripe is using test keys in production");
        }
    }

    public function initializePayment($bookingId, $amount, $currency, $customerEmail, $customerPhone) {
        if (!$this->enabled || !$this->secretKey) {
            return ['success' => false, 'error' => 'Stripe not configured'];
        }

        try {
            require_once dirname(__DIR__) . '/../vendor/stripe/stripe-php/init.php';
            \Stripe\Stripe::setApiKey($this->secretKey);

            // Create payment intent
            $intent = \Stripe\PaymentIntent::create([
                'amount' => round($amount * 100), // Convert to cents
                'currency' => strtolower($currency),
                'metadata' => [
                    'booking_id' => $bookingId,
                    'customer_email' => $customerEmail,
                    'customer_phone' => $customerPhone
                ],
                'receipt_email' => $customerEmail
            ]);

            // Log transaction
            $this->logTransaction($bookingId, 'stripe', $intent->id, $amount, $currency, 'pending');

            return [
                'success' => true,
                'gateway' => 'stripe',
                'client_secret' => $intent->client_secret,
                'intent_id' => $intent->id,
                'amount' => $amount,
                'currency' => $currency,
                'publishable_key' => $this->publishableKey
            ];

        } catch (Exception $e) {
            error_log("Stripe Initialization Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function processPayment($paymentData) {
        // Stripe handles processing on client-side with Stripe Elements
        return ['success' => true, 'message' => 'Processing Stripe payment'];
    }

    public function getPaymentStatus($transactionId) {
        try {
            require_once dirname(__DIR__) . '/../vendor/stripe/stripe-php/init.php';
            \Stripe\Stripe::setApiKey($this->secretKey);

            $intent = \Stripe\PaymentIntent::retrieve($transactionId);
            
            $statusMap = [
                'succeeded' => 'completed',
                'processing' => 'processing',
                'requires_payment_method' => 'pending',
                'requires_action' => 'pending',
                'canceled' => 'failed'
            ];

            return [
                'status' => $statusMap[$intent->status] ?? $intent->status,
                'amount' => $intent->amount / 100,
                'currency' => strtoupper($intent->currency),
                'intent_id' => $intent->id
            ];

        } catch (Exception $e) {
            error_log("Stripe Status Error: " . $e->getMessage());
            return ['status' => 'error', 'error' => $e->getMessage()];
        }
    }

    public function handleWebhook($data) {
        // Stripe sends webhooks with event data
        $eventType = $data['type'] ?? null;
        $intentId = $data['data']['object']['id'] ?? null;

        if (!$intentId) {
            return ['success' => false, 'error' => 'Invalid webhook data'];
        }

        try {
            $status = $this->getPaymentStatus($intentId);
            
            // Find booking by intent ID
            $stmt = $this->db->prepare("SELECT order_id FROM bookings WHERE transaction_id = :id LIMIT 1");
            $stmt->execute([':id' => $intentId]);
            
            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'error' => 'Booking not found'];
            }

            $booking = $stmt->fetch();
            $this->updateBookingPaymentStatus($booking['order_id'], $status['status'], $intentId);

            return ['success' => true, 'booking_id' => $booking['order_id'], 'status' => $status['status']];

        } catch (Exception $e) {
            error_log("Stripe Webhook Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getConfig() {
        return [
            'enabled' => $this->enabled,
            'publishable_key' => $this->publishableKey,
            'currency_support' => 'All major currencies'
        ];
    }
}

/**
 * PayPal Payment Gateway (Global)
 */
class PayPalGateway extends BasePaymentGateway {
    protected $gatewayName = 'PayPal';
    private $clientId;
    private $clientSecret;
    private $mode = 'sandbox'; // or 'live'

    public function __construct($db, $config) {
        parent::__construct($db, $config);
        
        $this->clientId = $config->get('paypal_client_id');
        $this->clientSecret = $config->get('paypal_client_secret');
        $this->enabled = $config->get('paypal_enabled', 'false') === 'true';
        $this->mode = $config->get('paypal_mode', 'sandbox');
    }

    public function initializePayment($bookingId, $amount, $currency, $customerEmail, $customerPhone) {
        if (!$this->enabled || !$this->clientId) {
            return ['success' => false, 'error' => 'PayPal not configured'];
        }

        try {
            // Get access token
            $token = $this->getAccessToken();
            if (!$token) {
                return ['success' => false, 'error' => 'Failed to get PayPal access token'];
            }

            $baseUrl = $this->mode === 'sandbox' 
                ? 'https://api-m.sandbox.paypal.com'
                : 'https://api-m.paypal.com';

            // Create order
            $orderData = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => $bookingId,
                        'amount' => [
                            'currency_code' => strtoupper($currency),
                            'value' => number_format($amount, 2, '.', '')
                        ],
                        'description' => 'Booking #' . $bookingId
                    ]
                ],
                'payer' => [
                    'email_address' => $customerEmail,
                    'phone' => [
                        'phone_number' => [
                            'national_number' => $customerPhone
                        ]
                    ]
                ]
            ];

            $ch = curl_init($baseUrl . '/v2/checkout/orders');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($orderData),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ]
            ]);

            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (isset($response['id'])) {
                // Log transaction
                $this->logTransaction($bookingId, 'paypal', $response['id'], $amount, $currency, 'pending');

                // Get approval link
                $approvalLink = null;
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approvalLink = $link['href'];
                        break;
                    }
                }

                return [
                    'success' => true,
                    'gateway' => 'paypal',
                    'order_id' => $response['id'],
                    'redirect_url' => $approvalLink,
                    'amount' => $amount,
                    'currency' => $currency
                ];
            } else {
                return ['success' => false, 'error' => 'Failed to create PayPal order'];
            }

        } catch (Exception $e) {
            error_log("PayPal Initialization Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function processPayment($paymentData) {
        // PayPal handles capture in webhook
        return ['success' => true, 'message' => 'Processing PayPal payment'];
    }

    public function getPaymentStatus($transactionId) {
        try {
            $token = $this->getAccessToken();
            if (!$token) {
                return ['status' => 'error', 'error' => 'Failed to authenticate with PayPal'];
            }

            $baseUrl = $this->mode === 'sandbox'
                ? 'https://api-m.sandbox.paypal.com'
                : 'https://api-m.paypal.com';

            $ch = curl_init($baseUrl . '/v2/checkout/orders/' . $transactionId);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token]
            ]);

            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);

            $statusMap = [
                'CREATED' => 'pending',
                'SAVED' => 'pending',
                'APPROVED' => 'pending',
                'VOIDED' => 'cancelled',
                'COMPLETED' => 'completed',
                'PAYER_ACTION_REQUIRED' => 'pending'
            ];

            return [
                'status' => $statusMap[$response['status']] ?? $response['status'],
                'order_id' => $response['id']
            ];

        } catch (Exception $e) {
            error_log("PayPal Status Error: " . $e->getMessage());
            return ['status' => 'error', 'error' => $e->getMessage()];
        }
    }

    public function handleWebhook($data) {
        // PayPal sends webhook with order status
        $orderId = $data['resource']['id'] ?? null;
        $status = $data['event_type'] ?? null;

        if (!$orderId) {
            return ['success' => false, 'error' => 'Invalid webhook data'];
        }

        try {
            $paymentStatus = $this->getPaymentStatus($orderId);
            
            // Find booking
            $stmt = $this->db->prepare("SELECT order_id FROM bookings WHERE transaction_id = :id LIMIT 1");
            $stmt->execute([':id' => $orderId]);
            
            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'error' => 'Booking not found'];
            }

            $booking = $stmt->fetch();
            $this->updateBookingPaymentStatus($booking['order_id'], $paymentStatus['status'], $orderId);

            return ['success' => true, 'booking_id' => $booking['order_id'], 'status' => $paymentStatus['status']];

        } catch (Exception $e) {
            error_log("PayPal Webhook Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function getAccessToken() {
        try {
            $baseUrl = $this->mode === 'sandbox'
                ? 'https://api-m.sandbox.paypal.com'
                : 'https://api-m.paypal.com';

            $ch = curl_init($baseUrl . '/v1/oauth2/token');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_USERPWD => $this->clientId . ':' . $this->clientSecret,
                CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                CURLOPT_HTTPHEADER => ['Accept: application/json']
            ]);

            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);

            return $response['access_token'] ?? null;

        } catch (Exception $e) {
            error_log("PayPal Auth Error: " . $e->getMessage());
            return null;
        }
    }

    public function getConfig() {
        return [
            'enabled' => $this->enabled,
            'mode' => $this->mode,
            'currency_support' => 'All major currencies'
        ];
    }
}
