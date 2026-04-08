<?php
/**
 * Dynamic Booking Form Template
 * Displays service-specific form fields based on selected service type
 * Uses JavaScript to show/hide relevant fields
 */

// Load field configuration
$bookingFields = require_once '../config/booking-fields-config.php';
$services = array_keys($bookingFields);
$defaultService = $services[0] ?? 'parcel';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Service</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <style>
        .service-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .service-card {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .service-card:hover {
            border-color: #007bff;
            box-shadow: 0 2px 10px rgba(0, 123, 255, 0.2);
        }

        .service-card.active {
            border-color: #007bff;
            background-color: #f0f7ff;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .service-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #007bff;
        }

        .service-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .service-description {
            font-size: 0.85rem;
            color: #666;
        }

        .form-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .form-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .field-group {
            margin-bottom: 20px;
        }

        .field-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }

        .field-group input[type="text"],
        .field-group input[type="email"],
        .field-group input[type="tel"],
        .field-group input[type="number"],
        .field-group input[type="datetime-local"],
        .field-group select,
        .field-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            font-family: inherit;
        }

        .field-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .field-group input[type="checkbox"],
        .field-group input[type="radio"] {
            margin-right: 8px;
            cursor: pointer;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .checkbox-label input[type="checkbox"] {
            margin-bottom: 0;
        }

        .required::after {
            content: " *";
            color: #dc3545;
        }

        .form-group-title {
            border-top: 2px solid #f0f0f0;
            padding-top: 20px;
            margin-top: 20px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
        }

        .form-group-title:first-child {
            border-top: none;
            padding-top: 0;
            margin-top: 0;
        }

        .price-estimate {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .price-estimate-label {
            font-size: 0.9rem;
            color: #666;
        }

        .price-estimate-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #007bff;
        }

        .price-breakdown {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }

        .price-breakdown h5 {
            margin: 0 0 15px 0;
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.95rem;
        }

        .price-row:last-child {
            border-bottom: none;
        }

        .price-row.discount span:last-child {
            color: #28a745;
            font-weight: bold;
        }

        .price-row.total {
            padding: 12px 0;
            margin-top: 10px;
            border-top: 2px solid #dee2e6;
            font-weight: bold;
            font-size: 1.1rem;
            color: #007bff;
        }

        .total-amount {
            color: #007bff;
            font-size: 1.3rem;
        }

        .submit-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 12px 40px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .btn-submit:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .form-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #333;
        }

        .page-title p {
            color: #666;
            font-size: 1.1rem;
        }
    </style>
