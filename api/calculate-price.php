<?php
/**
 * Price Calculation API
 * Calculates booking price based on service type and form data
 * Used for real-time price estimates in the booking form
 */

require_once '../../config/bootstrap.php';

header('Content-Type: application/json');

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $serviceType = $_POST['service_type'] ?? null;
    
    if (!$serviceType) {
        http_response_code(400);
        echo json_encode(['error' => 'Service type is required']);
        exit;
    }

    // Initialize pricing engine
    $pricingEngine = new PricingEngine($DB, $CONFIG);

    // Get pricing factors from configuration
    $bookingFields = require_once dirname(__DIR__) . '/config/booking-fields-config.php';
    
    if (!isset($bookingFields[$serviceType])) {
        http_response_code(404);
        echo json_encode(['error' => 'Service type not found']);
        exit;
    }

    $config = $bookingFields[$serviceType];
    $pricingFactors = $config['pricing_factors'] ?? [];

    // Calculate base price
    $weight = $_POST['weight'] ?? 0;
    $fromAddress = $_POST['from_address'] ?? '';
    $toAddress = $_POST['to_address'] ?? '';
    $includeInsurance = isset($_POST['insurance']) && $_POST['insurance'] == '1';

    $basePrice = $pricingEngine->calculateBookingPrice(
        $serviceType,
        (float)$weight,
        $fromAddress,
        $toAddress,
        $includeInsurance,
        'USD'
    );

    // Apply modifiers based on service-specific factors
    $totalPrice = $basePrice;
    $modifiers = [];

    // Service-specific price modifiers
    switch ($serviceType) {
        case 'freight':
            if (isset($_POST['special_handling']) && $_POST['special_handling'] == '1') {
                $specialHandlingCharge = $basePrice * 0.15; // 15% extra for special handling
                $totalPrice += $specialHandlingCharge;
                $modifiers['special_handling'] = $specialHandlingCharge;
            }
            if (isset($_POST['loading_assistance']) && $_POST['loading_assistance'] == '1') {
                $loadingCharge = 50; // Fixed charge for loading assistance
                $totalPrice += $loadingCharge;
                $modifiers['loading_assistance'] = $loadingCharge;
            }
            break;

        case 'furniture':
            if (isset($_POST['disassembly_required']) && $_POST['disassembly_required'] == '1') {
                $itemCount = (int)($_POST['item_count'] ?? 1);
                $disassemblyCharge = 25 * $itemCount; // $25 per item for disassembly
                $totalPrice += $disassemblyCharge;
                $modifiers['disassembly'] = $disassemblyCharge;
            }
            if (isset($_POST['packing_required']) && $_POST['packing_required'] == '1') {
                $packingCharge = 30; // Fixed charge for packing materials
                $totalPrice += $packingCharge;
                $modifiers['packing'] = $packingCharge;
            }
            if (isset($_POST['storage']) && $_POST['storage'] == '1') {
                $storageCharge = 15; // Base storage charge
                $totalPrice += $storageCharge;
                $modifiers['storage'] = $storageCharge;
            }
            break;

        case 'taxi':
            if (isset($_POST['return_journey']) && $_POST['return_journey'] == '1') {
                // Double the price for return journey
                $totalPrice *= 1.5; // 50% additional for return
                $modifiers['return_journey'] = $totalPrice - $basePrice;
            }
            break;

        case 'towtruck':
            if (isset($_POST['urgent']) && $_POST['urgent'] == '1') {
                $urgencyCharge = $basePrice * 0.25; // 25% extra for urgent service
                $totalPrice += $urgencyCharge;
                $modifiers['urgency'] = $urgencyCharge;
            }
            break;
    }

    // Insurance charge (if not already included in base price)
    if ($includeInsurance && $serviceType !== 'taxi') {
        $insuranceCharge = $basePrice * 0.05; // 5% insurance
        $totalPrice += $insuranceCharge;
        $modifiers['insurance'] = $insuranceCharge;
    }

    // Apply coupon discount if provided
    $couponDiscount = 0;
    if (!empty($_POST['coupon_code'])) {
        $bookingProcessor = new BookingProcessor($DB, $CONFIG);
        $userId = $_SESSION['user_id'] ?? null;
        
        $couponResult = $bookingProcessor->validateAndApplyCoupon(
            $_POST['coupon_code'],
            $userId
        );
        
        if ($couponResult) {
            $couponDiscount = $couponResult['discount'] ?? 0;
            $totalPrice = max(0, $totalPrice - $couponDiscount);
        }
    }

    // Return pricing breakdown
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'service_type' => $serviceType,
        'base_price' => round($basePrice, 2),
        'modifiers' => $modifiers,
        'coupon_discount' => round($couponDiscount, 2),
        'total_price' => round($totalPrice, 2),
        'currency' => 'USD',
        'breakdown' => [
            'base' => round($basePrice, 2),
            'modifiers_total' => round(array_sum($modifiers), 2),
            'discount' => round($couponDiscount, 2),
            'final' => round($totalPrice, 2)
        ]
    ]);

} catch (Exception $e) {
    error_log("Price calculation error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error calculating price: ' . $e->getMessage()
    ]);
}

?>


