<?php
/**
 * Admin API Configuration Page
 * Manage payment gateway and third-party API keys
 */

require_once('../../../config/bootstrap.php');
require_once('login-security.php');

// Set variables for layout
$page_title = 'API Configuration';
$site_name = 'WG ROOS Courier Admin';

// Load API keys from JSON
$keysFile = '../../config/keys.json';
$apiKeys = [];

if (file_exists($keysFile)) {
    $apiKeys = json_decode(file_get_contents($keysFile), true) ?? [];
}

// Handle form submission
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_keys'])) {
    // Sanitize and save API keys
    $keysToSave = [
        'stripe_enabled' => $_POST['stripe_enabled'] ?? 0,
        'stripePk' => htmlspecialchars($_POST['stripePk'] ?? ''),
        'stripeSk' => htmlspecialchars($_POST['stripeSk'] ?? ''),
        'paynow_enabled' => $_POST['paynow_enabled'] ?? 0,
        'paynowId' => htmlspecialchars($_POST['paynowId'] ?? ''),
        'paynowIk' => htmlspecialchars($_POST['paynowIk'] ?? ''),
        'paypal_enabled' => $_POST['paypal_enabled'] ?? 0,
        'paypalid' => htmlspecialchars($_POST['paypalid'] ?? ''),
        'mapApi' => htmlspecialchars($_POST['mapApi'] ?? ''),
        'twilio_enabled' => $_POST['twilio_enabled'] ?? 0,
        'twiliosmsID' => htmlspecialchars($_POST['twiliosmsID'] ?? ''),
        'twiliosmsUsername' => htmlspecialchars($_POST['twiliosmsUsername'] ?? ''),
        'twilioPhoneNumber' => htmlspecialchars($_POST['twilioPhoneNumber'] ?? ''),
    ];
    
    try {
        if (file_put_contents($keysFile, json_encode($keysToSave, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false) {
            $successMessage = 'API keys updated successfully!';
            $apiKeys = $keysToSave;
        } else {
            $errorMessage = 'Failed to save API keys. Check file permissions.';
        }
    } catch (Exception $e) {
        $errorMessage = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $page_title; ?> | <?php echo $site_name; ?></title>
    <?php include '../head.php'; ?>
</head>

<body class="admin-portal">

    <div class="page-container">
        
        <!-- Sidebar Navigation -->
        <?php include '../sidebar-nav-menu.php'; ?>
        
        <!-- Main Content Wrapper -->
        <div class="main-content">
            
            <!-- Header -->
            <?php include '../header.php'; ?>
            
            <!-- Main Content Area -->
            <main class="main-wrapper">
                <section class="section">
                    <div class="container-fluid">
                        
                        <!-- Page Header -->
                        <div class="page-header mb-40">
                            <h1><?php echo $page_title; ?></h1>
                            <p class="text-muted">Configure payment gateways and API integrations</p>
                        </div>

                        <!-- Success/Error Messages -->
                        <?php if (!empty($successMessage)): ?>
                            <div class="alert alert-success alert-dismissible fade show mb-40" role="alert">
                                <i class="lni lni-check-circle"></i> <?php echo $successMessage; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-40" role="alert">
                                <i class="lni lni-close-circle"></i> <?php echo $errorMessage; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- API Configuration Form -->
                        <form method="POST" action="">
                            
                            <!-- Stripe Payment Gateway -->
                            <div class="card mb-40">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">Stripe Payment Gateway</h5>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="stripe_enabled" 
                                                   value="1" <?php echo ($apiKeys['stripe_enabled'] ?? 0) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Enabled</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">International and US credit card payments</p>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stripe Public Key</label>
                                            <input type="text" class="form-control" name="stripePk" 
                                                   value="<?php echo htmlspecialchars($apiKeys['stripePk'] ?? ''); ?>"
                                                   placeholder="pk_live_...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stripe Secret Key</label>
                                            <input type="password" class="form-control" name="stripeSk" 
                                                   value="<?php echo htmlspecialchars($apiKeys['stripeSk'] ?? ''); ?>"
                                                   placeholder="sk_live_...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PayNow Payment Gateway -->
                            <div class="card mb-40">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">PayNow Gateway (Zimbabwe)</h5>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="paynow_enabled"
                                                   value="1" <?php echo ($apiKeys['paynow_enabled'] ?? 0) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Enabled</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">Local Zimbabwe payment processing</p>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Integration ID</label>
                                            <input type="text" class="form-control" name="paynowId"
                                                   value="<?php echo htmlspecialchars($apiKeys['paynowId'] ?? ''); ?>"
                                                   placeholder="Integration ID">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Integration Key</label>
                                            <input type="password" class="form-control" name="paynowIk"
                                                   value="<?php echo htmlspecialchars($apiKeys['paynowIk'] ?? ''); ?>"
                                                   placeholder="Integration Key">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PayPal Payment Gateway -->
                            <div class="card mb-40">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">PayPal Payment Gateway</h5>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="paypal_enabled"
                                                   value="1" <?php echo ($apiKeys['paypal_enabled'] ?? 0) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Enabled</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">International PayPal payments</p>
                                    <div class="mb-3">
                                        <label class="form-label">PayPal Business ID</label>
                                        <input type="text" class="form-control" name="paypalid"
                                               value="<?php echo htmlspecialchars($apiKeys['paypalid'] ?? ''); ?>"
                                               placeholder="your-business-id@paypal.com">
                                    </div>
                                </div>
                            </div>

                            <!-- Maps API -->
                            <div class="card mb-40">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Maps & Routing API</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">Google Maps API for location services and routing</p>
                                    <div class="mb-3">
                                        <label class="form-label">Google Maps API Key</label>
                                        <input type="password" class="form-control" name="mapApi"
                                               value="<?php echo htmlspecialchars($apiKeys['mapApi'] ?? ''); ?>"
                                               placeholder="AIzaSy...">
                                    </div>
                                </div>
                            </div>

                            <!-- Twilio SMS Service -->
                            <div class="card mb-40">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">Twilio SMS Service</h5>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="twilio_enabled"
                                                   value="1" <?php echo ($apiKeys['twilio_enabled'] ?? 0) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Enabled</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">SMS notifications for orders and drivers</p>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Account SID</label>
                                            <input type="password" class="form-control" name="twiliosmsID"
                                                   value="<?php echo htmlspecialchars($apiKeys['twiliosmsID'] ?? ''); ?>"
                                                   placeholder="Account SID">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Auth Token</label>
                                            <input type="password" class="form-control" name="twiliosmsUsername"
                                                   value="<?php echo htmlspecialchars($apiKeys['twiliosmsUsername'] ?? ''); ?>"
                                                   placeholder="Auth Token">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="twilioPhoneNumber"
                                                   value="<?php echo htmlspecialchars($apiKeys['twilioPhoneNumber'] ?? ''); ?>"
                                                   placeholder="+1234567890">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" name="save_keys" class="btn btn-success">
                                    <i class="lni lni-save"></i> Save API Keys
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="lni lni-reload"></i> Reset Form
                                </button>
                            </div>

                        </form>

                        <!-- API Status Information -->
                        <div class="card mt-40">
                            <div class="card-header">
                                <h5 class="card-title mb-0">API Status</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Last Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Stripe</td>
                                            <td><?php echo ($apiKeys['stripe_enabled'] ?? 0) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                                            <td><?php echo date('M d, Y H:i'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>PayNow</td>
                                            <td><?php echo ($apiKeys['paynow_enabled'] ?? 0) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                                            <td><?php echo date('M d, Y H:i'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>PayPal</td>
                                            <td><?php echo ($apiKeys['paypal_enabled'] ?? 0) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                                            <td><?php echo date('M d, Y H:i'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Google Maps</td>
                                            <td><?php echo !empty($apiKeys['mapApi']) ? '<span class="badge bg-success">Configured</span>' : '<span class="badge bg-warning">Not Configured</span>'; ?></td>
                                            <td><?php echo date('M d, Y H:i'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Twilio SMS</td>
                                            <td><?php echo ($apiKeys['twilio_enabled'] ?? 0) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                                            <td><?php echo date('M d, Y H:i'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>
            </main>

        </div>

    </div>

    <!-- Footer -->
    <?php include '../footer.php'; ?>

    <!-- Footer Scripts -->
    <?php include '../footerscripts.php'; ?>

</body>

</html>

?>

<!-- Function library already loaded via bootstrap.php -->
<!DOCTYPE html>
<html lang="en">

<head>


    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - API Integrations</title>

</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Manage APIs</h1>
                        <div class="row">
                            <?php
                            echo $sResponse;
                            $aData = json_decode(file_get_contents("../keys.json"));
                            // echo "<pre>" . print_r($aData, true) . "</pre>";
                            $stripePk = !empty($aData->stripePk) ? $aData->stripePk : "";
                            $stripeSk = !empty($aData->stripeSk) ? $aData->stripeSk : "";
                            $paynowIk = !empty($aData->paynowIk) ? $aData->paynowIk : "";
                            $paynowId = !empty($aData->paynowId) ? $aData->paynowId : "";
                            $paypalid = !empty($aData->paypalid) ? $aData->paypalid : "";
                            $mapApi = !empty($aData->mapApi) ? $aData->mapApi : "";
                            $smsID = !empty($aData->smsId) ? $aData->smsId : "";
                            $smsUsername = !empty($aData->smsUsername) ? $aData->smsUsername : "";
                            $smsPwd = !empty($aData->smsPwd) ? $aData->smsPwd : "";

                            $twiliosmsID = !empty($aData->twiliosmsID) ? $aData->twiliosmsID : "";
                            $twiliosmsUsername = !empty($aData->twiliosmsUsername) ? $aData->twiliosmsUsername : "";
                            $twilioPhoneNumber = !empty($aData->twilioPhoneNumber) ? $aData->twilioPhoneNumber : "";
                            ?>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-12">
                                <form role="form" method="POST" name="invite" action="api.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block"></p>

                                        <div class="panel panel-default">
                                            <!-- .panel-heading -->
                                            <div class="panel-body">
                                                <div class="panel-group" id="accordion">
                                                    <!----------Strip Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Stripe API (International Payments)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse in">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="stripe_handle" id="stripe_handle" <?php echo ($aData->stripe_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show Stripe
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="stripe_handle" id="stripe_handle" <?php echo ($aData->stripe_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide Stripe
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Stripe Publish Key</label>
                                                                        <input type="text" class="form-control" value="<?php echo $stripePk; ?>" name="stripePk" placeholder="Enter Stripe Publish Key" required /><br />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Stripe Secret Key</label>
                                                                        <input type="text" class="form-control" value="<?php echo $stripeSk; ?>" name="stripeSk" placeholder="Enter Stripe Secret Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Strip End --------->

                                                    <!----------Paynow Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Paynow API (Zimbabwe Payments)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paynow_handle" id="paynow_handle" <?php echo ($aData->paynow_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show PayNow
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paynow_handle" id="paynow_handle" <?php echo ($aData->paynow_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide PayNow
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>PayNow Integration ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paynowId; ?>" name="paynowId" placeholder="Enter PayNow Integration ID" required /><br />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>PayNow Integration ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paynowIk; ?>" name="paynowIk" placeholder="Enter PayNow Integration Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/PayNow End --------->

                                                    <!----------Paypal Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">PayPal API (International Payments)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseThree" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paypal_handle" id="paypal_handle" <?php echo ($aData->paypal_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show Paypal
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paypal_handle" id="paypal_handle" <?php echo ($aData->paypal_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide Paypal
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Paypal ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paypalid; ?>" name="paypalid" placeholder="Enter PayNow Integration Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Paypal End --------->

                                                    <!----------Google Maps Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Google Maps API (International Geolocation)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFour" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Google Map API</label>
                                                                        <input type="text" class="form-control" value="<?php echo $mapApi; ?>" name="mapApi" placeholder="Enter Google Map API Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Google Maps End --------->

                                                    <!----------Bulk SMS Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Bulk SMS API (Zimbabwe Messaging)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFive" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsID; ?>" name="smsId" placeholder="Enter SMS ID" required /><br />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS Username</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsUsername; ?>" name="smsUsername" placeholder="Enter SMS Username" required />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS Password</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsPwd; ?>" name="smsPwd" placeholder="Enter SMS Password" required /> <br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Bulk SMS End --------->

                                                    <!----------Twilio Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">Twilio SMS API (International Messaging)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseSix" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="twilio_handle" id="twilio_handle" <?php echo ($aData->twilio_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Active
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="twilio_handle" id="twilio_handle" <?php echo ($aData->twilio_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Deactivate
                                                                        </label>

                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Account SID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twiliosmsID; ?>" name="twiliosmsID" placeholder="Enter SMS ID" required /><br />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Auth Token</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twiliosmsUsername; ?>" name="twiliosmsUsername" placeholder="Enter SMS Username" required />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Phone Number</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twilioPhoneNumber; ?>" name="twilioPhoneNumber" placeholder="Enter SMS Password" required /> <br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Twilio End --------->

                                                    <div class="col-lg-6 pull-right">
                                                        <br /><br />
                                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Submit">
                                                        <input type="hidden" name="MM_insert" value="invite">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr />

                            </div>

                            <!-- /.col-lg-6 -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


