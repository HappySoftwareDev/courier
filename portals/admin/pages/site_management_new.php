<?php
/**
 * Admin Site Management Page
 * Centralized configuration management for all settings
 */

require_once '../../../config/bootstrap.php';

// Require admin authentication
AuthManager::requireRole('admin', '/admin/login.php');

$pageTitle = 'Site Management';
$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section = $_POST['section'] ?? '';

    try {
        switch ($section) {
            case 'website':
                $CONFIG->save('site_name', $_POST['site_name']);
                $CONFIG->save('site_url', $_POST['site_url']);
                $CONFIG->save('logo_path', $_POST['logo_path']);
                $CONFIG->save('favicon_path', $_POST['favicon_path']);
                $message = 'Website settings updated successfully';
                $messageType = 'success';
                break;

            case 'business':
                $CONFIG->save('business_address', $_POST['business_address']);
                $CONFIG->save('business_phone', $_POST['business_phone']);
                $CONFIG->save('business_email', $_POST['business_email']);
                $CONFIG->save('business_reg_number', $_POST['business_reg_number']);
                $message = 'Business settings updated successfully';
                $messageType = 'success';
                break;

            case 'payment':
                // PayNow Configuration (Zimbabwe)
                $CONFIG->save('paynow_enabled', isset($_POST['paynow_enabled']) ? 'true' : 'false');
                $CONFIG->save('paynow_integration_id', $_POST['paynow_integration_id'] ?? '');
                $CONFIG->save('paynow_integration_key', $_POST['paynow_integration_key'] ?? '');

                // Stripe Configuration (Global)
                $CONFIG->save('stripe_enabled', isset($_POST['stripe_enabled']) ? 'true' : 'false');
                $CONFIG->save('stripe_public_key', $_POST['stripe_public_key'] ?? '');
                $CONFIG->save('stripe_secret_key', $_POST['stripe_secret_key'] ?? '');
                $CONFIG->save('stripe_webhook_secret', $_POST['stripe_webhook_secret'] ?? '');

                // PayPal Configuration (Global)
                $CONFIG->save('paypal_enabled', isset($_POST['paypal_enabled']) ? 'true' : 'false');
                $CONFIG->save('paypal_mode', $_POST['paypal_mode'] ?? 'sandbox');
                $CONFIG->save('paypal_client_id', $_POST['paypal_client_id'] ?? '');
                $CONFIG->save('paypal_client_secret', $_POST['paypal_client_secret'] ?? '');
                $CONFIG->save('paypal_webhook_id', $_POST['paypal_webhook_id'] ?? '');

                // 543Konse Configuration (Zambia)
                $CONFIG->save('konse_enabled', isset($_POST['konse_enabled']) ? 'true' : 'false');
                $CONFIG->save('konse_api_key', $_POST['konse_api_key'] ?? '');
                $CONFIG->save('konse_api_secret', $_POST['konse_api_secret'] ?? '');
                $CONFIG->save('konse_merchant_id', $_POST['konse_merchant_id'] ?? '');
                $CONFIG->save('konse_api_url', $_POST['konse_api_url'] ?? 'https://api.543konse.com');

                $message = 'Payment gateway settings updated successfully';
                $messageType = 'success';
                break;

            case 'firebase':
                $CONFIG->save('firebase_api_key', $_POST['firebase_api_key']);
                $CONFIG->save('firebase_auth_domain', $_POST['firebase_auth_domain']);
                $CONFIG->save('firebase_database_url', $_POST['firebase_database_url']);
                $CONFIG->save('firebase_project_id', $_POST['firebase_project_id']);
                $CONFIG->save('firebase_storage_bucket', $_POST['firebase_storage_bucket']);
                $CONFIG->save('firebase_messaging_sender_id', $_POST['firebase_messaging_sender_id']);
                $CONFIG->save('firebase_app_id', $_POST['firebase_app_id']);
                $CONFIG->save('firebase_push_key', $_POST['firebase_push_key']);
                $message = 'Firebase settings updated successfully';
                $messageType = 'success';
                break;

            case 'sms':
                $CONFIG->save('sms_provider', $_POST['sms_provider']);
                $CONFIG->save('twilio_account_sid', $_POST['twilio_account_sid']);
                $CONFIG->save('twilio_auth_token', $_POST['twilio_auth_token']);
                $CONFIG->save('twilio_phone_number', $_POST['twilio_phone_number']);
                $CONFIG->save('custom_sms_id', $_POST['custom_sms_id']);
                $CONFIG->save('custom_sms_username', $_POST['custom_sms_username']);
                $CONFIG->save('custom_sms_password', $_POST['custom_sms_password']);
                $message = 'SMS settings updated successfully';
                $messageType = 'success';
                break;

            case 'email':
                $CONFIG->save('email_from', $_POST['email_from']);
                $CONFIG->save('email_from_name', $_POST['email_from_name']);
                $CONFIG->save('smtp_host', $_POST['smtp_host']);
                $CONFIG->save('smtp_port', $_POST['smtp_port']);
                $CONFIG->save('smtp_user', $_POST['smtp_user']);
                $CONFIG->save('smtp_pass', $_POST['smtp_pass']);
                $message = 'Email settings updated successfully';
                $messageType = 'success';
                break;

            case 'security':
                $CONFIG->save('recaptcha_enabled', isset($_POST['recaptcha_enabled']) ? 'true' : 'false');
                $CONFIG->save('recaptcha_site_key', $_POST['recaptcha_site_key']);
                $CONFIG->save('recaptcha_secret_key', $_POST['recaptcha_secret_key']);
                $CONFIG->save('force_https', isset($_POST['force_https']) ? 'true' : 'false');
                $CONFIG->save('session_timeout', $_POST['session_timeout']);
                $message = 'Security settings updated successfully';
                $messageType = 'success';
                break;

            case 'pricing':
                $CONFIG->save('parcel_base_price', $_POST['parcel_base_price']);
                $CONFIG->save('parcel_distance_rate', $_POST['parcel_distance_rate']);
                $CONFIG->save('parcel_weight_rate', $_POST['parcel_weight_rate']);
                $CONFIG->save('freight_base_price', $_POST['freight_base_price']);
                $CONFIG->save('freight_distance_rate', $_POST['freight_distance_rate']);
                $CONFIG->save('freight_weight_rate', $_POST['freight_weight_rate']);
                $CONFIG->save('furniture_base_price', $_POST['furniture_base_price']);
                $CONFIG->save('furniture_distance_rate', $_POST['furniture_distance_rate']);
                $CONFIG->save('insurance_percentage', $_POST['insurance_percentage']);
                $message = 'Pricing settings updated successfully';
                $messageType = 'success';
                break;

            case 'commission':
                $CONFIG->save('parcel_commission_percentage', $_POST['parcel_commission']);
                $CONFIG->save('freight_commission_percentage', $_POST['freight_commission']);
                $CONFIG->save('furniture_commission_percentage', $_POST['furniture_commission']);
                $CONFIG->save('taxi_commission_percentage', $_POST['taxi_commission']);
                $CONFIG->save('towtruck_commission_percentage', $_POST['towtruck_commission']);
                $message = 'Commission settings updated successfully';
                $messageType = 'success';
                break;

            default:
                $message = 'Unknown section';
                $messageType = 'error';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'error';
    }
}

