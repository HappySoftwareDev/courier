<?php
/**
 * Admin Portal Dashboard - Main Overview Page
 * Displays key metrics and quick links
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

// If user is trying to logout
if (isset($_GET['doLogout']) && $_GET['doLogout'] === 'true') {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php', true, 302);
    exit;
}

$page_title = 'Dashboard';
$site_name = 'WG ROOS Courier Admin';

// Get statistics
try {
    global $DB;
    
    // Total bookings
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings");
    $stmt->execute();
    $bookingStats = $stmt->fetch();
    $totalBookings = $bookingStats['total'] ?? 0;
    
    // Pending bookings
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE (assign_driver IS NULL OR assign_driver = '')");
    $stmt->execute();
    $pendingStats = $stmt->fetch();
    $pendingBookings = $pendingStats['total'] ?? 0;
    
    // Total drivers
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM driver");
    $stmt->execute();
    $driverStats = $stmt->fetch();
    $totalDrivers = $driverStats['total'] ?? 0;
    
    // Total users
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM users");
    $stmt->execute();
    $userStats = $stmt->fetch();
    $totalUsers = $userStats['total'] ?? 0;
    
} catch (Exception $e) {
    error_log('Dashboard stats error: ' . $e->getMessage());
    $totalBookings = $pendingBookings = $totalDrivers = $totalUsers = 0;
}
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
        .dashboard-card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        }
        .dashboard-card.pending {
            border-left-color: #ffc107;
        }
        .dashboard-card.drivers {
            border-left-color: #28a745;
        }
        .dashboard-card.users {
            border-left-color: #17a2b8;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-icon {
            font-size: 40px;
            color: #667eea;
            margin-bottom: 10px;
        }
        .stat-icon.pending {
            color: #ffc107;
        }
        .stat-icon.drivers {
            color: #28a745;
        }
        .stat-icon.users {
            color: #17a2b8;
        }
        .quick-link {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            margin-right: 10px;
            margin-bottom: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .quick-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            color: white;
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
                            <h1 style="font-size: 32px; font-weight: bold; margin: 0;">Dashboard</h1>
                            <p style="color: #666; margin: 5px 0 0 0;">Welcome back to WG ROOS Admin Panel</p>
                        </div>

                        <!-- Statistics Row -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
                            
                            <!-- Total Bookings -->
                            <div class="dashboard-card">
                                <div class="stat-icon">📦</div>
                                <div class="stat-label">Total Bookings</div>
                                <div class="stat-number"><?php echo $totalBookings; ?></div>
                                <a href="bookings.php" style="font-size: 12px; color: #667eea; text-decoration: none;">View all →</a>
                            </div>

                            <!-- Pending Bookings -->
                            <div class="dashboard-card pending">
                                <div class="stat-icon pending">⏳</div>
                                <div class="stat-label">Pending Bookings</div>
                                <div class="stat-number"><?php echo $pendingBookings; ?></div>
                                <a href="bookings.php?filter=pending" style="font-size: 12px; color: #ffc107; text-decoration: none;">Assign drivers →</a>
                            </div>

                            <!-- Active Drivers -->
                            <div class="dashboard-card drivers">
                                <div class="stat-icon drivers">🚗</div>
                                <div class="stat-label">Total Drivers</div>
                                <div class="stat-number"><?php echo $totalDrivers; ?></div>
                                <a href="drivers.php" style="font-size: 12px; color: #28a745; text-decoration: none;">Manage drivers →</a>
                            </div>

                            <!-- Total Users -->
                            <div class="dashboard-card users">
                                <div class="stat-icon users">👥</div>
                                <div class="stat-label">Total Users</div>
                                <div class="stat-number"><?php echo $totalUsers; ?></div>
                                <a href="users.php" style="font-size: 12px; color: #17a2b8; text-decoration: none;">View users →</a>
                            </div>

                        </div>

                        <!-- Quick Actions -->
                        <div class="dashboard-card">
                            <h3 style="margin-top: 0;">Quick Actions</h3>
                            <a href="bookings.php" class="quick-link">📋 Manage Bookings</a>
                            <a href="users.php" class="quick-link">👥 Manage Users</a>
                            <a href="drivers.php" class="quick-link">🚗 Manage Drivers</a>
                            <a href="reports.php" class="quick-link">📊 View Reports</a>
                            <a href="site_settings.php" class="quick-link">⚙️ Settings</a>
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
