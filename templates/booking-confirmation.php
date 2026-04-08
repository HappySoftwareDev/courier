<?php
/**
 * Booking Confirmation Template
 * Displays order details and next steps after successful booking
 */

// Get order ID from URL
$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo '<div class="alert alert-danger">Order ID not found. <a href="/book/">Return to booking</a></div>';
    exit;
}

// Load configuration
require_once dirname(__DIR__) . '/config/bootstrap.php';

// Fetch booking details
$bookingProcessor = new BookingProcessor($DB, $CONFIG);
$booking = $bookingProcessor->getBookingByOrderId($orderId);

if (!$booking) {
    echo '<div class="alert alert-danger">Booking not found. <a href="/book/">Return to booking</a></div>';
    exit;
}

// Decode booking data if stored as JSON
$bookingData = is_array($booking['booking_data']) 
    ? $booking['booking_data'] 
    : json_decode($booking['booking_data'], true);

// Get service config
$fieldConfig = require_once dirname(__DIR__) . '/config/booking-fields-config.php';
$serviceType = $booking['service_type'];
$serviceConfig = $fieldConfig[$serviceType] ?? [];

// Format dates
$bookingDate = date('F j, Y \a\t g:i A', strtotime($booking['created_at']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - <?php echo htmlspecialchars($booking['order_id']); ?></title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fontawesome-all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px 0;
        }

        .confirmation-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .confirmation-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .confirmation-header h1 {
            margin: 0 0 10px 0;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .confirmation-header .icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .order-id {
            font-size: 1.2rem;
            margin: 10px 0;
            opacity: 0.9;
        }

        .confirmation-body {
            padding: 40px;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            color: #333;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 500;
            color: #666;
            flex: 0 0 200px;
        }

        .info-value {
            color: #333;
            flex: 1;
        }

        .service-details {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .service-details h4 {
            margin: 0 0 15px 0;
            color: #007bff;
        }

        .detail-item {
            display: flex;
            padding: 8px 0;
            font-size: 0.95rem;
        }

        .detail-label {
            font-weight: 500;
            margin-right: 15px;
            min-width: 150px;
        }

        .detail-value {
            color: #555;
            flex: 1;
        }

        .price-section {
            background-color: #f0f9ff;
            border: 2px solid #007bff;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 1rem;
        }

        .price-row.total {
            font-weight: bold;
            font-size: 1.3rem;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #007bff;
            color: #007bff;
        }

        .next-steps {
            background-color: #e8f5e9;
            border-left: 4px solid #28a745;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .next-steps h4 {
            margin: 0 0 15px 0;
            color: #28a745;
        }

        .next-steps ol {
            margin: 0;
            padding-left: 20px;
        }

        .next-steps li {
            margin: 8px 0;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .status-badge.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-badge.confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-badge.completed {
            background-color: #cfe2ff;
            color: #084298;
        }

        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            color: white;
        }

        @media (max-width: 768px) {
            .confirmation-header {
                padding: 20px;
            }

            .confirmation-header h1 {
                font-size: 1.8rem;
            }

            .confirmation-header .icon {
                font-size: 2.5rem;
            }

            .confirmation-body {
                padding: 20px;
            }

            .info-row {
                flex-direction: column;
            }

            .info-label {
                margin-bottom: 5px;
                flex: none;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <!-- Header -->
        <div class="confirmation-header">
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Booking Confirmed!</h1>
            <div class="order-id">Order ID: <strong><?php echo htmlspecialchars($booking['order_id']); ?></strong></div>
        </div>

        <!-- Body -->
        <div class="confirmation-body">
            <!-- Status Section -->
            <div class="section">
                <div class="section-title">Booking Status</div>
                <div class="info-row">
                    <div class="info-label">Current Status:</div>
                    <div class="info-value">
                        <span class="status-badge <?php echo strtolower($booking['status'] ?? 'pending'); ?>">
                            <?php echo ucfirst($booking['status'] ?? 'Pending'); ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Booking Date:</div>
                    <div class="info-value"><?php echo $bookingDate; ?></div>
                </div>
            </div>

            <!-- Service Information -->
            <div class="section">
                <div class="section-title">Service Details</div>
                <div class="service-details">
                    <h4>
                        <i class="<?php echo htmlspecialchars($serviceConfig['icon'] ?? 'fas fa-box'); ?>"></i>
                        <?php echo htmlspecialchars($serviceConfig['service_name'] ?? ucfirst($serviceType)); ?>
                    </h4>
                    
                    <!-- Common Fields -->
                    <?php foreach ($serviceConfig['common_fields'] ?? [] as $fieldKey => $fieldDef): ?>
                        <?php if (isset($bookingData[$fieldKey]) && !empty($bookingData[$fieldKey])): ?>
                            <div class="detail-item">
                                <div class="detail-label"><?php echo htmlspecialchars($fieldDef['label'] ?? $fieldKey); ?>:</div>
                                <div class="detail-value"><?php echo htmlspecialchars($bookingData[$fieldKey]); ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <!-- Service-Specific Fields -->
                    <?php foreach ($serviceConfig['service_fields'] ?? [] as $fieldKey => $fieldDef): ?>
                        <?php if (isset($bookingData[$fieldKey]) && !empty($bookingData[$fieldKey])): ?>
                            <div class="detail-item">
                                <div class="detail-label"><?php echo htmlspecialchars($fieldDef['label'] ?? $fieldKey); ?>:</div>
                                <div class="detail-value">
                                    <?php 
                                        $value = $bookingData[$fieldKey];
                                        // Format checkboxes as Yes/No
                                        if ($fieldDef['type'] === 'checkbox') {
                                            echo $value ? 'Yes' : 'No';
                                        } else {
                                            echo htmlspecialchars($value);
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="section">
                <div class="section-title">Pricing Summary</div>
                <div class="price-section">
                    <div class="price-row">
                        <span>Base Price:</span>
                        <span>$<?php echo number_format($booking['base_price'], 2); ?></span>
                    </div>
                    
                    <?php if (!empty($booking['modifiers'])): ?>
                        <?php 
                            $modifiers = is_array($booking['modifiers']) 
                                ? $booking['modifiers'] 
                                : json_decode($booking['modifiers'], true); 
                        ?>
                        <?php foreach ($modifiers as $modifier => $amount): ?>
                            <div class="price-row">
                                <span><?php echo ucfirst(str_replace('_', ' ', $modifier)); ?>:</span>
                                <span>+$<?php echo number_format($amount, 2); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (!empty($booking['coupon_discount'])): ?>
                        <div class="price-row" style="color: #28a745;">
                            <span>Coupon Discount:</span>
                            <span>-$<?php echo number_format($booking['coupon_discount'], 2); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="price-row total">
                        <span>Total Amount:</span>
                        <span>$<?php echo number_format($booking['total_price'], 2); ?></span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="section">
                <div class="next-steps">
                    <h4><i class="fas fa-tasks"></i> Next Steps</h4>
                    <ol>
                        <li><strong>Review Details:</strong> Please verify all the booking information above is correct.</li>
                        <li><strong>Proceed to Payment:</strong> Click the "Pay Now" button below to complete your payment.</li>
                        <li><strong>Confirmation Email:</strong> You will receive a confirmation email with your booking details.</li>
                        <li><strong>Driver Assignment:</strong> Our system will assign a driver and you'll receive their contact details.</li>
                        <li><strong>Tracking:</strong> You can track your shipment in real-time through your account dashboard.</li>
                    </ol>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="section">
                <div class="section-title">Need Help?</div>
                <div class="info-row">
                    <div class="info-label">Customer Support:</div>
                    <div class="info-value">
                        <div>Email: <a href="mailto:support@wgroos.com">support@wgroos.com</a></div>
                        <div>Phone: <a href="tel:+1234567890">+1 (234) 567-890</a></div>
                        <div>Hours: Monday - Friday, 9:00 AM - 6:00 PM (Local Time)</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="/book/booking-confirmation.php?order_id=<?php echo htmlspecialchars($booking['order_id']); ?>&print=1" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-print"></i> Print Confirmation
                </a>
                <a href="/paynow.php?order_id=<?php echo htmlspecialchars($booking['order_id']); ?>" class="btn btn-primary">
                    <i class="fas fa-credit-card"></i> Pay Now
                </a>
                <a href="/book/" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> New Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <script>
        // Handle print if requested
        if (new URLSearchParams(window.location.search).get('print') === '1') {
            window.print();
        }
    </script>
</body>
</html>

<?php
/**
 * Helper Methods
 * These would typically be in the BookingProcessor class
 */

// Note: getBookingByOrderId() method should be added to BookingProcessor class:
// public function getBookingByOrderId($orderId) {
//     $stmt = $this->db->prepare("SELECT * FROM bookings WHERE order_id = ?");
//     $stmt->execute([$orderId]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }
?>


