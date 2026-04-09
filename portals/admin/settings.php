<?php
/**
 * Admin Settings Management
 * Centralized configuration and settings for the entire platform
 */

// Session is already started by bootstrap.php - do NOT call session_start() again
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check admin access BEFORE any output
if (!isset($_SESSION['admin_id']) && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')) {
    // Redirect to login - must be before any output
    header('Location: /login.php', true, 302);
    exit;
}

require_once dirname(__DIR__) . '/config/bootstrap.php';

$configManager = new ConfigManager($DB, $CONFIG);
$message = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'update_general':
            $result = $configManager->updateConfig([
                'app_name' => $_POST['app_name'] ?? '',
                'app_url' => $_POST['app_url'] ?? '',
                'support_email' => $_POST['support_email'] ?? '',
                'support_phone' => $_POST['support_phone'] ?? '',
                'timezone' => $_POST['timezone'] ?? 'UTC'
            ]);
            $result['success'] ? $message = 'Settings updated' : $error = $result['error'];
            break;

        case 'update_pricing':
            $result = $configManager->updateConfig([
                'currency' => $_POST['currency'] ?? 'USD',
                'default_base_price' => (float)($_POST['default_base_price'] ?? 0),
                'insurance_percentage' => (float)($_POST['insurance_percentage'] ?? 5),
                'platform_fee_percentage' => (float)($_POST['platform_fee_percentage'] ?? 0)
            ]);
            $result['success'] ? $message = 'Pricing settings updated' : $error = $result['error'];
            break;

        case 'update_email':
            $result = $configManager->updateConfig([
                'smtp_host' => $_POST['smtp_host'] ?? '',
                'smtp_port' => (int)($_POST['smtp_port'] ?? 587),
                'smtp_username' => $_POST['smtp_username'] ?? '',
                'smtp_password' => $_POST['smtp_password'] ?? '',
                'from_email' => $_POST['from_email'] ?? '',
                'from_name' => $_POST['from_name'] ?? ''
            ]);
            $result['success'] ? $message = 'Email settings updated' : $error = $result['error'];
            break;

        case 'update_payment':
            $result = $configManager->updateConfig([
                'paynow_enabled' => isset($_POST['paynow_enabled']) ? 1 : 0,
                'paynow_key' => $_POST['paynow_key'] ?? '',
                'stripe_enabled' => isset($_POST['stripe_enabled']) ? 1 : 0,
                'stripe_public_key' => $_POST['stripe_public_key'] ?? '',
                'stripe_secret_key' => $_POST['stripe_secret_key'] ?? '',
            ]);
            $result['success'] ? $message = 'Payment settings updated' : $error = $result['error'];
            break;

        case 'update_features':
            $result = $configManager->updateConfig([
                'enable_guest_booking' => isset($_POST['enable_guest_booking']) ? 1 : 0,
                'enable_instant_booking' => isset($_POST['enable_instant_booking']) ? 1 : 0,
                'enable_scheduling' => isset($_POST['enable_scheduling']) ? 1 : 0,
                'require_email_verification' => isset($_POST['require_email_verification']) ? 1 : 0,
                'auto_assign_driver' => isset($_POST['auto_assign_driver']) ? 1 : 0
            ]);
            $result['success'] ? $message = 'Feature settings updated' : $error = $result['error'];
            break;
    }
}

