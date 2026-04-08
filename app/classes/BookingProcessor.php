<?php
/**
 * Booking Processor Class
 * Handles all booking-related operations
 */

class BookingProcessor {
    private $db;
    private $config;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * Validate and apply coupon
     */
    public function validateAndApplyCoupon($couponCode, $userId) {
        $today = date('Y-m-d');

        try {
            // Check user-specific coupon first
            $stmt = $this->db->prepare(
                "SELECT * FROM user_coupons 
                 WHERE user_id = :uid AND coupon = :code 
                 AND expiry_date >= :today 
                 AND used < limit_used
                 LIMIT 1"
            );
            $stmt->execute([
                ':uid' => $userId,
                ':code' => $couponCode,
                ':today' => $today
            ]);

            if ($stmt->rowCount() > 0) {
                $coupon = $stmt->fetch();
                $this->incrementCouponUsage($coupon['user_coupon_id'], false);
                return ['success' => true, 'coupon' => $coupon, 'discount' => $coupon['amount']];
            }

            // Check common coupon
            $stmt = $this->db->prepare(
                "SELECT * FROM common_coupon 
                 WHERE coupon = :code 
                 AND expiry_date >= :today 
                 AND used < limit_used
                 LIMIT 1"
            );
            $stmt->execute([':code' => $couponCode, ':today' => $today]);

            if ($stmt->rowCount() > 0) {
                $coupon = $stmt->fetch();
                $this->incrementCouponUsage($coupon['id'], true);
                return ['success' => true, 'coupon' => $coupon, 'discount' => $coupon['amount']];
            }

            return ['success' => false, 'error' => 'Invalid or expired coupon'];

        } catch (Exception $e) {
            error_log("Coupon Validation Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Error validating coupon'];
        }
    }

    /**
     * Increment coupon usage
     */
    private function incrementCouponUsage($couponId, $isCommon = false) {
        try {
            $table = $isCommon ? 'common_coupon' : 'user_coupons';
            $idField = $isCommon ? 'id' : 'user_coupon_id';

            $stmt = $this->db->prepare(
                "UPDATE $table SET used = used + 1 WHERE $idField = :id"
            );
            return $stmt->execute([':id' => $couponId]);
        } catch (Exception $e) {
            error_log("Coupon Usage Update Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a new booking
     */
    public function createBooking($data) {
        try {
            // Generate order number
            $orderNumber = $this->generateOrderNumber();

            $stmt = $this->db->prepare("
                INSERT INTO bookings (
                    order_number, Name, email, phone, pick_up_address, 
                    drop_address, Drop_name, drop_phone, pick_up_date, 
                    pick_up_time, drop_date, drop_time, weight, quantity,
                    value, insurance, type_of_transport, drivers_note,
                    vehicle_type, Total_price, selectedCurrency, 
                    selectedCurrencySymbol, Date, user_id
                ) VALUES (
                    :order_num, :name, :email, :phone, :pickup_addr,
                    :drop_addr, :drop_name, :drop_phone, :pickup_date,
                    :pickup_time, :drop_date, :drop_time, :weight, :qty,
                    :value, :insurance, :transport, :note, :vehicle,
                    :total, :currency, :currency_symbol, NOW(), :user_id
                )
            ");

            $params = array_merge($data, [':order_num' => $orderNumber]);

            if ($stmt->execute($params)) {
                return [
                    'success' => true,
                    'booking_id' => $this->db->lastInsertId(),
                    'order_number' => $orderNumber
                ];
            }

            return ['success' => false, 'error' => 'Failed to create booking'];

        } catch (Exception $e) {
            error_log("Booking Creation Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Error creating booking'];
        }
    }

    /**
     * Get booking by ID or order number
     */
    public function getBooking($identifier, $type = 'id') {
        try {
            $field = ($type === 'order') ? 'order_number' : 'order_id';
            
            $stmt = $this->db->prepare("SELECT * FROM bookings WHERE $field = ? LIMIT 1");
            $stmt->execute([$identifier]);

            return $stmt->fetch();

        } catch (Exception $e) {
            error_log("Get Booking Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus($bookingId, $status) {
        try {
            $validStatuses = ['new', 'accepted', 'picked_up', 'in_transit', 'completed', 'cancelled'];

            if (!in_array($status, $validStatuses)) {
                return ['success' => false, 'error' => 'Invalid status'];
            }

            $stmt = $this->db->prepare(
                "UPDATE bookings SET status = :status, updated_at = NOW() WHERE order_id = :id"
            );

            if ($stmt->execute([':status' => $status, ':id' => $bookingId])) {
                return ['success' => true, 'message' => 'Status updated'];
            }

            return ['success' => false, 'error' => 'Failed to update status'];

        } catch (Exception $e) {
            error_log("Booking Status Update Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Error updating status'];
        }
    }

    /**
     * Get user bookings
     */
    public function getUserBookings($userId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM bookings WHERE user_id = :uid ORDER BY Date DESC"
            );
            $stmt->execute([':uid' => $userId]);

            return $stmt->fetchAll();

        } catch (Exception $e) {
            error_log("Get User Bookings Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Assign driver to booking
     */
    public function assignDriver($bookingId, $driverId, $bidPrice = null) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE bookings SET driver_assigned = :driver, bid_price = :price, status = 'accepted' WHERE order_id = :id"
            );

            return $stmt->execute([
                ':driver' => $driverId,
                ':price' => $bidPrice,
                ':id' => $bookingId
            ]);

        } catch (Exception $e) {
            error_log("Assign Driver Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber() {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
    }

    /**
     * Validate booking data based on service type
     * Uses field configuration to enforce required fields and types
     *
     * @param array $bookingData
     * @param string $serviceType (parcel, freight, furniture, taxi, towtruck)
     * @return array ['valid' => bool, 'errors' => array]
     */
    public function validateBookingData($bookingData, $serviceType)
    {
        $errors = [];
        
        // Load field configuration
        $bookingFieldsPath = dirname(__DIR__) . '/config/booking-fields-config.php';
        if (!file_exists($bookingFieldsPath)) {
            return ['valid' => false, 'errors' => ['Field configuration not found']];
        }

        $bookingFields = require_once $bookingFieldsPath;

        if (!isset($bookingFields[$serviceType])) {
            return ['valid' => false, 'errors' => ['Invalid service type: ' . $serviceType]];
        }

        $config = $bookingFields[$serviceType];
        $allFields = array_merge($config['common_fields'], $config['service_fields']);

        // Validate each field
        foreach ($allFields as $fieldName => $fieldConfig) {
            $fieldValue = $bookingData[$fieldName] ?? null;
            $fieldLabel = $fieldConfig['label'] ?? ucfirst($fieldName);

            // Check required fields
            if ($fieldConfig['required'] && empty($fieldValue)) {
                $errors[] = $fieldLabel . ' is required';
                continue;
            }

            // Skip validation if field is not required and empty
            if (empty($fieldValue) && !$fieldConfig['required']) {
                continue;
            }

            // Type-specific validation
            $fieldType = $fieldConfig['type'] ?? 'text';
            
            switch ($fieldType) {
                case 'email':
                    if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = $fieldLabel . ' must be a valid email address';
                    }
                    break;

                case 'tel':
                    // Allow various phone formats with at least 10 digits
                    if (!preg_match('/^\+?[\d\s\-\(\)]{10,}$/', str_replace([' ', '-', '(', ')'], '', $fieldValue))) {
                        $errors[] = $fieldLabel . ' must be a valid phone number';
                    }
                    break;

                case 'number':
                    if (!is_numeric($fieldValue)) {
                        $errors[] = $fieldLabel . ' must be a number';
                    } else {
                        if (isset($fieldConfig['min']) && (float)$fieldValue < (float)$fieldConfig['min']) {
                            $errors[] = $fieldLabel . ' cannot be less than ' . $fieldConfig['min'];
                        }
                        if (isset($fieldConfig['max']) && (float)$fieldValue > (float)$fieldConfig['max']) {
                            $errors[] = $fieldLabel . ' cannot be more than ' . $fieldConfig['max'];
                        }
                    }
                    break;

                case 'select':
                    if (isset($fieldConfig['options']) && !array_key_exists($fieldValue, $fieldConfig['options'])) {
                        $errors[] = 'Invalid selection for ' . strtolower($fieldLabel);
                    }
                    break;

                case 'datetime-local':
                    if (!strtotime($fieldValue)) {
                        $errors[] = $fieldLabel . ' must be a valid date and time';
                    } else {
                        // Check if datetime is in the future
                        if (strtotime($fieldValue) < time()) {
                            $errors[] = $fieldLabel . ' must be in the future';
                        }
                    }
                    break;

                case 'text':
                case 'textarea':
                    // Basic text validation - check length if needed
                    if (strlen($fieldValue) > 500) {
                        $errors[] = $fieldLabel . ' is too long (max 500 characters)';
                    }
                    break;
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'service_type' => $serviceType
        ];
    }

    /**
     * Get service type configuration
     *
     * @param string $serviceType
     * @return array|null
     */
    public function getServiceConfig($serviceType)
    {
        $bookingFieldsPath = dirname(__DIR__) . '/config/booking-fields-config.php';
        if (!file_exists($bookingFieldsPath)) {
            return null;
        }

        $bookingFields = require_once $bookingFieldsPath;
        return $bookingFields[$serviceType] ?? null;
    }

    /**
     * Get all field definitions for a service type
     *
     * @param string $serviceType
     * @return array
     */
    public function getServiceFields($serviceType)
    {
        $config = $this->getServiceConfig($serviceType);
        if (!$config) {
            return [];
        }

        return array_merge($config['common_fields'] ?? [], $config['service_fields'] ?? []);
    }

    /**
     * Get booking by order ID
     */
    public function getBookingByOrderId($orderId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM bookings WHERE order_id = :order_id LIMIT 1"
            );
            $stmt->execute([':order_id' => $orderId]);
            
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Error fetching booking by order ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get booking by ID
     */
    public function getBookingById($bookingId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM bookings WHERE booking_id = :id LIMIT 1"
            );
            $stmt->execute([':id' => $bookingId]);
            
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Error fetching booking: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus($bookingId, $status) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE bookings SET status = :status, updated_at = NOW() WHERE booking_id = :id"
            );
            return $stmt->execute([
                ':status' => $status,
                ':id' => $bookingId
            ]);
        } catch (Exception $e) {
            error_log("Error updating booking status: " . $e->getMessage());
            return false;
        }
    }
}

?>



