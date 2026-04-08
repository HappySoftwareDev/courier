<?php
/**
 * Admin Pricing & Currency Settings
 * Manage pricing, currencies, and country settings
 */

session_start();

// Check admin access
if (!isset($_SESSION['admin_id']) && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')) {
    header('Location: /login.php');
    exit;
}

require_once dirname(__DIR__) . '/config/bootstrap.php';

$countryManager = new CountryManager();
$currencyManager = new CurrencyExchangeManager($DB);
$message = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'update_base_settings':
                // Update base country and currency
                $baseCountry = $_POST['base_country'] ?? 'US';
                $baseCurrency = $_POST['base_currency'] ?? 'USD';
                
                // Validate country exists
                if (!$countryManager->getCountry($baseCountry)) {
                    throw new Exception('Invalid country selected');
                }

                // Update config
                $CONFIG->set('base_country', $baseCountry);
                $CONFIG->set('base_currency', $baseCurrency);
                
                // Auto-set timezone from country
                $countryData = $countryManager->getCountry($baseCountry);
                $CONFIG->set('timezone', $countryData['timezone']);
                
                $message = "Base country and currency updated successfully!";
                break;

            case 'update_service_pricing':
                // Update pricing for each service type
                $serviceTypes = ['parcel', 'freight', 'furniture', 'taxi', 'towtruck'];
                
                foreach ($serviceTypes as $type) {
                    if (isset($_POST["{$type}_base_price"])) {
                        $CONFIG->set("{$type}_base_price", (float)$_POST["{$type}_base_price"]);
                    }
                    if (isset($_POST["{$type}_distance_rate"])) {
                        $CONFIG->set("{$type}_distance_rate", (float)$_POST["{$type}_distance_rate"]);
                    }
                    if (isset($_POST["{$type}_weight_rate"])) {
                        $CONFIG->set("{$type}_weight_rate", (float)$_POST["{$type}_weight_rate"]);
                    }
                }
                
                // General charges
                if (isset($_POST['insurance_percentage'])) {
                    $CONFIG->set('insurance_percentage', (float)$_POST['insurance_percentage']);
                }
                if (isset($_POST['platform_fee_percentage'])) {
                    $CONFIG->set('platform_fee_percentage', (float)$_POST['platform_fee_percentage']);
                }
                
                $message = "Service pricing updated successfully!";
                break;

            case 'update_currency_settings':
                // Update currency settings
                $CONFIG->set('allow_currency_selection', isset($_POST['allow_currency_selection']) ? 'true' : 'false');
                
                // Build currency list from selected checkboxes
                $selectedCurrencies = [];
                if (isset($_POST['selected_currencies'])) {
                    $selectedCurrencies = (array)$_POST['selected_currencies'];
                }
                $CONFIG->set('currency_list', json_encode($selectedCurrencies));
                
                $message = "Currency settings updated successfully!";
                break;
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Get current settings
$baseCurrency = $CONFIG->get('base_currency', 'USD');
$baseCountry = $CONFIG->get('base_country', 'US');
$allowCurrencySelection = $CONFIG->get('allow_currency_selection', 'true') === 'true';
$currencyList = json_decode($CONFIG->get('currency_list', '["USD"]'), true);

// Get all service pricing
$parcelPrice = [
    'base' => $CONFIG->get('parcel_base_price', 5.00),
    'distance' => $CONFIG->get('parcel_distance_rate', 2.50),
    'weight' => $CONFIG->get('parcel_weight_rate', 0.50),
];

$freightPrice = [
    'base' => $CONFIG->get('freight_base_price', 25.00),
    'distance' => $CONFIG->get('freight_distance_rate', 5.00),
    'weight' => $CONFIG->get('freight_weight_rate', 2.00),
];

$furniturePrice = [
    'base' => $CONFIG->get('furniture_base_price', 50.00),
    'distance' => $CONFIG->get('furniture_distance_rate', 10.00),
    'weight' => $CONFIG->get('furniture_weight_rate', 3.00),
];

$insurance = $CONFIG->get('insurance_percentage', 5.00);
$platformFee = $CONFIG->get('platform_fee_percentage', 15.00);

