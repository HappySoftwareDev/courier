<?php
/**
 * Admin Portal Dashboard
 * Main entry point for admin panel
 */

require_once '../../config/bootstrap.php';

// Check admin authentication - must be before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Admin authentication check
$isAdmin = isset($_SESSION['admin_id']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
if (!$isAdmin) {
    // Redirect to admin login
    $adminLoginFile = __DIR__ . '/pages/login.php';
    $adminLoginPath = file_exists($adminLoginFile) ? 'pages/login.php' : '../booking/signin.php';
    header('Location: ' . $adminLoginPath, true, 302);
    exit;
}

// Set variables for layout
$page_title = 'Dashboard';
$site_name = 'WG ROOS Courier Admin';
$logo = 'logo.png'; // Default logo filename
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $page_title; ?> | <?php echo $site_name; ?></title>
    <?php include 'head.php'; ?>
</head>

<body class="admin-portal">

    <div class="page-container">
        
        <!-- Sidebar Navigation -->
        <?php include 'sidebar-nav-menu.php'; ?>
        
        <!-- Main Content Wrapper -->
        <div class="main-content">
            
            <!-- Header -->
            <?php include 'header.php'; ?>
            
            <!-- Main Content Area -->
            <main class="main-wrapper">
                <section class="section">
                    <div class="container-fluid">
                        
                        <!-- Page Header -->
                        <div class="page-header mb-40">
                            <h1><?php echo $page_title; ?></h1>
                            <p class="text-muted">Welcome to WG ROOS Courier Admin Dashboard</p>
                        </div>

                        <!-- Dashboard Stats Row -->
                        <div class="row mb-40">
                            <!-- Total Sales Card -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="card card-stats mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="text-muted mb-1">Total USD Sales</p>
                                                <h3 class="mb-0"><?php echo getCountTotalSales(); ?></h3>
                                            </div>
                                            <span class="badge bg-primary">
                                                <i class="lni lni-dollar"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">All-time earnings from completed bookings</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Business Partners Card -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="card card-stats mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="text-muted mb-1">Business Partners</p>
                                                <h3 class="mb-0"><?php echo getCountAllSellers(); ?></h3>
                                            </div>
                                            <span class="badge bg-success">
                                                <i class="lni lni-users"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">Active registered partners</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Drivers Card -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="card card-stats mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="text-muted mb-1">Total Drivers</p>
                                                <h3 class="mb-0"><?php echo getCountAllDrivers(); ?></h3>
                                            </div>
                                            <span class="badge bg-info">
                                                <i class="lni lni-car"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">Registered delivery drivers</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Orders Card -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="card card-stats mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="text-muted mb-1">Total Bookings</p>
                                                <h3 class="mb-0"><?php echo getCountAllOrders(); ?></h3>
                                            </div>
                                            <span class="badge bg-warning">
                                                <i class="lni lni-package"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">Total bookings processed</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Secondary Stats Row -->
                        <div class="row mb-40">
                            <!-- New Orders Card -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="card card-stats mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="text-muted mb-1">New Orders</p>
                                                <h3 class="mb-0"><?php echo getCountNewOrders(); ?></h3>
                                            </div>
                                            <span class="badge bg-primary">
                                                <i class="lni lni-inbox"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">Pending driver assignment</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Cancelled Orders Card -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="card card-stats mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="text-muted mb-1">Cancelled Orders</p>
                                                <h3 class="mb-0"><?php echo getCountCancelledOrders(); ?></h3>
                                            </div>
                                            <span class="badge bg-danger">
                                                <i class="lni lni-close"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">Cancelled bookings</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Bookings Card -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="card card-stats mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="text-muted mb-1">Total Bookings</p>
                                                <h3 class="mb-0"><?php echo getCountTotalBookings(); ?></h3>
                                            </div>
                                            <span class="badge bg-success">
                                                <i class="lni lni-checkmark-circle"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted">All booking count</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Bookings Table -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Recent Bookings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Job #</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php getBookings(); ?>
                                                </tbody>
                                            </table>
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

        </div>

    </div>

    <!-- Scripts -->
    <?php include 'footerscripts.php'; ?>

</body>

</html>


