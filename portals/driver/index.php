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
$driver_name = $_SESSION['driver_name'] ?? $_SESSION['MM_Username'] ?? 'Driver';

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
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE assign_driver = ? AND status NOT IN ('completed', 'cancelled')");
    $stmt->execute([$_SESSION['MM_Username'] ?? $_SESSION['driver_id'] ?? '']);
    $result = $stmt->fetch();
    $stats['active_orders'] = $result['total'] ?? 0;
    
    // Get completed orders
    $stmt = $DB->prepare("SELECT COUNT(*) as total FROM bookings WHERE assign_driver = ? AND status = 'completed'");
    $stmt->execute([$_SESSION['MM_Username'] ?? $_SESSION['driver_id'] ?? '']);
    $result = $stmt->fetch();
    $stats['completed_orders'] = $result['total'] ?? 0;
    
    // Get total earnings (placeholder - would need booking_payment table structure)
    $stats['total_earnings'] = 0;
    
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
    <?php include 'header.php'; ?>
    
    <main class="main-wrapper">
        <section class="section">
            <div class="container-fluid">
                
                <!-- Page Header -->
                <div class="page-header mb-40">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1 class="mb-10">Welcome, <?php echo htmlspecialchars($driver_name); ?>! 🚗</h1>
                            <p class="text-muted">Manage your delivery orders and track your earnings from your driver dashboard</p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="profile.php" class="btn btn-outline-primary me-2">
                                <i class="lni lni-user"></i> My Profile
                            </a>
                            <a href="signin.php?logout=true" class="btn btn-outline-danger">
                                <i class="lni lni-exit"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistics Grid -->
                <div class="row g-4 mb-40">
                    <!-- Available Orders Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="card-title mb-0">Available Orders</h6>
                                    <span class="badge bg-info">
                                        <i class="lni lni-inbox"></i>
                                    </span>
                                </div>
                                <h2 class="card-text text-primary mb-3"><?php echo $stats['available_orders']; ?></h2>
                                <a href="available_orders.php" class="btn btn-sm btn-primary">
                                    View Orders <i class="lni lni-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Active Orders Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="card-title mb-0">Active Orders</h6>
                                    <span class="badge bg-warning">
                                        <i class="lni lni-delivery"></i>
                                    </span>
                                </div>
                                <h2 class="card-text text-warning mb-3"><?php echo $stats['active_orders']; ?></h2>
                                <a href="accepted_orders.php" class="btn btn-sm btn-warning">
                                    Manage Orders <i class="lni lni-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Orders Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="card-title mb-0">Completed Orders</h6>
                                    <span class="badge bg-success">
                                        <i class="lni lni-check-mark"></i>
                                    </span>
                                </div>
                                <h2 class="card-text text-success mb-3"><?php echo $stats['completed_orders']; ?></h2>
                                <a href="completedOrders.php" class="btn btn-sm btn-success">
                                    View History <i class="lni lni-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Total Earnings Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="card-title mb-0">Total Earnings</h6>
                                    <span class="badge bg-success">
                                        <i class="lni lni-money-wallet"></i>
                                    </span>
                                </div>
                                <h2 class="card-text text-success mb-3">ZWL <?php echo number_format($stats['total_earnings'], 2); ?></h2>
                                <a href="profile.php" class="btn btn-sm btn-outline-success">
                                    View Earnings <i class="lni lni-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <a href="new_orders.php" class="text-decoration-none">
                                            <div class="p-3 border rounded text-center hover-effect" style="cursor: pointer; transition: all 0.3s ease;">
                                                <div class="mb-2">
                                                    <i class="lni lni-briefcase text-primary" style="font-size: 32px;"></i>
                                                </div>
                                                <h6>Available Deliveries</h6>
                                                <p class="text-muted small">Pick up new orders</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="accepted_orders.php" class="text-decoration-none">
                                            <div class="p-3 border rounded text-center hover-effect" style="cursor: pointer; transition: all 0.3s ease;">
                                                <div class="mb-2">
                                                    <i class="lni lni-map text-warning" style="font-size: 32px;"></i>
                                                </div>
                                                <h6>Track Orders</h6>
                                                <p class="text-muted small">View current deliveries</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="profile.php" class="text-decoration-none">
                                            <div class="p-3 border rounded text-center hover-effect" style="cursor: pointer; transition: all 0.3s ease;">
                                                <div class="mb-2">
                                                    <i class="lni lni-user text-success" style="font-size: 32px;"></i>
                                                </div>
                                                <h6>My Profile</h6>
                                                <p class="text-muted small">Update your details</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Footer Scripts -->
    <?php include 'footer_scripts.php'; ?>

    <style>
        .hover-effect:hover {
            background-color: #f8f9fa !important;
            border-color: #667eea !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }
    </style>

</body>
</html>
