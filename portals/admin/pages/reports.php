<?php
/**
 * Admin Reports & Analytics Page
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

$page_title = 'Reports & Analytics';
$site_name = 'WG ROOS Courier Admin';

// Get statistics
$totalBookings = $totalUsers = $totalDrivers = $totalRevenue = 0;
$completedBookings = $pendingBookings = 0;

try {
    global $DB;
    
    // Total bookings
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings");
    $stmt->execute();
    $result = $stmt->fetch();
    $totalBookings = $result['total'] ?? 0;
    
    // Completed bookings
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE status = 'completed'");
    $stmt->execute();
    $result = $stmt->fetch();
    $completedBookings = $result['total'] ?? 0;
    
    // Pending bookings
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE assign_driver IS NULL OR assign_driver = ''");
    $stmt->execute();
    $result = $stmt->fetch();
    $pendingBookings = $result['total'] ?? 0;
    
    // Total users
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM users");
    $stmt->execute();
    $result = $stmt->fetch();
    $totalUsers = $result['total'] ?? 0;
    
    // Total drivers
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM driver");
    $stmt->execute();
    $result = $stmt->fetch();
    $totalDrivers = $result['total'] ?? 0;
    
} catch (Exception $e) {
    error_log('Reports stats error: ' . $e->getMessage());
}

$completionRate = $totalBookings > 0 ? round(($completedBookings / $totalBookings) * 100, 1) : 0;
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
        .report-card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-label {
            font-size: 12px;
            opacity: 0.9;
            text-transform: uppercase;
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
                            <h1 style="font-size: 32px; font-weight: bold; margin: 0;">Reports & Analytics</h1>
                            <p style="color: #666; margin: 5px 0 0 0;">Key performance indicators and system statistics</p>
                        </div>

                        <!-- Statistics Grid -->
                        <div class="stat-grid">
                            <div class="stat-item">
                                <div class="stat-label">Total Bookings</div>
                                <div class="stat-number"><?php echo $totalBookings; ?></div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Completed</div>
                                <div class="stat-number"><?php echo $completedBookings; ?></div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Pending</div>
                                <div class="stat-number"><?php echo $pendingBookings; ?></div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Completion Rate</div>
                                <div class="stat-number"><?php echo $completionRate; ?>%</div>
                            </div>
                        </div>

                        <!-- Additional Statistics -->
                        <div class="stat-grid">
                            <div class="stat-item" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                <div class="stat-label">Total Users</div>
                                <div class="stat-number"><?php echo $totalUsers; ?></div>
                            </div>
                            <div class="stat-item" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                                <div class="stat-label">Total Drivers</div>
                                <div class="stat-number"><?php echo $totalDrivers; ?></div>
                            </div>
                            <div class="stat-item" style="background: linear-gradient(135deg, #17a2b8 0%, #00bcd4 100%);">
                                <div class="stat-label">Users/Drivers Ratio</div>
                                <div class="stat-number"><?php echo $totalDrivers > 0 ? round($totalUsers / $totalDrivers, 1) : 0; ?>:1</div>
                            </div>
                            <div class="stat-item" style="background: linear-gradient(135deg, #e83e8c 0%, #d63384 100%);">
                                <div class="stat-label">Avg per Driver</div>
                                <div class="stat-number"><?php echo $totalDrivers > 0 ? round($totalBookings / $totalDrivers, 1) : 0; ?></div>
                            </div>
                        </div>

                        <!-- Summary Report -->
                        <div class="report-card">
                            <h2 style="margin-top: 0;">System Summary</h2>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border-bottom: 1px solid #e9ecef;">
                                    <td style="padding: 12px 0;"><strong>Total Bookings</strong></td>
                                    <td style="padding: 12px 0; text-align: right;"><?php echo $totalBookings; ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e9ecef;">
                                    <td style="padding: 12px 0;"><strong>Completed Bookings</strong></td>
                                    <td style="padding: 12px 0; text-align: right;"><?php echo $completedBookings; ?> (<?php echo $completionRate; ?>%)</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e9ecef;">
                                    <td style="padding: 12px 0;"><strong>Pending Bookings</strong></td>
                                    <td style="padding: 12px 0; text-align: right;"><?php echo $pendingBookings; ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e9ecef;">
                                    <td style="padding: 12px 0;"><strong>Registered Users</strong></td>
                                    <td style="padding: 12px 0; text-align: right;"><?php echo $totalUsers; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0;"><strong>Active Drivers</strong></td>
                                    <td style="padding: 12px 0; text-align: right;"><?php echo $totalDrivers; ?></td>
                                </tr>
                            </table>
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