</head>
<body style="background-color: #f5f5f5; padding: 20px 0;">
    <div class="form-container">
        <!-- Page Title -->
        <div class="page-title">
            <h1>Book a Service</h1>
            <p>Select a service type to get started</p>
        </div>

        <!-- Service Selector -->
        <div class="service-selector" id="serviceSelector">
            <?php foreach ($bookingFields as $serviceType => $config): ?>
                <div class="service-card" data-service="<?php echo $serviceType; ?>">
                    <div class="service-icon">
                        <i class="<?php echo $config['icon']; ?>"></i>
                    </div>
                    <div class="service-name"><?php echo $config['service_name']; ?></div>
                    <div class="service-description"><?php echo $config['description']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Main Form -->
        <form id="bookingForm" method="POST" action="/book/submit.php">
            <!-- Hidden field to track selected service type -->
            <input type="hidden" id="serviceType" name="service_type" value="<?php echo $defaultService; ?>">

            <!-- Dynamic Form Sections -->
            <?php foreach ($bookingFields as $serviceType => $config): ?>
                <div class="form-section" data-service="<?php echo $serviceType; ?>">
                    <!-- Common Fields Section -->
                    <div class="form-group-title">
                        <i class="fas fa-user"></i> Your Information
                    </div>

                    <?php foreach ($config['common_fields'] as $fieldName => $fieldConfig): ?>
                        <?php echo renderFormField($fieldName, $fieldConfig); ?>
                    <?php endforeach; ?>

                    <!-- Service-Specific Fields Section -->
                    <?php if (!empty($config['service_fields'])): ?>
                        <div class="form-group-title">
                            <i class="fas fa-cube"></i> Booking Details
                        </div>

                        <?php foreach ($config['service_fields'] as $fieldName => $fieldConfig): ?>
                            <?php echo renderFormField($fieldName, $fieldConfig); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Price Estimate -->
                    <div class="price-estimate">
                        <div class="price-estimate-label">Estimated Price</div>
                        <div class="price-estimate-value" id="priceEstimate_<?php echo $serviceType; ?>">
                            Calculating...
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    <div class="field-group">
                        <label>Coupon Code (Optional)</label>
                        <input type="text" name="coupon_code" id="coupon_<?php echo $serviceType; ?>" placeholder="Enter coupon code if you have one">
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Submit Section -->
            <div class="submit-section">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check-circle"></i> Complete Booking
                </button>
                <button type="reset" class="btn-submit" style="background-color: #6c757d; margin-left: 10px;">
                    <i class="fas fa-redo"></i> Clear Form
                </button>
            </div>
        </form>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize: Show first service by default
            const initialService = '<?php echo $defaultService; ?>';
            selectService(initialService);

            // Service Card Click Handler
            $('.service-card').on('click', function () {
                const service = $(this).data('service');
                selectService(service);
            });

            // Service Selection Function
            function selectService(serviceType) {
                // Update hidden field
                $('#serviceType').val(serviceType);

                // Update visual selection
                $('.service-card').removeClass('active');
                $('.service-card[data-service="' + serviceType + '"]').addClass('active');

                // Show/Hide form sections
                $('.form-section').removeClass('active');
                $('.form-section[data-service="' + serviceType + '"]').addClass('active');

                // Scroll to form
                $('html, body').animate({
                    scrollTop: $('#bookingForm').offset().top - 50
                }, 500);

                // Trigger price calculation
                calculatePrice();
            }

            // Price Calculation (placeholder - will integrate with PricingEngine)
            function calculatePrice() {
                const serviceType = $('#serviceType').val();
                
                // This is a placeholder - will be connected to actual pricing engine
                // For now, show a loading state
                $('#priceEstimate_' + serviceType).text('$--');

                // In production, you would make an AJAX call here to calculate actual price
                // axios.post('/api/calculate-price', {
                //     service_type: serviceType,
                //     form_data: getFormData()
                // }).then(response => {
                //     $('#priceEstimate_' + serviceType).text('$' + response.data.price);
                // });
            }

            // Get Form Data for Current Service
            function getFormData() {
                const serviceType = $('#serviceType').val();
                const formData = new FormData($('#bookingForm')[0]);
                const data = {};
                
                formData.forEach((value, key) => {
                    if (data[key]) {
                        if (Array.isArray(data[key])) {
                            data[key].push(value);
                        } else {
                            data[key] = [data[key], value];
                        }
                    } else {
                        data[key] = value;
                    }
                });
                
                return data;
            }

            // Real-time price calculation
            function updatePrice() {
                const serviceType = $('#serviceType').val();
                if (!serviceType) return;
                
                const formData = new FormData();
                formData.append('service_type', serviceType);
                
                // Add key pricing fields
                formData.append('weight', $('[name="weight"]').val() || 0);
                formData.append('from_address', $('[name="from_address"]').val() || '');
                formData.append('to_address', $('[name="to_address"]').val() || '');
                formData.append('insurance', $('[name="insurance"]:checked').val() ? '1' : '0');
                
                // Service-specific fields
                formData.append('special_handling', $('[name="special_handling"]:checked').val() ? '1' : '0');
                formData.append('loading_assistance', $('[name="loading_assistance"]:checked').val() ? '1' : '0');
                formData.append('disassembly_required', $('[name="disassembly_required"]:checked').val() ? '1' : '0');
                formData.append('packing_required', $('[name="packing_required"]:checked').val() ? '1' : '0');
                formData.append('item_count', $('[name="item_count"]').val() || 1);
                formData.append('storage', $('[name="storage"]:checked').val() ? '1' : '0');
                formData.append('return_journey', $('[name="return_journey"]:checked').val() ? '1' : '0');
                formData.append('urgent', $('[name="urgent"]:checked').val() ? '1' : '0');
                formData.append('coupon_code', $('[name="coupon_code"]').val() || '');
                
                $.ajax({
                    url: '/api/calculate-price.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            updatePriceDisplay(response);
                        }
                    }
                });
            }
            
            function updatePriceDisplay(pricing) {
                const $priceBox = $('#priceEstimate');
                let html = '<div class="price-breakdown"><h5>Price Breakdown</h5>';
                html += '<div class="price-row"><span>Base Price:</span><span>$' + pricing.base_price.toFixed(2) + '</span></div>';
                
                if (Object.keys(pricing.modifiers).length > 0) {
                    for (const [key, value] of Object.entries(pricing.modifiers)) {
                        const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        html += '<div class="price-row"><span>' + label + ':</span><span>+$' + parseFloat(value).toFixed(2) + '</span></div>';
                    }
                }
                
                if (pricing.coupon_discount > 0) {
                    html += '<div class="price-row discount"><span>Coupon Discount:</span><span>-$' + pricing.coupon_discount.toFixed(2) + '</span></div>';
                }
                
                html += '<div class="price-row total"><span>Total Price:</span><span class="total-amount">$' + pricing.total_price.toFixed(2) + '</span></div></div>';
                
                $priceBox.html(html);
            }
            
            // Update price on relevant field changes
            $(document).on('change input', 
                '[name="weight"], [name="from_address"], [name="to_address"], ' +
                '[name="insurance"], [name="special_handling"], [name="loading_assistance"], ' +
                '[name="disassembly_required"], [name="packing_required"], [name="item_count"], ' +
                '[name="storage"], [name="return_journey"], [name="urgent"], [name="coupon_code"]',
                function() {
                    updatePrice();
                }
            );

            // Form Submission
            $('#bookingForm').on('submit', function (e) {
                e.preventDefault();

                const serviceType = $('#serviceType').val();
                const formData = new FormData(this);
                formData.append('service_type', serviceType);

                // Validate required fields
                let isValid = true;
                $('.form-section.active input[required], .form-section.active select[required], .form-section.active textarea[required]').each(function () {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    alert('Please fill in all required fields.');
                    return;
                }

                // Submit form
                const $submit = $(this).find('button[type="submit"]');
                const originalText = $submit.text();
                $submit.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: '/book/submit.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert('Booking confirmed! Order #: ' + response.order_id);
                            window.location.href = '/book/booking-confirmation.php?order_id=' + response.order_id;
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function () {
                        alert('Error submitting booking. Please try again.');
                    },
                    complete: function() {
                        $submit.prop('disabled', false).text(originalText);
                    }
                });
            });

            // Real-time field validation
            $('input[required], select[required], textarea[required]').on('change', function () {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>
</html>

<?php
/**
 * Render Form Field Helper Function
 * Generates appropriate HTML for different field types
 */
function renderFormField($fieldName, $fieldConfig)
{
    $id = $fieldName;
    $label = $fieldConfig['label'] ?? ucfirst($fieldName);
    $required = $fieldConfig['required'] ? 'required' : '';
    $type = $fieldConfig['type'] ?? 'text';

    $html = '<div class="field-group">';
    $html .= '<label for="' . $id . '" class="' . ($fieldConfig['required'] ? 'required' : '') . '">' . $label . '</label>';

    switch ($type) {
        case 'text':
        case 'email':
        case 'tel':
        case 'number':
        case 'datetime-local':
            $placeholder = isset($fieldConfig['placeholder']) ? 'placeholder="' . $fieldConfig['placeholder'] . '"' : '';
            $min = isset($fieldConfig['min']) ? 'min="' . $fieldConfig['min'] . '"' : '';
            $max = isset($fieldConfig['max']) ? 'max="' . $fieldConfig['max'] . '"' : '';
            $step = isset($fieldConfig['step']) ? 'step="' . $fieldConfig['step'] . '"' : '';
            $html .= '<input type="' . $type . '" id="' . $id . '" name="' . $id . '" ' . $placeholder . ' ' . $min . ' ' . $max . ' ' . $step . ' ' . $required . '>';
            break;

        case 'textarea':
            $placeholder = isset($fieldConfig['placeholder']) ? 'placeholder="' . $fieldConfig['placeholder'] . '"' : '';
            $html .= '<textarea id="' . $id . '" name="' . $id . '" ' . $placeholder . ' ' . $required . '></textarea>';
            break;

        case 'select':
            $html .= '<select id="' . $id . '" name="' . $id . '" ' . $required . '>';
            $html .= '<option value="">-- Select ' . strtolower($label) . ' --</option>';
            if (isset($fieldConfig['options']) && is_array($fieldConfig['options'])) {
                foreach ($fieldConfig['options'] as $value => $optionLabel) {
                    $html .= '<option value="' . $value . '">' . $optionLabel . '</option>';
                }
            }
            $html .= '</select>';
            break;

        case 'checkbox':
            $html = '<div class="field-group">';
            $html .= '<label class="checkbox-label">';
            $html .= '<input type="checkbox" id="' . $id . '" name="' . $id . '" value="1">';
            $html .= '<span>' . $label . '</span>';
            $html .= '</label>';
            $html .= '</div>';
            return $html;

        case 'radio':
            $html = '<div class="field-group">';
            if (isset($fieldConfig['options']) && is_array($fieldConfig['options'])) {
                foreach ($fieldConfig['options'] as $value => $optionLabel) {
                    $html .= '<label class="checkbox-label">';
                    $html .= '<input type="radio" name="' . $id . '" value="' . $value . '" ' . $required . '>';
                    $html .= '<span>' . $optionLabel . '</span>';
                    $html .= '</label>';
                }
            }
            $html .= '</div>';
            return $html;
    }

    $html .= '</div>';
    return $html;
}
?>


