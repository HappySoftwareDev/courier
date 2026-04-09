<?php 
/**
 * Unified Booking Portal
 * Handles all service types: Parcel, Freight, Furniture, Taxi, Tow Truck
 * Routes to unified form handling via book/submit.php
 */

require_once 'signin-security.php';
require_once '../../config/bootstrap.php';

// Load legacy site settings for compatibility
if (file_exists('../admin/pages/site_settings.php')) {
    include('../admin/pages/site_settings.php');
}

// Determine which service to display
$service = $_GET['service'] ?? 'parcel';
$allowedServices = ['parcel', 'freight', 'furniture', 'taxi', 'towtruck'];

if (!in_array($service, $allowedServices)) {
    $service = 'parcel';
}

// Service metadata
$serviceMetadata = [
    'parcel' => [
        'title' => 'Parcel Delivery',
        'description' => 'Fast and reliable parcel delivery service',
        'icon' => 'lni-briefcase',
        'fields' => ['recipient_name', 'recipient_phone', 'recipient_address', 'weight', 'description']
    ],
    'freight' => [
        'title' => 'Freight Shipping',
        'description' => 'Heavy cargo and freight transportation',
        'icon' => 'lni-delivery',
        'fields' => ['recipient_name', 'recipient_phone', 'recipient_address', 'weight', 'dimensions', 'description']
    ],
    'furniture' => [
        'title' => 'Furniture Moving',
        'description' => 'Professional furniture relocation service',
        'icon' => 'lni-archive',
        'fields' => ['recipient_name', 'recipient_phone', 'recipient_address', 'items_count', 'description']
    ],
    'taxi' => [
        'title' => 'Taxi Service',
        'description' => 'Quick taxi booking and delivery',
        'icon' => 'lni-car',
        'fields' => ['passenger_name', 'passenger_phone', 'destination', 'passengers']
    ],
    'towtruck' => [
        'title' => 'Tow Truck Service',
        'description' => 'Vehicle towing and breakdown service',
        'icon' => 'lni-truck',
        'fields' => ['vehicle_details', 'location', 'destination', 'reason']
    ]
];

$current = $serviceMetadata[$service];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <title><?php echo $current['title']; ?> Booking | <?php echo APP_NAME; ?></title>
    <style>
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .service-card {
            padding: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        .service-card:hover, .service-card.active {
            border-color: #007bff;
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.15);
        }
        .service-card.active {
            border-color: #007bff;
            background-color: #e7f1ff;
        }
        .service-icon {
            font-size: 32px;
            margin-bottom: 10px;
            color: #007bff;
        }
        .booking-form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .form-section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }
    </style>
