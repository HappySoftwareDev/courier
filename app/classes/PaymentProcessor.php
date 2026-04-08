<?php
/**
 * Unified Payment Processor
 * Routes payments to appropriate gateway based on country and configuration
 */

class PaymentProcessor {
    private $db;
    private $config;
    private $gateways = [];
    private $countryManager;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
        $this->countryManager = new CountryManager();
        $this->initializeGateways();
    }

    /**
     * Initialize all payment gateways
     */
    private function initializeGateways() {
        // Load PayNow
        require_once __DIR__ . '/PaymentGateways.php';
        $this->gateways['paynow'] = new PayNowGateway($this->db, $this->config);
        
        // Load Stripe
        $this->gateways['stripe'] = new StripeGateway($this->db, $this->config);
        
        // Load PayPal
        $this->gateways['paypal'] = new PayPalGateway($this->db, $this->config);
        
        // Load 543Konse
        require_once __DIR__ . '/KonseGateway.php';
        $this->gateways['konse'] = new KonseGateway($this->db, $this->config);
    }

    /**
     * Get available gateways for a country
     */
    public function getAvailableGateways($countryCode) {
        $available = [];
        $countryCode = strtoupper($countryCode);

        // Zimbabwe
        if ($countryCode === 'ZW') {
            if ($this->gateways['paynow']->isEnabled()) {
                $available['paynow'] = [
                    'name' => 'PayNow',
                    'description' => 'Pay via PayNow (Cards, Mobile Money)',
                    'currency' => 'ZWL',
                    'gateway' => $this->gateways['paynow']
                ];
            }
            if ($this->gateways['stripe']->isEnabled()) {
                $available['stripe'] = [
                    'name' => 'Stripe',
                    'description' => 'Pay via Stripe (International Cards)',
                    'currency' => 'USD',
                    'gateway' => $this->gateways['stripe']
                ];
            }
        }

        // Zambia
        else if ($countryCode === 'ZM') {
            if ($this->gateways['konse']->isEnabled()) {
                $available['konse'] = [
                    'name' => '543Konse',
                    'description' => 'Pay via 543Konse (Mobile Money, Cards)',
                    'currency' => 'ZMW',
                    'gateway' => $this->gateways['konse']
                ];
            }
            if ($this->gateways['stripe']->isEnabled()) {
                $available['stripe'] = [
                    'name' => 'Stripe',
                    'description' => 'Pay via Stripe (International Cards)',
                    'currency' => 'USD',
                    'gateway' => $this->gateways['stripe']
                ];
            }
        }

        // All other countries
        else {
            if ($this->gateways['stripe']->isEnabled()) {
                $available['stripe'] = [
                    'name' => 'Stripe',
                    'description' => 'Pay via Stripe (Cards worldwide)',
                    'currency' => $this->config->get('base_currency', 'USD'),
                    'gateway' => $this->gateways['stripe']
                ];
            }
            if ($this->gateways['paypal']->isEnabled()) {
                $available['paypal'] = [
                    'name' => 'PayPal',
                    'description' => 'Pay via PayPal',
                    'currency' => $this->config->get('base_currency', 'USD'),
                    'gateway' => $this->gateways['paypal']
                ];
            }
        }

        return $available;
    }

    /**
     * Get default gateway for country
     */
    public function getDefaultGateway($countryCode) {
        $available = $this->getAvailableGateways($countryCode);
        
        if (empty($available)) {
            return null;
        }

        // Country-specific defaults
        $countryCode = strtoupper($countryCode);
        $preferredOrder = [
            'ZW' => ['paynow', 'stripe'],
            'ZM' => ['konse', 'stripe'],
        ];

        if (isset($preferredOrder[$countryCode])) {
            foreach ($preferredOrder[$countryCode] as $gatewayKey) {
                if (isset($available[$gatewayKey])) {
                    return $available[$gatewayKey];
                }
            }
        }

        // Return first available
        return reset($available);
    }

    /**
     * Process booking payment
     */
    public function processBookingPayment($bookingId, $amount, $currency, $customerEmail, $customerPhone, $countryCode, $gatewayKey = null) {
        try {
            // Get available gateways
            $available = $this->getAvailableGateways($countryCode);

            if (empty($available)) {
                return ['success' => false, 'error' => 'No payment gateways available for this country'];
            }

            // Use specified gateway or default
            if ($gatewayKey && isset($available[$gatewayKey])) {
                $gateway = $available[$gatewayKey]['gateway'];
            } else {
                $defaultGateway = $this->getDefaultGateway($countryCode);
                $gateway = $defaultGateway['gateway'] ?? reset($available)['gateway'];
            }

            // Initialize payment with gateway
            $result = $gateway->initializePayment($bookingId, $amount, $currency, $customerEmail, $customerPhone);

            if ($result['success']) {
                // Log payment initialization
                error_log("Payment initialized - Booking: $bookingId, Gateway: " . $gateway->getName() . ", Amount: $amount $currency");
            }

            return $result;

        } catch (Exception $e) {
            error_log("Payment Processing Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Payment processing failed'];
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus($gatewayKey, $transactionId) {
        if (!isset($this->gateways[$gatewayKey])) {
            return ['status' => 'error', 'error' => 'Unknown gateway'];
        }

        return $this->gateways[$gatewayKey]->getPaymentStatus($transactionId);
    }

    /**
     * Handle payment webhook
     */
    public function handleWebhook($gatewayKey, $data) {
        if (!isset($this->gateways[$gatewayKey])) {
            return ['success' => false, 'error' => 'Unknown gateway'];
        }

        return $this->gateways[$gatewayKey]->handleWebhook($data);
    }

    /**
     * Get all gateway configurations
     */
    public function getAllGatewayConfigs() {
        $configs = [];
        foreach ($this->gateways as $key => $gateway) {
            $configs[$key] = [
                'name' => $gateway->getName(),
                'enabled' => $gateway->isEnabled(),
                'config' => $gateway->getConfig()
            ];
        }
        return $configs;
    }
}
