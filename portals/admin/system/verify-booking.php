<?php
/**
 * Dynamic Booking System Verification Script
 * Checks all components and generates a detailed report
 * 
 * Usage: Open in browser at /verify-booking-system.php
 * Or run from command line: php verify-booking-system.php
 */

$verification = [];
$errors = [];
$warnings = [];

// Color codes for terminal output
$colors = [
    'green' => "\033[92m",
    'red' => "\033[91m",
    'yellow' => "\033[93m",
    'blue' => "\033[94m",
    'reset' => "\033[0m"
];

// Check if running in CLI or web
$isCLI = php_sapi_name() === 'cli';

function report($status, $message, $details = '') {
    global $isCLI, $colors;
    
    if ($isCLI) {
        $icon = $status === 'OK' ? '✓' : ($status === 'WARN' ? '⚠' : '✗');
        $color = $status === 'OK' ? $colors['green'] : ($status === 'WARN' ? $colors['yellow'] : $colors['red']);
        echo $color . "[$icon] " . $message . $colors['reset'];
        if ($details) echo " - " . $details;
        echo "\n";
    } else {
        $icon = $status === 'OK' ? '✓' : ($status === 'WARN' ? '⚠' : '✗');
        $class = strtolower($status);
        echo "<div class='check $class'><span class='icon'>$icon</span> <span class='message'>$message</span>";
        if ($details) echo "<span class='details'> - $details</span>";
        echo "</div>\n";
    }
}

// Get base path
$basePath = dirname(__FILE__);