// Get current settings
$settings = $configManager->getAllConfig();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings - <?php echo htmlspecialchars($settings['app_name'] ?? 'WGRoos'); ?></title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fontawesome-all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
        }

        .settings-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 20px;
        }

        .settings-sidebar {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .settings-sidebar a {
            display: block;
            padding: 15px 20px;
            color: #666;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        .settings-sidebar a:hover {
            background-color: #f9f9f9;
            color: #007bff;
            border-left-color: #007bff;
        }

        .settings-sidebar a.active {
            background-color: #f0f7ff;
            color: #007bff;
            border-left-color: #007bff;
            font-weight: bold;
        }

        .settings-content {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .settings-section {
            display: none;
        }

        .settings-section.active {
            display: block;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.95rem;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .alert.show {
            display: block;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
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

        .info-text {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }

        .setting-group {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }

        .setting-group h4 {
            margin-top: 0;
            color: #007bff;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .settings-layout {
                grid-template-columns: 1fr;
            }

            .settings-sidebar {
                position: static;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
            }

            .settings-sidebar a {
                flex: 1;
                border-left: none;
                border-bottom: 2px solid transparent;
                text-align: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-cog"></i> Platform Settings</h1>
            <p>Manage all configuration and settings for your platform</p>
        </div>

        <!-- Alerts -->
        <?php if ($message): ?>
            <div class="alert alert-success show">✓ <?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger show">✗ <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Settings Layout -->
        <div class="settings-layout">
            <!-- Sidebar Navigation -->
            <div class="settings-sidebar">
                <a href="#general" class="setting-nav active"><i class="fas fa-home"></i> General</a>
                <a href="#pricing" class="setting-nav"><i class="fas fa-dollar-sign"></i> Pricing</a>
                <a href="#email" class="setting-nav"><i class="fas fa-envelope"></i> Email</a>
                <a href="#payment" class="setting-nav"><i class="fas fa-credit-card"></i> Payment</a>
                <a href="#features" class="setting-nav"><i class="fas fa-toggle-on"></i> Features</a>
            </div>

            <!-- Settings Content -->
            <div class="settings-content">
                <!-- General Settings -->
                <div id="general" class="settings-section active">
                    <div class="section-title">General Settings</div>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_general">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Application Name</label>
                                <input type="text" name="app_name" value="<?php echo htmlspecialchars($settings['app_name'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label>Application URL</label>
                                <input type="url" name="app_url" value="<?php echo htmlspecialchars($settings['app_url'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Support Email</label>
                                <input type="email" name="support_email" value="<?php echo htmlspecialchars($settings['support_email'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label>Support Phone</label>
                                <input type="tel" name="support_phone" value="<?php echo htmlspecialchars($settings['support_phone'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Timezone</label>
                            <select name="timezone">
                                <option value="UTC" <?php echo ($settings['timezone'] ?? '') === 'UTC' ? 'selected' : ''; ?>>UTC</option>
                                <option value="America/New_York" <?php echo ($settings['timezone'] ?? '') === 'America/New_York' ? 'selected' : ''; ?>>Eastern Time</option>
                                <option value="America/Chicago" <?php echo ($settings['timezone'] ?? '') === 'America/Chicago' ? 'selected' : ''; ?>>Central Time</option>
                                <option value="America/Denver" <?php echo ($settings['timezone'] ?? '') === 'America/Denver' ? 'selected' : ''; ?>>Mountain Time</option>
                                <option value="America/Los_Angeles" <?php echo ($settings['timezone'] ?? '') === 'America/Los_Angeles' ? 'selected' : ''; ?>>Pacific Time</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save General Settings</button>
                    </form>
                </div>

                <!-- Pricing Settings -->
                <div id="pricing" class="settings-section">
                    <div class="section-title">Pricing Settings</div>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_pricing">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Currency</label>
                                <select name="currency">
                                    <option value="USD" <?php echo ($settings['currency'] ?? '') === 'USD' ? 'selected' : ''; ?>>USD ($)</option>
                                    <option value="EUR" <?php echo ($settings['currency'] ?? '') === 'EUR' ? 'selected' : ''; ?>>EUR (€)</option>
                                    <option value="GBP" <?php echo ($settings['currency'] ?? '') === 'GBP' ? 'selected' : ''; ?>>GBP (£)</option>
                                    <option value="ZAR" <?php echo ($settings['currency'] ?? '') === 'ZAR' ? 'selected' : ''; ?>>ZAR (R)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Default Base Price</label>
                                <input type="number" step="0.01" name="default_base_price" value="<?php echo htmlspecialchars($settings['default_base_price'] ?? 0); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Insurance Percentage (%)</label>
                                <input type="number" step="0.1" name="insurance_percentage" value="<?php echo htmlspecialchars($settings['insurance_percentage'] ?? 5); ?>">
                                <p class="info-text">Applied to base price when insurance is selected</p>
                            </div>
                            <div class="form-group">
                                <label>Platform Fee Percentage (%)</label>
                                <input type="number" step="0.1" name="platform_fee_percentage" value="<?php echo htmlspecialchars($settings['platform_fee_percentage'] ?? 0); ?>">
                                <p class="info-text">Commission per transaction</p>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Pricing Settings</button>
                    </form>
                </div>

                <!-- Email Settings -->
                <div id="email" class="settings-section">
                    <div class="section-title">Email Settings</div>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_email">
                        
                        <div class="setting-group">
                            <h4>SMTP Configuration</h4>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>SMTP Host</label>
                                    <input type="text" name="smtp_host" value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>" placeholder="mail.example.com">
                                </div>
                                <div class="form-group">
                                    <label>SMTP Port</label>
                                    <input type="number" name="smtp_port" value="<?php echo htmlspecialchars($settings['smtp_port'] ?? 587); ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>SMTP Username</label>
                                    <input type="text" name="smtp_username" value="<?php echo htmlspecialchars($settings['smtp_username'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label>SMTP Password</label>
                                    <input type="password" name="smtp_password" value="">
                                    <p class="info-text">Leave blank to keep existing password</p>
                                </div>
                            </div>
                        </div>

                        <div class="setting-group">
                            <h4>Sender Information</h4>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>From Email Address</label>
                                    <input type="email" name="from_email" value="<?php echo htmlspecialchars($settings['from_email'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label>From Name</label>
                                    <input type="text" name="from_name" value="<?php echo htmlspecialchars($settings['from_name'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Email Settings</button>
                    </form>
                </div>

                <!-- Payment Settings -->
                <div id="payment" class="settings-section">
                    <div class="section-title">Payment Settings</div>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_payment">
                        
                        <div class="setting-group">
                            <h4>PayNow</h4>
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="paynow_enabled" name="paynow_enabled" <?php echo ($settings['paynow_enabled'] ?? 0) ? 'checked' : ''; ?>>
                                    <label for="paynow_enabled" style="margin-bottom: 0;">Enable PayNow</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>PayNow API Key</label>
                                <input type="password" name="paynow_key" value="" placeholder="Enter your PayNow API key">
                            </div>
                        </div>

                        <div class="setting-group">
                            <h4>Stripe</h4>
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="stripe_enabled" name="stripe_enabled" <?php echo ($settings['stripe_enabled'] ?? 0) ? 'checked' : ''; ?>>
                                    <label for="stripe_enabled" style="margin-bottom: 0;">Enable Stripe</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Stripe Publishable Key</label>
                                    <input type="password" name="stripe_public_key" value="" placeholder="pk_...">
                                </div>
                                <div class="form-group">
                                    <label>Stripe Secret Key</label>
                                    <input type="password" name="stripe_secret_key" value="" placeholder="sk_...">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Payment Settings</button>
                    </form>
                </div>

                <!-- Features Settings -->
                <div id="features" class="settings-section">
                    <div class="section-title">Feature Toggles</div>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_features">
                        
                        <div class="setting-group">
                            <h4>Booking Features</h4>
                            
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="enable_guest_booking" name="enable_guest_booking" <?php echo ($settings['enable_guest_booking'] ?? 0) ? 'checked' : ''; ?>>
                                    <label for="enable_guest_booking" style="margin-bottom: 0;">Allow Guest Bookings (No Login Required)</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="enable_instant_booking" name="enable_instant_booking" <?php echo ($settings['enable_instant_booking'] ?? 0) ? 'checked' : ''; ?>>
                                    <label for="enable_instant_booking" style="margin-bottom: 0;">Enable Instant Booking</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="enable_scheduling" name="enable_scheduling" <?php echo ($settings['enable_scheduling'] ?? 0) ? 'checked' : ''; ?>>
                                    <label for="enable_scheduling" style="margin-bottom: 0;">Enable Scheduled Bookings</label>
                                </div>
                            </div>
                        </div>

                        <div class="setting-group">
                            <h4>Verification & Security</h4>
                            
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="require_email_verification" name="require_email_verification" <?php echo ($settings['require_email_verification'] ?? 0) ? 'checked' : ''; ?>>
                                    <label for="require_email_verification" style="margin-bottom: 0;">Require Email Verification</label>
                                </div>
                            </div>
                        </div>

                        <div class="setting-group">
                            <h4>Driver & Operations</h4>
                            
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="auto_assign_driver" name="auto_assign_driver" <?php echo ($settings['auto_assign_driver'] ?? 0) ? 'checked' : ''; ?>>
                                    <label for="auto_assign_driver" style="margin-bottom: 0;">Auto-Assign Drivers (When Available)</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Feature Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navigation between settings sections
        document.querySelectorAll('.setting-nav').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links and sections
                document.querySelectorAll('.setting-nav').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
                
                // Add active class to clicked link and corresponding section
                this.classList.add('active');
                const section = this.getAttribute('href');
                document.querySelector(section).classList.add('active');
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.remove('show');
            });
        }, 5000);
    </script>
</body>
</html>

<?php
/**
 * Database Tables Required:
 * 
 * CREATE TABLE config (
 *     config_id INT PRIMARY KEY AUTO_INCREMENT,
 *     config_key VARCHAR(100) UNIQUE NOT NULL,
 *     config_value TEXT,
 *     config_type VARCHAR(20), -- string, number, boolean, json
 *     description TEXT,
 *     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
 * );
 */
?>


