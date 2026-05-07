<?php
/**
 * Driver Portal Dashboard
 * Main entry point for driver panel
 */

require_once '../../config/bootstrap.php';

// Check driver authentication
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isDriver = isset($_SESSION['driver_id']) || (isset($_SESSION['MM_Username']) && !empty($_SESSION['MM_Username']));
if (!$isDriver) {
    header('Location: signin.php?login_required=1', true, 302);
    exit;
}

$page_title = 'Dashboard';
$site_name = 'WG ROOS Courier';
$driver_name = $_SESSION['driver_name'] ?? 'Driver';

// Get driver statistics
$stats = [
    'available_orders' => 0,
    'active_orders' => 0,
    'completed_orders' => 0,
    'total_earnings' => 0
];

try {
    global $DB;
    
    // Get available orders
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE (assign_driver IS NULL OR assign_driver = '')");
    $stmt->execute();
    $result = $stmt->fetch();
    $stats['available_orders'] = $result['total'] ?? 0;
    
    // Get active orders
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE assign_driver = ? AND status != 'completed'");
    $stmt->execute([$_SESSION['MM_Username'] ?? $_SESSION['driver_id'] ?? '']);
    $result = $stmt->fetch();
    $stats['active_orders'] = $result['total'] ?? 0;
    
    // Get completed orders
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE assign_driver = ? AND status = 'completed'");
    $stmt->execute([$_SESSION['MM_Username'] ?? $_SESSION['driver_id'] ?? '']);
    $result = $stmt->fetch();
    $stats['completed_orders'] = $result['total'] ?? 0;
    
} catch (Exception $e) {
    error_log('Driver dashboard stats error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | <?php echo $site_name; ?></title>
    <?php include 'head.php'; ?>
</head>
<body class="driver-portal">
    
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-content">
            <h2>🚗 Driver Portal</h2>
            <div class="navbar-links">
                <a href="index.php">Dashboard</a>
                <a href="profile.php">My Profile</a>
                <a href="signin.php?logout=true" class="logout">Logout</a>
            </div>
        </div>
    </nav>
    
    <main>
        <div class="driver-container">
            
            <!-- Page Header -->
            <div class="page-header">
                <h1>Welcome, <?php echo htmlspecialchars($driver_name); ?></h1>
                <p>Manage your orders and track earnings from your driver dashboard</p>
            </div>

            <!-- Statistics Grid -->
            <div class="stat-grid">
                <!-- Available Orders -->
                <div class="stat-card">
                    <div class="stat-label">📋 Available Orders</div>
                    <div class="stat-number"><?php echo $stats['available_orders']; ?></div>
                    <a href="available_orders.php" class="stat-link">View available orders →</a>
                </div>

                <!-- Active Orders -->
                <div class="stat-card active">
                    <div class="stat-label">🚗 Active Orders</div>
                    <div class="stat-number"><?php echo $stats['active_orders']; ?></div>
                    <a href="my_orders.php" class="stat-link">View my orders →</a>
                </div>

                <!-- Completed Orders -->
                <div class="stat-card completed">
                    <div class="stat-label">✓ Completed Orders</div>
                    <div class="stat-number"><?php echo $stats['completed_orders']; ?></div>
                    <a href="my_orders.php?status=completed" class="stat-link">View history →</a>
                </div>

                <!-- Earnings -->
                <div class="stat-card earnings">
                    <div class="stat-label">💰 Total Earnings</div>
                    <div class="stat-number">K 0</div>
                    <a href="earnings.php" class="stat-link">View earnings →</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <h2 style="font-size: 24px; font-weight: 600; margin: 30px 0 20px 0;">Quick Actions</h2>
            <div class="action-grid">
                <a href="available_orders.php" class="action-card">
                    <div class="action-icon">📋</div>
                    <h3>Find Orders</h3>
                </a>
                <a href="my_orders.php" class="action-card">
                    <div class="action-icon">🚗</div>
                    <h3>My Orders</h3>
                </a>
                <a href="earnings.php" class="action-card">
                    <div class="action-icon">💰</div>
                    <h3>View Earnings</h3>
                </a>
                <a href="profile.php" class="action-card">
                    <div class="action-icon">👤</div>
                    <h3>My Profile</h3>
                </a>
                <a href="support.php" class="action-card">
                    <div class="action-icon">💬</div>
                    <h3>Support</h3>
                </a>
                <a href="rating.php" class="action-card">
                    <div class="action-icon">⭐</div>
                    <h3>My Ratings</h3>
                </a>
            </div>

        </div>
    </main>

</body>
</html>