echo "\n";
if (!$isCLI) {
    echo "<style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .check { padding: 12px; margin: 8px 0; border-radius: 5px; border-left: 4px solid #ccc; }
        .check.ok { background-color: #d4edda; border-left-color: #28a745; }
        .check.error { background-color: #f8d7da; border-left-color: #dc3545; }
        .check.warn { background-color: #fff3cd; border-left-color: #ffc107; }
        .icon { font-weight: bold; margin-right: 10px; }
        .message { font-weight: bold; }
        .details { color: #666; font-size: 0.9em; margin-left: 10px; }
        .section { margin-top: 30px; }
        .section-title { font-size: 1.2em; font-weight: bold; color: #007bff; margin: 20px 0 10px 0; }
        .summary { background: #f0f0f0; padding: 15px; border-radius: 5px; margin-top: 20px; }
        .status-ok { color: #28a745; }
        .status-error { color: #dc3545; }
        .status-warn { color: #ffc107; }
    </style>";
    echo "<div class='container'>\n";
    echo "<h1><i class='icon'>⚙️</i> Dynamic Booking System Verification</h1>\n";
}

// Load config safely
report('INFO', 'Loading configuration...');
$configPath = $basePath . '/config/bootstrap.php';
if (file_exists($configPath)) {
    report('OK', 'Bootstrap file found', $configPath);
    try {
        require_once $configPath;
        report('OK', 'Bootstrap loaded successfully');
    } catch (Exception $e) {
        report('ERROR', 'Failed to load bootstrap', $e->getMessage());
        $errors[] = 'Bootstrap configuration failed';
    }
} else {
    report('ERROR', 'Bootstrap not found', $configPath);
    $errors[] = 'Missing bootstrap.php';
}

// =======================
// 1. Check File Structure
// =======================
echo "\n\n" . ($isCLI ? "=== FILE STRUCTURE ===" : "<div class='section'><div class='section-title'>File Structure</div>") . "\n";

$requiredFiles = [
    'config/booking-fields-config.php' => 'Booking field configuration',
    'config/bootstrap.php' => 'Bootstrap configuration',
    'templates/booking-form.php' => 'Dynamic booking form',
    'templates/booking-confirmation.php' => 'Booking confirmation page',
    'app/classes/BookingProcessor.php' => 'Booking processor class',
    'book/submit.php' => 'Booking submission handler',
    'api/booking-fields.php' => 'Booking fields API endpoint',
    'api/calculate-price.php' => 'Price calculation API',
    'admin/bookings.php' => 'Admin booking management',
];

foreach ($requiredFiles as $file => $description) {
    $fullPath = $basePath . '/' . $file;
    if (file_exists($fullPath)) {
        $size = filesize($fullPath);
        report('OK', "$description", "$file ($size bytes)");
    } else {
        report('ERROR', "Missing $description", $file);
        $errors[] = "Missing file: $file";
    }
}

// =======================
// 2. Check Field Configuration
// =======================
echo "\n\n" . ($isCLI ? "=== FIELD CONFIGURATION ===" : "<div class='section'><div class='section-title'>Field Configuration</div>") . "\n";

$configPath = $basePath . '/config/booking-fields-config.php';
if (file_exists($configPath)) {
    $fieldConfig = require_once $configPath;
    
    $expectedServices = ['parcel', 'freight', 'furniture', 'taxi', 'towtruck'];
    
    foreach ($expectedServices as $service) {
        if (isset($fieldConfig[$service])) {
            $config = $fieldConfig[$service];
            $commonFields = count($config['common_fields'] ?? []);
            $serviceFields = count($config['service_fields'] ?? []);
            $totalFields = $commonFields + $serviceFields;
            
            report('OK', "Service type: $service", "$totalFields fields ($commonFields common, $serviceFields specific)");
        } else {
            report('WARN', "Missing service type", $service);
            $warnings[] = "Service type not configured: $service";
        }
    }
    
    if (count($fieldConfig) === count($expectedServices)) {
        report('OK', 'All expected services configured', count($fieldConfig) . ' services');
    } else {
        report('WARN', 'Service configuration mismatch', count($fieldConfig) . ' found, ' . count($expectedServices) . ' expected');
    }
} else {
    report('ERROR', 'Field configuration not found');
    $errors[] = 'Missing booking-fields-config.php';
}

// =======================
// 3. Check Class Methods
// =======================
echo "\n\n" . ($isCLI ? "=== CLASS METHODS ===" : "<div class='section'><div class='section-title'>Class Methods</div>") . "\n";

$classPath = $basePath . '/app/classes/BookingProcessor.php';
if (file_exists($classPath)) {
    $classContent = file_get_contents($classPath);
    
    $requiredMethods = [
        'validateBookingData' => 'Service-aware validation',
        'getServiceConfig' => 'Get service configuration',
        'getServiceFields' => 'Get service fields',
        'getBookingByOrderId' => 'Retrieve booking by order ID',
        'updateBookingStatus' => 'Update booking status',
        'validateAndApplyCoupon' => 'Coupon validation'
    ];
    
    foreach ($requiredMethods as $method => $description) {
        if (strpos($classContent, "function $method") !== false || strpos($classContent, "public function $method") !== false) {
            report('OK', "Method exists: $method", $description);
        } else {
            report('WARN', "Method not found: $method", $description);
            $warnings[] = "Missing method: $method";
        }
    }
} else {
    report('ERROR', 'BookingProcessor class not found');
    $errors[] = 'Missing BookingProcessor.php';
}

// =======================
// 4. Check Form Features
// =======================
echo "\n\n" . ($isCLI ? "=== FORM FEATURES ===" : "<div class='section'><div class='section-title'>Form Features</div>") . "\n";

$formPath = $basePath . '/templates/booking-form.php';
if (file_exists($formPath)) {
    $formContent = file_get_contents($formPath);
    
    $requiredFeatures = [
        'updatePrice' => 'Real-time price calculation',
        'validateForm' => 'Client-side validation',
        'serviceType' => 'Service type selector',
        'form-section' => 'Dynamic form sections',
        'calculateBookingPrice' => 'Price calculation',
        'AJAX' => 'AJAX form submission'
    ];
    
    foreach ($requiredFeatures as $feature => $description) {
        if (strpos($formContent, $feature) !== false) {
            report('OK', $description, "Feature found in form");
        } else {
            report('WARN', $description, "Feature may be missing");
            $warnings[] = "Feature may be missing: $description";
        }
    }
} else {
    report('ERROR', 'Booking form not found');
    $errors[] = 'Missing booking-form.php';
}

// =======================
// 5. Check API Endpoints
// =======================
echo "\n\n" . ($isCLI ? "=== API ENDPOINTS ===" : "<div class='section'><div class='section-title'>API Endpoints</div>") . "\n";

$apis = [
    '/api/booking-fields.php' => 'Field definitions endpoint',
    '/api/calculate-price.php' => 'Price calculation endpoint'
];

foreach ($apis as $endpoint => $description) {
    $apiPath = $basePath . $endpoint;
    if (file_exists($apiPath)) {
        $apiContent = file_get_contents($apiPath);
        if (strpos($apiContent, 'json_encode') !== false) {
            report('OK', $description, "Endpoint: $endpoint");
        } else {
            report('WARN', $description, "May not return JSON");
        }
    } else {
        report('ERROR', "Missing $description", $endpoint);
        $errors[] = "Missing API endpoint: $endpoint";
    }
}

// =======================
// 6. Check Database Tables
// =======================
echo "\n\n" . ($isCLI ? "=== DATABASE TABLES ===" : "<div class='section'><div class='section-title'>Database Tables</div>") . "\n";

try {
    if (isset($DB)) {
        // Check bookings table
        $result = $DB->query("SELECT 1 FROM bookings LIMIT 1");
        report('OK', 'Bookings table exists', 'Table is accessible');
        
        // Get table structure
        $columns = $DB->query("DESCRIBE bookings")->fetchAll();
        $columnNames = array_map(function($col) { return $col['Field']; }, $columns);
        
        $requiredColumns = ['booking_id', 'order_id', 'service_type', 'booking_data', 'total_price', 'status'];
        $missingColumns = array_diff($requiredColumns, $columnNames);
        
        if (empty($missingColumns)) {
            report('OK', 'All required columns present', count($columnNames) . ' columns found');
        } else {
            report('WARN', 'Missing columns', implode(', ', $missingColumns));
            $warnings[] = 'Database columns missing: ' . implode(', ', $missingColumns);
        }
    } else {
        report('WARN', 'Database not initialized', 'Cannot check tables');
    }
} catch (Exception $e) {
    report('WARN', 'Cannot verify database', $e->getMessage());
    $warnings[] = 'Database verification failed: ' . $e->getMessage();
}

// =======================
// 7. Check Configuration
// =======================
echo "\n\n" . ($isCLI ? "=== CONFIGURATION ===" : "<div class='section'><div class='section-title'>Configuration</div>") . "\n";

if (isset($CONFIG)) {
    report('OK', 'Configuration loaded', 'CONFIG array exists');
    
    if (isset($CONFIG['db_host'])) report('OK', 'Database host configured');
    if (isset($CONFIG['db_name'])) report('OK', 'Database name configured');
    if (isset($CONFIG['currency'])) report('OK', 'Currency configured', $CONFIG['currency']);
    if (isset($CONFIG['timezone'])) report('OK', 'Timezone configured', $CONFIG['timezone']);
} else {
    report('WARN', 'Configuration not loaded', 'CONFIG variable not found');
}

// =======================
// Summary
// =======================
echo "\n\n";
if (!$isCLI) {
    echo "<div class='section'><div class='section-title'>Verification Summary</div>";
    echo "<div class='summary'>\n";
}

$errorCount = count($errors);
$warningCount = count($warnings);
$statusClass = $errorCount > 0 ? 'status-error' : ($warningCount > 0 ? 'status-warn' : 'status-ok');
$status = $errorCount > 0 ? 'ERRORS FOUND' : ($warningCount > 0 ? 'WARNINGS' : 'ALL SYSTEMS GO');

echo "Status: <span class='$statusClass'><strong>$status</strong></span>\n";
echo "Errors: <strong>$errorCount</strong>\n";
echo "Warnings: <strong>$warningCount</strong>\n";

if ($errorCount > 0) {
    echo "\nErrors:\n";
    foreach ($errors as $error) {
        echo "  • $error\n";
    }
}

if ($warningCount > 0) {
    echo "\nWarnings:\n";
    foreach ($warnings as $warning) {
        echo "  • $warning\n";
    }
}

echo "\nRecommendations:\n";
echo "  1. Verify all files are in correct directories\n";
echo "  2. Check database migrations have been run\n";
echo "  3. Test form submission with valid data\n";
echo "  4. Verify price calculation API returns correct values\n";
echo "  5. Test confirmation page displays booking details\n";
echo "  6. Check admin panel can view and filter bookings\n";

if (!$isCLI) {
    echo "</div></div>\n</div>";
}

echo "\n";

?>


