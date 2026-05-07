<?php
/**
 * Admin Portal Dashboard
 * Main entry point for admin panel
 */

require_once '../../config/bootstrap.php';

// Check admin authentication
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['admin_id']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
if (!$isAdmin) {
    header('Location: pages/login.php?login_required=1', true, 302);
    exit;
}

$page_title = 'Dashboard';
$site_name = 'WG ROOS Courier Admin';

// Get statistics from database
$stats = [
    'bookings' => 0,
    'pending' => 0,
    'users' => 0,
    'drivers' => 0
];

try {
    global $DB;
    
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings");
    $stmt->execute();
    $result = $stmt->fetch();
    $stats['bookings'] = $result['total'] ?? 0;
    
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE assign_driver IS NULL OR assign_driver = ''");
    $stmt->execute();
    $result = $stmt->fetch();
    $stats['pending'] = $result['total'] ?? 0;
    
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM users");
    $stmt->execute();
    $result = $stmt->fetch();
    $stats['users'] = $result['total'] ?? 0;
    
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM driver");
    $stmt->execute();
    $result = $stmt->fetch();
    $stats['drivers'] = $result['total'] ?? 0;
    
} catch (Exception $e) {
    error_log('Dashboard stats error: ' . $e->getMessage());
}

// Load site settings
if (file_exists('pages/site_settings.php')) {
    include('pages/site_settings.php');
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
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
            --light: #f8f9fa;
            --dark: #333;
        }
        
        body {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            min-height: 100vh;
        }
        
        .admin-container {
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
            margin: 0 0 10px 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .page-header p {
            color: #666;
            font-size: 16px;
            margin: 0;
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
        
        .stat-card.pending {
            border-left-color: var(--warning);
        }
        
        .stat-card.drivers {
            border-left-color: var(--success);
        }
        
        .stat-card.users {
            border-left-color: var(--info);
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
            color: var(--primary);
        }
        
        .action-card h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }
        
        .container {
            max-width: 1400px;
        }
    </style>
</head>
<body class="admin-portal">
    
    <!-- Navigation -->
    <?php include 'header.php'; ?>
    
    <main class="main-wrapper">
        <section class="section">
            <div class="container">
                <div class="admin-container">
                    
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1>Dashboard</h1>
                        <p>Welcome to WG ROOS Courier Administration Panel</p>
                    </div>

                    <!-- Statistics Grid -->
                    <div class="stat-grid">
                        <!-- Total Bookings -->
                        <div class="stat-card">
                            <div class="stat-label">📦 Total Bookings</div>
                            <div class="stat-number"><?php echo $stats['bookings']; ?></div>
                            <a href="pages/bookings.php" class="stat-link">View all bookings →</a>
                        </div>

                        <!-- Pending Bookings -->
                        <div class="stat-card pending">
                            <div class="stat-label">⏳ Pending Assignments</div>
                            <div class="stat-number"><?php echo $stats['pending']; ?></div>
                            <a href="pages/bookings.php?filter=pending" class="stat-link">Assign drivers →</a>
                        </div>

                        <!-- Total Users -->
                        <div class="stat-card users">
                            <div class="stat-label">👥 Registered Users</div>
                            <div class="stat-number"><?php echo $stats['users']; ?></div>
                            <a href="pages/users.php" class="stat-link">Manage users →</a>
                        </div>

                        <!-- Active Drivers -->
                        <div class="stat-card drivers">
                            <div class="stat-label">🚗 Total Drivers</div>
                            <div class="stat-number"><?php echo $stats['drivers']; ?></div>
                            <a href="pages/drivers.php" class="stat-link">Manage drivers →</a>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <h2 style="font-size: 24px; font-weight: 600; margin: 30px 0 20px 0;">Quick Actions</h2>
                    <div class="action-grid">
                        <a href="pages/bookings.php" class="action-card">
                            <div class="action-icon">📋</div>
                            <h3>Manage Bookings</h3>
                        </a>
                        <a href="pages/users.php" class="action-card">
                            <div class="action-icon">👥</div>
                            <h3>Manage Users</h3>
                        </a>
                        <a href="pages/drivers.php" class="action-card">
                            <div class="action-icon">🚗</div>
                            <h3>Manage Drivers</h3>
                        </a>
                        <a href="pages/reports.php" class="action-card">
                            <div class="action-icon">📊</div>
                            <h3>View Reports</h3>
                        </a>
                        <a href="pages/system_health.php" class="action-card">
                            <div class="action-icon">⚙️</div>
                            <h3>System Health</h3>
                        </a>
                        <a href="pages/settings_management.php" class="action-card">
                            <div class="action-icon">⚙️</div>
                            <h3>Settings</h3>
                        </a>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <?php include 'footerscripts.php'; ?>

</body>
</html>
