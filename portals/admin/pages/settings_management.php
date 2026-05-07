<?php
/**
 * Admin Settings Management Page
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

$page_title = 'System Settings';
$site_name = 'WG ROOS Courier Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | <?php echo $site_name; ?></title>
    <?php include 'head.php'; ?>
    <style>
        body {
            background: #f8f9fa;
        }
        .settings-card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .settings-section {
            margin-bottom: 30px;
        }
        .settings-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .setting-item:last-child {
            border-bottom: none;
        }
        .setting-label {
            font-weight: 500;
            color: #333;
        }
        .setting-value {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body class="admin-portal">
    <div class="page-container">
        <!-- Sidebar Navigation -->
        <?php include '../sidebar-nav-menu.php'; ?>
        
        <!-- Main Content Wrapper -->
        <div class="main-content">
            <!-- Header -->
            <?php include '../header.php'; ?>
            
            <!-- Main Content -->
            <main class="main-wrapper">
                <section class="section">
                    <div class="container-fluid" style="padding: 30px;">
                        
                        <!-- Page Title -->
                        <div style="margin-bottom: 30px;">
                            <h1 style="font-size: 32px; font-weight: bold; margin: 0;">System Settings</h1>
                            <p style="color: #666; margin: 5px 0 0 0;">Configure system-wide settings and preferences</p>
                        </div>

                        <!-- General Settings -->
                        <div class="settings-card">
                            <div class="settings-section">
                                <h3>General Settings</h3>
                                <div class="setting-item">
                                    <span class="setting-label">Application Name</span>
                                    <span class="setting-value">WG ROOS Courier</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Support Email</span>
                                    <span class="setting-value">support@wgroos.com</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Support Phone</span>
                                    <span class="setting-value">+265999999999</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Currency</span>
                                    <span class="setting-value">MWK</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Timezone</span>
                                    <span class="setting-value">Africa/Blantyre</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Settings -->
                        <div class="settings-card">
                            <div class="settings-section">
                                <h3>Payment Settings</h3>
                                <div class="setting-item">
                                    <span class="setting-label">Payment Gateway</span>
                                    <span class="setting-value">PayNow</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Platform Fee (%)</span>
                                    <span class="setting-value">15%</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Insurance (%)</span>
                                    <span class="setting-value">10%</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Emergency Surcharge (%)</span>
                                    <span class="setting-value">25%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Settings -->
                        <div class="settings-card">
                            <div class="settings-section">
                                <h3>Pricing Settings</h3>
                                <div class="setting-item">
                                    <span class="setting-label">Base Price - Parcel</span>
                                    <span class="setting-value">K 500</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Base Price - Freight</span>
                                    <span class="setting-value">K 2000</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Base Price - Taxi</span>
                                    <span class="setting-value">K 300</span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Price Per KM</span>
                                    <span class="setting-value">K 50</span>
                                </div>
                            </div>
                        </div>

                        <!-- System Status -->
                        <div class="settings-card">
                            <div class="settings-section">
                                <h3>System Status</h3>
                                <div class="setting-item">
                                    <span class="setting-label">Maintenance Mode</span>
                                    <span class="setting-value" style="color: #28a745;"><strong>✓ Disabled</strong></span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Database Connection</span>
                                    <span class="setting-value" style="color: #28a745;"><strong>✓ Connected</strong></span>
                                </div>
                                <div class="setting-item">
                                    <span class="setting-label">Session Management</span>
                                    <span class="setting-value" style="color: #28a745;"><strong>✓ Active</strong></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </main>

            <!-- Footer -->
            <?php include '../footer.php'; ?>
        </div>
    </div>

    <?php include '../footerscripts.php'; ?>
</body>
</html>