// Get all settings
$website = $CONFIG->getWebsite();
$business = $CONFIG->getBusiness();
$payment = $CONFIG->getPayment();
$firebase = $CONFIG->getFirebase();
$sms = $CONFIG->getSMS();
$email = $CONFIG->getEmail();
$security = $CONFIG->getSecurity();
$pricing = $CONFIG->getPricing();
$commission = $CONFIG->getCommission();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <style>
        .settings-container { margin-top: 20px; }
        .settings-section { 
            background: white; 
            padding: 25px; 
            margin-bottom: 25px; 
            border-radius: 5px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .settings-section h3 { 
            border-bottom: 2px solid #FF8C00; 
            padding-bottom: 10px; 
            margin-bottom: 20px;
            color: #333;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { font-weight: 600; margin-bottom: 5px; }
        .form-control { border-radius: 3px; border: 1px solid #ddd; }
        .btn-save { background-color: #FF8C00; color: white; }
        .btn-save:hover { background-color: #e67e00; }
        .alert { margin-bottom: 20px; }
        .nav-tabs { border-bottom: 2px solid #FF8C00; }
        .nav-tabs .nav-link.active { 
            border-bottom: 3px solid #FF8C00; 
            color: #FF8C00;
        }
    </style>
</head>
<body>
    <?php include 'admin-nav.php'; ?>
    
    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo $pageTitle; ?></h2>
                
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <!-- Tabbed Interface -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#website">Website</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#business">Business</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#payment">Payment</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#firebase">Firebase</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sms">SMS</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#email">Email</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#security">Security</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#commission">Commission</a></li>
                </ul>

                <div class="tab-content">

                    <!-- Website Settings -->
                    <div id="website" class="tab-pane fade show active">
                        <div class="settings-section">
                            <h3>Website Settings</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="website">
                                
                                <div class="form-group">
                                    <label>Site Name</label>
                                    <input type="text" class="form-control" name="site_name" value="<?php echo $website['name']; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Site URL</label>
                                    <input type="text" class="form-control" name="site_url" value="<?php echo $website['url']; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Logo Path</label>
                                    <input type="text" class="form-control" name="logo_path" value="<?php echo $website['logo']; ?>">
                                    <small class="form-text text-muted">Relative path to logo file</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Favicon Path</label>
                                    <input type="text" class="form-control" name="favicon_path" value="<?php echo $website['favicon']; ?>">
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Business Settings -->
                    <div id="business" class="tab-pane fade">
                        <div class="settings-section">
                            <h3>Business Settings</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="business">
                                
                                <div class="form-group">
                                    <label>Business Address</label>
                                    <textarea class="form-control" name="business_address" rows="3"><?php echo $business['address']; ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Business Phone</label>
                                    <input type="text" class="form-control" name="business_phone" value="<?php echo $business['phone']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Business Email</label>
                                    <input type="email" class="form-control" name="business_email" value="<?php echo $business['email']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Registration Number</label>
                                    <input type="text" class="form-control" name="business_reg_number" value="<?php echo $business['registration_number']; ?>">
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Gateway Settings -->
                    <div id="payment" class="tab-pane fade">
                        <div class="settings-section">
                            <h3>Payment Gateway Settings</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="payment">
                                
                                <!-- Stripe -->
                                <h5 style="margin-top: 20px; color: #FF8C00;">Stripe Configuration</h5>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="stripe_enabled" id="stripe_enabled" 
                                               <?php echo $payment['stripe_enabled'] ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="stripe_enabled">Enable Stripe</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Stripe Public Key</label>
                                    <input type="text" class="form-control" name="stripe_public_key" value="<?php echo $payment['stripe_public_key']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Stripe Secret Key</label>
                                    <input type="password" class="form-control" name="stripe_secret_key" value="<?php echo $payment['stripe_secret_key']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>Stripe Webhook Secret</label>
                                    <input type="password" class="form-control" name="stripe_webhook_secret" value="<?php echo $payment['stripe_webhook_secret']; ?>">
                                    <small class="form-text text-muted">Get from Dashboard → Webhooks</small>
                                </div>

                                <!-- PayNow -->
                                <h5 style="margin-top: 20px; color: #FF8C00;">PayNow Configuration (Zimbabwe)</h5>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="paynow_enabled" id="paynow_enabled" 
                                               <?php echo $payment['paynow_enabled'] ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="paynow_enabled">Enable PayNow</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>PayNow Integration ID</label>
                                    <input type="text" class="form-control" name="paynow_integration_id" value="<?php echo $payment['paynow_integration_id']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>PayNow Integration Key</label>
                                    <input type="password" class="form-control" name="paynow_integration_key" value="<?php echo $payment['paynow_integration_key']; ?>">
                                </div>

                                <!-- PayPal -->
                                <h5 style="margin-top: 20px; color: #FF8C00;">PayPal Configuration (Global)</h5>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="paypal_enabled" id="paypal_enabled" 
                                               <?php echo $payment['paypal_enabled'] ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="paypal_enabled">Enable PayPal</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>PayPal Mode</label>
                                    <select class="form-control" name="paypal_mode">
                                        <option value="sandbox" <?php echo $payment['paypal_mode'] === 'sandbox' ? 'selected' : ''; ?>>Sandbox (Testing)</option>
                                        <option value="live" <?php echo $payment['paypal_mode'] === 'live' ? 'selected' : ''; ?>>Live (Production)</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>PayPal Client ID</label>
                                    <input type="password" class="form-control" name="paypal_client_id" value="<?php echo $payment['paypal_client_id']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>PayPal Client Secret</label>
                                    <input type="password" class="form-control" name="paypal_client_secret" value="<?php echo $payment['paypal_client_secret']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>PayPal Webhook ID</label>
                                    <input type="password" class="form-control" name="paypal_webhook_id" value="<?php echo $payment['paypal_webhook_id']; ?>">
                                    <small class="form-text text-muted">Get from Account Settings → Webhooks</small>
                                </div>

                                <!-- 543Konse -->
                                <h5 style="margin-top: 20px; color: #FF8C00;">543Konse Configuration (Zambia)</h5>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="konse_enabled" id="konse_enabled" 
                                               <?php echo $payment['konse_enabled'] ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="konse_enabled">Enable 543Konse</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>543Konse API Key</label>
                                    <input type="password" class="form-control" name="konse_api_key" value="<?php echo $payment['konse_api_key']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>543Konse API Secret</label>
                                    <input type="password" class="form-control" name="konse_api_secret" value="<?php echo $payment['konse_api_secret']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>543Konse Merchant ID</label>
                                    <input type="text" class="form-control" name="konse_merchant_id" value="<?php echo $payment['konse_merchant_id']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>543Konse API URL</label>
                                    <input type="text" class="form-control" name="konse_api_url" value="<?php echo $payment['konse_api_url']; ?>">
                                    <small class="form-text text-muted">Default: https://api.543konse.com</small>
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Firebase Settings -->
                    <div id="firebase" class="tab-pane fade">
                        <div class="settings-section">
                            <h3>Firebase Configuration</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="firebase">
                                
                                <div class="form-group">
                                    <label>API Key</label>
                                    <input type="text" class="form-control" name="firebase_api_key" value="<?php echo $firebase['api_key']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Auth Domain</label>
                                    <input type="text" class="form-control" name="firebase_auth_domain" value="<?php echo $firebase['auth_domain']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Database URL</label>
                                    <input type="text" class="form-control" name="firebase_database_url" value="<?php echo $firebase['database_url']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Project ID</label>
                                    <input type="text" class="form-control" name="firebase_project_id" value="<?php echo $firebase['project_id']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Storage Bucket</label>
                                    <input type="text" class="form-control" name="firebase_storage_bucket" value="<?php echo $firebase['storage_bucket']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Messaging Sender ID</label>
                                    <input type="text" class="form-control" name="firebase_messaging_sender_id" value="<?php echo $firebase['messaging_sender_id']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>App ID</label>
                                    <input type="text" class="form-control" name="firebase_app_id" value="<?php echo $firebase['app_id']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Push Notification Key</label>
                                    <input type="password" class="form-control" name="firebase_push_key" value="<?php echo $firebase['push_key']; ?>">
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- SMS Settings -->
                    <div id="sms" class="tab-pane fade">
                        <div class="settings-section">
                            <h3>SMS Configuration</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="sms">
                                
                                <div class="form-group">
                                    <label>SMS Provider</label>
                                    <select class="form-control" name="sms_provider">
                                        <option value="twilio" <?php echo $sms['provider'] === 'twilio' ? 'selected' : ''; ?>>Twilio</option>
                                        <option value="custom" <?php echo $sms['provider'] === 'custom' ? 'selected' : ''; ?>>Custom Provider</option>
                                    </select>
                                </div>

                                <!-- Twilio -->
                                <h5 style="margin-top: 20px; color: #FF8C00;">Twilio Settings</h5>
                                <div class="form-group">
                                    <label>Account SID</label>
                                    <input type="text" class="form-control" name="twilio_account_sid" value="<?php echo $sms['twilio_account_sid']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Auth Token</label>
                                    <input type="password" class="form-control" name="twilio_auth_token" value="<?php echo $sms['twilio_auth_token']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="twilio_phone_number" value="<?php echo $sms['twilio_phone']; ?>">
                                </div>

                                <!-- Custom -->
                                <h5 style="margin-top: 20px; color: #FF8C00;">Custom Provider Settings</h5>
                                <div class="form-group">
                                    <label>Provider ID</label>
                                    <input type="text" class="form-control" name="custom_sms_id" value="<?php echo $sms['custom_sms_id']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="custom_sms_username" value="<?php echo $sms['custom_sms_user']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="custom_sms_password" value="<?php echo $sms['custom_sms_pass']; ?>">
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div id="email" class="tab-pane fade">
                        <div class="settings-section">
                            <h3>Email Configuration</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="email">
                                
                                <div class="form-group">
                                    <label>From Email Address</label>
                                    <input type="email" class="form-control" name="email_from" value="<?php echo $email['from_email']; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>From Name</label>
                                    <input type="text" class="form-control" name="email_from_name" value="<?php echo $email['from_name']; ?>" required>
                                </div>

                                <h5 style="margin-top: 20px; color: #FF8C00;">SMTP Settings</h5>
                                
                                <div class="form-group">
                                    <label>SMTP Host</label>
                                    <input type="text" class="form-control" name="smtp_host" value="<?php echo $email['smtp_host']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>SMTP Port</label>
                                    <input type="number" class="form-control" name="smtp_port" value="<?php echo $email['smtp_port']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>SMTP Username</label>
                                    <input type="text" class="form-control" name="smtp_user" value="<?php echo $email['smtp_user']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>SMTP Password</label>
                                    <input type="password" class="form-control" name="smtp_pass" value="<?php echo $email['smtp_pass']; ?>">
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div id="security" class="tab-pane fade">
                        <div class="settings-section">
                            <h3>Security Settings</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="security">
                                
                                <h5 style="margin-bottom: 15px; color: #FF8C00;">reCAPTCHA Configuration</h5>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="recaptcha_enabled" id="recaptcha_enabled" 
                                               <?php echo $security['recaptcha_enabled'] ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="recaptcha_enabled">Enable reCAPTCHA</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>reCAPTCHA Site Key</label>
                                    <input type="text" class="form-control" name="recaptcha_site_key" value="<?php echo $security['recaptcha_site_key']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>reCAPTCHA Secret Key</label>
                                    <input type="password" class="form-control" name="recaptcha_secret_key" value="<?php echo $security['recaptcha_secret_key']; ?>">
                                </div>

                                <h5 style="margin-top: 20px; margin-bottom: 15px; color: #FF8C00;">HTTPS & Session</h5>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="force_https" id="force_https" 
                                               <?php echo $security['force_https'] ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="force_https">Force HTTPS</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Session Timeout (seconds)</label>
                                    <input type="number" class="form-control" name="session_timeout" value="<?php echo $security['session_timeout']; ?>">
                                    <small class="form-text text-muted">3600 = 1 hour</small>
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Pricing Settings -->
                    <div id="pricing" class="tab-pane fade">
                        <div class="settings-section">
                            <h3>Pricing Configuration</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="pricing">
                                
                                <h5 style="margin-bottom: 15px; color: #FF8C00;">Parcel Delivery Pricing</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Base Price ($)</label>
                                        <input type="number" step="0.01" class="form-control" name="parcel_base_price" value="<?php echo $pricing['parcel_base_price']; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Distance Rate ($/km)</label>
                                        <input type="number" step="0.01" class="form-control" name="parcel_distance_rate" value="<?php echo $pricing['parcel_distance_rate']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Weight Rate ($/kg)</label>
                                    <input type="number" step="0.01" class="form-control" name="parcel_weight_rate" value="<?php echo $pricing['parcel_weight_rate']; ?>">
                                </div>

                                <h5 style="margin-top: 20px; margin-bottom: 15px; color: #FF8C00;">Freight Pricing</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Base Price ($)</label>
                                        <input type="number" step="0.01" class="form-control" name="freight_base_price" value="<?php echo $pricing['freight_base_price']; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Distance Rate ($/km)</label>
                                        <input type="number" step="0.01" class="form-control" name="freight_distance_rate" value="<?php echo $pricing['freight_distance_rate']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Weight Rate ($/kg)</label>
                                    <input type="number" step="0.01" class="form-control" name="freight_weight_rate" value="<?php echo $pricing['freight_weight_rate']; ?>">
                                </div>

                                <h5 style="margin-top: 20px; margin-bottom: 15px; color: #FF8C00;">Furniture Removal Pricing</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Base Price ($)</label>
                                        <input type="number" step="0.01" class="form-control" name="furniture_base_price" value="<?php echo $pricing['furniture_base_price']; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Distance Rate ($/km)</label>
                                        <input type="number" step="0.01" class="form-control" name="furniture_distance_rate" value="<?php echo $pricing['furniture_distance_rate']; ?>">
                                    </div>
                                </div>

                                <h5 style="margin-top: 20px; margin-bottom: 15px; color: #FF8C00;">General</h5>
                                <div class="form-group">
                                    <label>Insurance Fee (%)</label>
                                    <input type="number" step="0.1" class="form-control" name="insurance_percentage" value="<?php echo $pricing['insurance_percentage']; ?>">
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Commission Settings -->
                    <div id="commission" class="tab-pane fade">
                        <div class="settings-section">
                            <h3>Driver Commission Configuration</h3>
                            <form method="POST">
                                <input type="hidden" name="section" value="commission">
                                
                                <p class="text-muted mb-4">Set the commission percentage drivers earn for each service type</p>
                                
                                <div class="form-group">
                                    <label>Parcel Delivery Commission (%)</label>
                                    <input type="number" step="1" class="form-control" name="parcel_commission" value="<?php echo $commission['parcel_commission']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Freight Commission (%)</label>
                                    <input type="number" step="1" class="form-control" name="freight_commission" value="<?php echo $commission['freight_commission']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Furniture Removal Commission (%)</label>
                                    <input type="number" step="1" class="form-control" name="furniture_commission" value="<?php echo $commission['furniture_commission']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Taxi Service Commission (%)</label>
                                    <input type="number" step="1" class="form-control" name="taxi_commission" value="<?php echo $commission['taxi_commission']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Tow Truck Commission (%)</label>
                                    <input type="number" step="1" class="form-control" name="towtruck_commission" value="<?php echo $commission['towtruck_commission']; ?>">
                                </div>
                                
                                <button type="submit" class="btn btn-save">Save Changes</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="../../js/jquery-3.6.0.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
</body>
</html>