$countries = $countryManager->getCountriesForSelect();
$allCurrencies = $currencyManager->getAllCurrencies();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing & Currency Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f5f5f5; }
        .settings-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 30px; }
        .section-title { font-size: 1.5rem; font-weight: bold; margin-bottom: 20px; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .currency-badge { display: inline-block; background: #007bff; color: white; padding: 5px 10px; border-radius: 20px; margin: 5px; }
        .exchange-rate { font-size: 0.9rem; color: #666; margin-top: 5px; }
        .service-pricing-row { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .pricing-input { padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        .alert { margin-bottom: 20px; }
        .country-selector { max-width: 500px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">💰 Pricing & Currency Management</h1>

    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Base Settings Card -->
    <div class="settings-card">
        <h2 class="section-title">🌍 Base Country & Currency</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update_base_settings">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Country of Operation</strong></label>
                        <select name="base_country" class="form-control" required>
                            <?php foreach ($countries as $code => $name): ?>
                                <option value="<?php echo $code; ?>" <?php echo $baseCountry === $code ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Affects timezone and default currency</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label"><strong>Base Currency</strong></label>
                        <select name="base_currency" class="form-control" required>
                            <?php foreach ($allCurrencies as $code => $info): ?>
                                <option value="<?php echo $code; ?>" <?php echo $baseCurrency === $code ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($code); ?> - <?php echo htmlspecialchars($info['name']); ?> (<?php echo htmlspecialchars($info['symbol']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">All prices will be in this currency by default</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Base Settings
            </button>
        </form>
    </div>

    <!-- Service Pricing Card -->
    <div class="settings-card">
        <h2 class="section-title">📦 Service Pricing (Base: <?php echo htmlspecialchars($baseCurrency); ?>)</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update_service_pricing">

            <div class="pricing-table">
                <!-- Parcel -->
                <div class="mb-4">
                    <h5>Parcel Delivery</h5>
                    <div class="service-pricing-row">
                        <div>
                            <label class="form-label">Base Price</label>
                            <input type="number" name="parcel_base_price" step="0.01" value="<?php echo $parcelPrice['base']; ?>" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Distance Rate (per km)</label>
                            <input type="number" name="parcel_distance_rate" step="0.01" value="<?php echo $parcelPrice['distance']; ?>" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Weight Rate (per kg)</label>
                            <input type="number" name="parcel_weight_rate" step="0.01" value="<?php echo $parcelPrice['weight']; ?>" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Formula</label>
                            <input type="text" disabled value="Base + (Distance × Rate) + (Weight × Rate)" class="form-control" style="background: #f5f5f5;">
                        </div>
                    </div>
                </div>

                <!-- Freight -->
                <div class="mb-4">
                    <h5>Freight</h5>
                    <div class="service-pricing-row">
                        <div>
                            <label class="form-label">Base Price</label>
                            <input type="number" name="freight_base_price" step="0.01" value="<?php echo $freightPrice['base']; ?>" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Distance Rate (per km)</label>
                            <input type="number" name="freight_distance_rate" step="0.01" value="<?php echo $freightPrice['distance']; ?>" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Weight Rate (per kg)</label>
                            <input type="number" name="freight_weight_rate" step="0.01" value="<?php echo $freightPrice['weight']; ?>" class="form-control">
                        </div>
                        <div></div>
                    </div>
                </div>

                <!-- Furniture -->
                <div class="mb-4">
                    <h5>Furniture</h5>
                    <div class="service-pricing-row">
                        <div>
                            <label class="form-label">Base Price</label>
                            <input type="number" name="furniture_base_price" step="0.01" value="<?php echo $furniturePrice['base']; ?>" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Distance Rate (per km)</label>
                            <input type="number" name="furniture_distance_rate" step="0.01" value="<?php echo $furniturePrice['distance']; ?>" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Weight Rate (per kg)</label>
                            <input type="number" name="furniture_weight_rate" step="0.01" value="<?php echo $furniturePrice['weight']; ?>" class="form-control">
                        </div>
                        <div></div>
                    </div>
                </div>

                <!-- General Charges -->
                <div class="mb-4 p-3 bg-light rounded">
                    <h5>Additional Charges</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Insurance Percentage (%)</label>
                            <input type="number" name="insurance_percentage" step="0.01" value="<?php echo $insurance; ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Platform Fee Percentage (%)</label>
                            <input type="number" name="platform_fee_percentage" step="0.01" value="<?php echo $platformFee; ?>" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Pricing
            </button>
        </form>
    </div>

    <!-- Currency Selection Card -->
    <div class="settings-card">
        <h2 class="section-title">💱 Currency Settings</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update_currency_settings">

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="allow_currency_selection" 
                       id="allowCurrencySelection" <?php echo $allowCurrencySelection ? 'checked' : ''; ?>>
                <label class="form-check-label" for="allowCurrencySelection">
                    <strong>Allow customers to select alternative payment currency</strong>
                </label>
            </div>

            <div class="mb-4">
                <label class="form-label"><strong>Available Currencies for Booking</strong></label>
                <p class="text-muted">Select which currencies customers can use to pay for bookings</p>
                
                <div class="row">
                    <?php foreach ($allCurrencies as $code => $info): ?>
                        <div class="col-md-6 col-lg-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="selected_currencies[]" 
                                       value="<?php echo $code; ?>" id="currency_<?php echo $code; ?>"
                                       <?php echo in_array($code, $currencyList) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="currency_<?php echo $code; ?>">
                                    <?php echo htmlspecialchars($code); ?> - <?php echo htmlspecialchars($info['name']); ?> (<?php echo htmlspecialchars($info['symbol']); ?>)
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> <strong>Live Exchange Rates:</strong> All currency conversions use live Google Finance rates, cached hourly for performance.
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Currency Settings
            </button>
        </form>
    </div>

    <!-- Exchange Rate Info -->
    <div class="settings-card">
        <h2 class="section-title">📊 Exchange Rate Information</h2>
        <div class="alert alert-info">
            <h5>How Exchange Rates Work</h5>
            <ul>
                <li><strong>Base Currency:</strong> All prices are stored in your base currency (<?php echo htmlspecialchars($baseCurrency); ?>)</li>
                <li><strong>Live Conversion:</strong> When a customer selects a different currency, prices are converted using live Google Finance rates</li>
                <li><strong>Caching:</strong> Exchange rates are cached for 1 hour to improve performance</li>
                <li><strong>Automatic Updates:</strong> Rates are automatically updated when cache expires</li>
            </ul>
        </div>

        <div class="p-3 bg-light rounded">
            <h5>Example Conversion</h5>
            <p>If your base currency is <strong>USD</strong> and a parcel base price is <strong>$5.00</strong>:</p>
            <ul>
                <li>Charged in <strong>GBP</strong>: £4.20 (using live GBP/USD rate)</li>
                <li>Charged in <strong>EUR</strong>: €4.75 (using live EUR/USD rate)</li>
                <li>Charged in <strong>ZWL</strong>: Z$2,500 (using live ZWL/USD rate)</li>
            </ul>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