</head>
<body class="customer-portal">
    
    <?php include 'header.php'; ?>
    
    <main class="main-wrapper">
        <section class="section">
            <div class="container">
                <!-- Page Header -->
                <div class="page-header mb-40">
                    <h1><?php echo $current['title']; ?></h1>
                    <p class="text-muted"><?php echo $current['description']; ?></p>
                </div>

                <!-- Service Selection Grid -->
                <div class="service-grid mb-30">
                    <?php foreach ($serviceMetadata as $svc => $meta): ?>
                    <a href="?service=<?php echo $svc; ?>" class="service-card <?php echo $svc === $service ? 'active' : ''; ?>">
                        <div class="service-icon">
                            <i class="lni <?php echo $meta['icon']; ?>"></i>
                        </div>
                        <h4><?php echo $meta['title']; ?></h4>
                    </a>
                    <?php endforeach; ?>
                </div>

                <!-- Unified Booking Form -->
                <div class="booking-form">
                    <form method="POST" action="submit.php" id="bookingForm" class="needs-validation" novalidate>
                        
                        <!-- Hidden service type -->
                        <input type="hidden" name="service_type" value="<?php echo $service; ?>">

                        <!-- CSRF Token -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

                        <!-- Sender/Origin Information -->
                        <div class="form-section">
                            <h3 class="section-title">From (Pickup Details)</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="origin_city" class="form-label">Origin City *</label>
                                    <input type="text" class="form-control" id="origin_city" name="origin_city" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="origin_address" class="form-label">Address *</label>
                                    <input type="text" class="form-control" id="origin_address" name="origin_address" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sender_name" class="form-label">Your Name *</label>
                                    <input type="text" class="form-control" id="sender_name" name="sender_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sender_phone" class="form-label">Your Phone *</label>
                                    <input type="tel" class="form-control" id="sender_phone" name="sender_phone" required>
                                </div>
                            </div>
                        </div>

                        <!-- Recipient/Destination Information -->
                        <div class="form-section">
                            <h3 class="section-title">To (Delivery Details)</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="destination_city" class="form-label">Destination City *</label>
                                    <input type="text" class="form-control" id="destination_city" name="destination_city" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="destination_address" class="form-label">Address *</label>
                                    <input type="text" class="form-control" id="destination_address" name="destination_address" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="recipient_name" class="form-label">Recipient Name *</label>
                                    <input type="text" class="form-control" id="recipient_name" name="recipient_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="recipient_phone" class="form-label">Recipient Phone *</label>
                                    <input type="tel" class="form-control" id="recipient_phone" name="recipient_phone" required>
                                </div>
                            </div>
                        </div>

                        <!-- Item Details -->
                        <div class="form-section" id="itemDetails">
                            <h3 class="section-title">Item Details</h3>
                            <div class="row">
                                <div class="col-md-4 mb-3" id="weightField">
                                    <label for="weight" class="form-label">Weight (kg) *</label>
                                    <input type="number" class="form-control" id="weight" name="weight" step="0.1" required>
                                </div>
                                <div class="col-md-4 mb-3" id="dimensionsField" style="display:none;">
                                    <label for="dimensions" class="form-label">Dimensions (L×W×H)</label>
                                    <input type="text" class="form-control" id="dimensions" name="dimensions" placeholder="e.g., 50x40x30">
                                </div>
                                <div class="col-md-4 mb-3" id="itemsCountField" style="display:none;">
                                    <label for="items_count" class="form-label">Number of Items</label>
                                    <input type="number" class="form-control" id="items_count" name="items_count" min="1">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">Description of Items *</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Payment -->
                        <div class="form-section">
                            <h3 class="section-title">Pricing & Payment</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="coupon" class="form-label">Coupon Code (Optional)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="coupon" name="coupon" placeholder="Enter coupon code">
                                        <button class="btn btn-outline-secondary" type="button" id="applyCoupon">Apply</button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Estimated Price</label>
                                    <div class="alert alert-info">
                                        <h4 id="totalPrice">ZWL 0.00</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="payment_method" class="form-label">Payment Method *</label>
                                    <select class="form-control" id="payment_method" name="payment_method" required>
                                        <option value="">-- Select Payment Method --</option>
                                        <option value="paynow">PayNow</option>
                                        <option value="stripe">Stripe</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="cash">Cash on Delivery</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Special Instructions -->
                        <div class="form-section">
                            <h3 class="section-title">Special Instructions (Optional)</h3>
                            <textarea class="form-control" name="special_instructions" rows="3" placeholder="Any special instructions or notes..."></textarea>
                        </div>

                        <!-- Agreement & Submit -->
                        <div class="form-section">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="agreeTerms" name="agree_terms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the <a href="/terms.php" target="_blank">Terms and Conditions</a> and <a href="/privacy.php" target="_blank">Privacy Policy</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Book Now</button>
                            <a href="/" class="btn btn-secondary btn-lg">Cancel</a>
                        </div>

                    </form>
                </div>

            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <?php include 'footerscripts.php'; ?>

    <script>
        // Show/hide fields based on service type
        document.addEventListener('DOMContentLoaded', function() {
            const service = '<?php echo $service; ?>';
            
            // Show/hide service-specific fields
            if (service === 'furniture') {
                document.getElementById('itemsCountField').style.display = 'block';
                document.getElementById('weightField').style.display = 'none';
            } else if (service === 'freight') {
                document.getElementById('dimensionsField').style.display = 'block';
            }
            
            // Calculate price on change
            document.getElementById('weight').addEventListener('change', calculatePrice);
            document.getElementById('origin_city').addEventListener('change', calculatePrice);
            document.getElementById('destination_city').addEventListener('change', calculatePrice);
            
            // Apply coupon
            document.getElementById('applyCoupon').addEventListener('click', applyCoupon);
        });

        function calculatePrice() {
            const weight = parseFloat(document.getElementById('weight').value) || 0;
            const origin = document.getElementById('origin_city').value;
            const destination = document.getElementById('destination_city').value;
            const service = '<?php echo $service; ?>';

            if (origin && destination && weight > 0) {
                // Make AJAX call to pricing API
                fetch('/api/calculate-price.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        service_type: service,
                        origin_city: origin,
                        destination_city: destination,
                        weight: weight
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('totalPrice').textContent = 'ZWL ' + parseFloat(data.total).toFixed(2);
                    }
                })
                .catch(error => console.error('Price calculation error:', error));
            }
        }

        function applyCoupon() {
            const coupon = document.getElementById('coupon').value;
            if (!coupon) {
                alert('Please enter a coupon code');
                return;
            }

            fetch('/api/validate-coupon.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({coupon: coupon})
            })
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    alert('Coupon applied! Discount: ' + data.discount + '%');
                    calculatePrice();
                } else {
                    alert('Invalid coupon code');
                }
            })
            .catch(error => console.error('Coupon error:', error));
        }

        // Form validation
        (function() {
            'use strict';
            const form = document.getElementById('bookingForm');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>

</body>
</html>


