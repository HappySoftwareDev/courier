<?php
/**
 * Payment Gateway Interface
 * Defines contract for all payment providers
 */

interface PaymentGatewayInterface {
    /**
     * Initialize payment
     */
    public function initializePayment($bookingId, $amount, $currency, $customerEmail, $customerPhone);

    /**
     * Process payment
     */
    public function processPayment($paymentData);

    /**
     * Get payment status
     */
    public function getPaymentStatus($transactionId);

    /**
     * Handle webhook callback
     */
    public function handleWebhook($data);

    /**
     * Get gateway name
     */
    public function getName();

    /**
     * Check if gateway is enabled
     */
    public function isEnabled();

    /**
     * Get gateway configuration
     */
    public function getConfig();
}

/**
 * Abstract base payment gateway
 */
abstract class BasePaymentGateway implements PaymentGatewayInterface {
    protected $db;
    protected $config;
    protected $gatewayName = 'Unknown Gateway';
    protected $enabled = false;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * Log payment transaction
     */
    protected function logTransaction($bookingId, $gateway, $transactionId, $amount, $currency, $status) {
        try {
            $sql = "INSERT INTO payment_transactions 
                    (booking_id, gateway, transaction_id, amount, currency, status, created_at)
                    VALUES (:booking_id, :gateway, :transaction_id, :amount, :currency, :status, NOW())";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':booking_id' => $bookingId,
                ':gateway' => $gateway,
                ':transaction_id' => $transactionId,
                ':amount' => $amount,
                ':currency' => $currency,
                ':status' => $status
            ]);
            
            return true;
        } catch (Exception $e) {
            error_log("Payment Log Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update booking payment status
     */
    protected function updateBookingPaymentStatus($bookingId, $paymentStatus, $transactionId) {
        try {
            $sql = "UPDATE bookings 
                    SET payment_status = :status, transaction_id = :transaction_id, updated_at = NOW()
                    WHERE order_id = :booking_id";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':status' => $paymentStatus,
                ':transaction_id' => $transactionId,
                ':booking_id' => $bookingId
            ]);
        } catch (Exception $e) {
            error_log("Booking Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function getName() {
        return $this->gatewayName;
    }

    public function isEnabled() {
        return $this->enabled;
    }

    public function getConfig() {
        return [];
    }
}
