<?php
/**
 * Unified Booking Submission Handler
 * Handles all booking types: parcel, freight, furniture, taxi, towtruck
 * Single endpoint replacing all previous submit_parser*.php files
 * 
 * Features:
 * - Dynamic field validation based on service type
 * - Service-specific pricing calculation
 * - Coupon validation and application
 * - Email notifications
 * - Payment gateway integration
 * - Handles unauthenticated bookings (guest bookings)
 */

require_once '../config/bootstrap.php';

header('Content-Type: application/json');
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/logs/booking_errors.log');

// Helper function to send JSON response
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Invalid request method'], 405);
}

try {
    // Get service type from form
    $serviceType = $_POST['service_type'] ?? null;
    
    if (!$serviceType) {
        jsonResponse(['success' => false, 'message' => 'Service type is required'], 400);
    }

    // Initialize processors
    $bookingProcessor = new BookingProcessor($DB, $CONFIG);
    $pricingEngine = new PricingEngine($DB, $CONFIG);
    $emailHelper = new EmailHelper($CONFIG);

    // Validate booking data based on service type
    $validation = $bookingProcessor->validateBookingData($_POST, $serviceType);
    
    if (!$validation['valid']) {
        jsonResponse([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validation['errors']
        ], 400);
    }

    // Sanitize data
    $bookingData = ValidationHelper::sanitizeArray($_POST);

    // Get user ID if authenticated
    $userId = $_SESSION['Userid'] ?? $_SESSION['user_id'] ?? null;

    // Validate and apply coupon if provided
    $couponDiscount = 0;
    $couponId = null;
    
    if (!empty($bookingData['coupon_code'])) {
        $couponResult = $bookingProcessor->validateAndApplyCoupon(
            $bookingData['coupon_code'],
            $userId
        );
        
        if ($couponResult) {
            $couponDiscount = $couponResult['discount'] ?? 0;
            $couponId = $couponResult['id'] ?? null;
        } else {
            jsonResponse([
                'success' => false,
                'message' => 'Invalid or expired coupon code'
            ], 400);
        }
    }

    // Calculate booking price based on service type
    $basePrice = $pricingEngine->calculateBookingPrice(
        $serviceType,
        $bookingData['weight'] ?? 0,
        $bookingData['from_address'] ?? '',
        $bookingData['to_address'] ?? '',
        isset($bookingData['insurance']) && $bookingData['insurance'] == '1',
        'USD'
    );

    $finalPrice = max(0, $basePrice - $couponDiscount);

    // Generate unique order number
    $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

    // Prepare booking insertion
    $bookingInsertData = [
        'order_number' => $orderNumber,
        'service_type' => $serviceType,
        'user_id' => $userId,
        'name' => $bookingData['fullname'] ?? $bookingData['name'] ?? '',
        'email' => $bookingData['email'] ?? '',
        'phone' => $bookingData['phone'] ?? '',
        'from_address' => $bookingData['from_address'] ?? '',
        'to_address' => $bookingData['to_address'] ?? '',
        'booking_data' => json_encode($bookingData), // Store all form data as JSON
        'price' => $finalPrice,
        'coupon_id' => $couponId,
        'coupon_discount' => $couponDiscount,
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // Insert booking into database
    $result = $bookingProcessor->createBooking($bookingInsertData);

    if (!$result['success']) {
        jsonResponse([
            'success' => false,
            'message' => 'Failed to create booking: ' . ($result['error'] ?? 'Unknown error')
        ], 500);
    }

    $bookingId = $result['booking_id'];

    // Send confirmation email
    try {
        $emailHelper->sendBookingConfirmation([
            'email' => $bookingData['email'],
            'name' => $bookingData['fullname'] ?? $bookingData['name'] ?? '',
            'order_id' => $orderNumber,
            'service_type' => $serviceType,
            'price' => $finalPrice,
            'from_address' => $bookingData['from_address'] ?? '',
            'to_address' => $bookingData['to_address'] ?? '',
            'booking_date' => date('Y-m-d H:i:s')
        ]);
    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
        // Don't fail the booking if email fails, just log it
    }

    // Return success response
    jsonResponse([
        'success' => true,
        'message' => 'Booking created successfully',
        'order_id' => $orderNumber,
        'booking_id' => $bookingId,
        'total_price' => number_format($finalPrice, 2),
        'redirect_url' => '/book/booking-confirmation.php?order_id=' . $orderNumber
    ], 201);

} catch (Exception $e) {
    error_log("Booking submission error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    jsonResponse([
        'success' => false,
        'message' => 'An error occurred while processing your booking: ' . $e->getMessage()
    ], 500);
}

?>


