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
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #28a745;
            --warning: #ffc107;
            --info: #17a2b8;
            --light: #f8f9fa;
            --dark: #333;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            min-height: 100vh;
            color: #333;
        }
        
        .driver-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .page-header {
            margin-bottom: 40px;
        }
        
        .page-header h1 {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .page-header p {
            color: #666;
            font-size: 16px;
        }
        
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 5px solid var(--primary);
        }
        
        .stat-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            transform: translateY(-4px);
        }
        
        .stat-card.active {
            border-left-color: var(--success);
        }
        
        .stat-card.completed {
            border-left-color: var(--info);
        }
        
        .stat-card.earnings {
            border-left-color: var(--warning);
        }
        
        .stat-label {
            font-size: 14px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
        }
        
        .stat-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }
        
        .stat-link:hover {
            text-decoration: underline;
        }
        
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .action-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .action-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
            color: inherit;
            text-decoration: none;
        }
        
        .action-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }
        
        .action-card h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 0;
            margin-bottom: 30px;
        }
        
        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar h2 {
            font-size: 24px;
            color: var(--primary);
            margin: 0;
        }
        
        .navbar-links {
            display: flex;
            gap: 20px;
        }
        
        .navbar-links a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .navbar-links a:hover {
            color: var(--primary);
        }
        
        .navbar-links a.logout {
            color: #dc3545;
        }
    </style>
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
