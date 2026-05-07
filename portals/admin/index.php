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
</head>
<body class="admin-portal">
    
    <!-- Navigation -->
    <?php include 'header.php'; ?>
    
    <main class="main-wrapper">
        <section class="section">
            <div class="container">
                <div class="admin-container">
                    
                    <!-- Page Header -->
                    <div class="page-header mb-40">
                        <div class="row">
                            <div class="col-lg-8">
                                <h1 class="mb-10">Dashboard</h1>
                                <p class="text-muted">Welcome to WG ROOS Courier Administration Panel</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Grid -->
                    <div class="row g-4 mb-40">
                        <!-- Total Bookings -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="card-title mb-0">Total Bookings</h6>
                                        <span class="badge bg-primary"><i class="lni lni-package"></i></span>
                                    </div>
                                    <h2 class="card-text text-primary mb-3"><?php echo $stats['bookings']; ?></h2>
                                    <a href="pages/bookings.php" class="btn btn-sm btn-primary">View all <i class="lni lni-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Bookings -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="card-title mb-0">Pending Assignments</h6>
                                        <span class="badge bg-warning"><i class="lni lni-timer"></i></span>
                                    </div>
                                    <h2 class="card-text text-warning mb-3"><?php echo $stats['pending']; ?></h2>
                                    <a href="pages/bookings.php?filter=pending" class="btn btn-sm btn-warning">Assign drivers <i class="lni lni-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Total Users -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="card-title mb-0">Registered Users</h6>
                                        <span class="badge bg-info"><i class="lni lni-users"></i></span>
                                    </div>
                                    <h2 class="card-text text-info mb-3"><?php echo $stats['users']; ?></h2>
                                    <a href="pages/users.php" class="btn btn-sm btn-info">Manage users <i class="lni lni-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Total Drivers -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="card-title mb-0">Total Drivers</h6>
                                        <span class="badge bg-success"><i class="lni lni-car"></i></span>
                                    </div>
                                    <h2 class="card-text text-success mb-3"><?php echo $stats['drivers']; ?></h2>
                                    <a href="pages/drivers.php" class="btn btn-sm btn-success">Manage drivers <i class="lni lni-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <h2 class="mb-30">Quick Actions</h2>
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <a href="pages/bookings.php" class="text-decoration-none">
                                <div class="card h-100 shadow-sm border-0 hover-card">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3" style="font-size: 36px;">📋</div>
                                        <h5 class="card-title">Manage Bookings</h5>
                                        <p class="card-text text-muted small">View and manage all bookings</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <a href="pages/users.php" class="text-decoration-none">
                                <div class="card h-100 shadow-sm border-0 hover-card">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3" style="font-size: 36px;">👥</div>
                                        <h5 class="card-title">Manage Users</h5>
                                        <p class="card-text text-muted small">Manage customer accounts</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <a href="pages/drivers.php" class="text-decoration-none">
                                <div class="card h-100 shadow-sm border-0 hover-card">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3" style="font-size: 36px;">🚗</div>
                                        <h5 class="card-title">Manage Drivers</h5>
                                        <p class="card-text text-muted small">Manage driver accounts</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <a href="pages/reports.php" class="text-decoration-none">
                                <div class="card h-100 shadow-sm border-0 hover-card">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3" style="font-size: 36px;">📊</div>
                                        <h5 class="card-title">View Reports</h5>
                                        <p class="card-text text-muted small">Analytics and statistics</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <a href="pages/system_health.php" class="text-decoration-none">
                                <div class="card h-100 shadow-sm border-0 hover-card">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3" style="font-size: 36px;">⚙️</div>
                                        <h5 class="card-title">System Health</h5>
                                        <p class="card-text text-muted small">Check system status</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <a href="pages/settings_management.php" class="text-decoration-none">
                                <div class="card h-100 shadow-sm border-0 hover-card">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3" style="font-size: 36px;">⚙️</div>
                                        <h5 class="card-title">Settings</h5>
                                        <p class="card-text text-muted small">Configure system settings</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <style>
                        .hover-card {
                            transition: all 0.3s ease;
                        }
                        .hover-card:hover {
                            transform: translateY(-4px);
                            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
                        }
                    </style>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <?php include 'footerscripts.php'; ?>

</body>
</html>
