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
                    <div class="container-fluid">
                        
                        <!-- Page Header -->
                        <div class="page-header mb-40">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h1 class="mb-10">Reports & Analytics</h1>
                                    <p class="text-muted">Key performance indicators and system statistics</p>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Grid - Bookings Section -->
                        <div class="row g-4 mb-40">
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="card-title mb-0">Total Bookings</h6>
                                            <span class="badge bg-primary"><i class="lni lni-package"></i></span>
                                        </div>
                                        <h2 class="card-text text-primary"><?php echo $totalBookings; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="card-title mb-0">Completed</h6>
                                            <span class="badge bg-success"><i class="lni lni-check-mark"></i></span>
                                        </div>
                                        <h2 class="card-text text-success"><?php echo $completedBookings; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="card-title mb-0">Pending</h6>
                                            <span class="badge bg-warning"><i class="lni lni-timer"></i></span>
                                        </div>
                                        <h2 class="card-text text-warning"><?php echo $pendingBookings; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="card-title mb-0">Completion Rate</h6>
                                            <span class="badge bg-info"><i class="lni lni-chart"></i></span>
                                        </div>
                                        <h2 class="card-text text-info"><?php echo $completionRate; ?>%</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Grid - Users & Drivers Section -->
                        <div class="row g-4 mb-40">
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="card-title mb-0">Total Users</h6>
                                            <span class="badge bg-success"><i class="lni lni-users"></i></span>
                                        </div>
                                        <h2 class="card-text text-success"><?php echo $totalUsers; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="card-title mb-0">Total Drivers</h6>
                                            <span class="badge bg-warning"><i class="lni lni-car"></i></span>
                                        </div>
                                        <h2 class="card-text text-warning"><?php echo $totalDrivers; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="card-title mb-0">Users/Drivers Ratio</h6>
                                            <span class="badge bg-info"><i class="lni lni-chart"></i></span>
                                        </div>
                                        <h2 class="card-text text-info"><?php echo $totalDrivers > 0 ? round($totalUsers / $totalDrivers, 1) : 0; ?>:1</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="card-title mb-0">Avg Bookings/Driver</h6>
                                            <span class="badge bg-secondary"><i class="lni lni-chart"></i></span>
                                        </div>
                                        <h2 class="card-text text-secondary"><?php echo $totalDrivers > 0 ? round($totalBookings / $totalDrivers, 1) : 0; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Report Table -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="mb-0">System Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <td><strong>Total Bookings</strong></td>
                                                <td class="text-end"><h6 class="mb-0"><?php echo $totalBookings; ?></h6></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Completed Bookings</strong></td>
                                                <td class="text-end"><h6 class="mb-0"><?php echo $completedBookings; ?> (<?php echo $completionRate; ?>%)</h6></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pending Bookings</strong></td>
                                                <td class="text-end"><h6 class="mb-0"><?php echo $pendingBookings; ?></h6></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Registered Users</strong></td>
                                                <td class="text-end"><h6 class="mb-0"><?php echo $totalUsers; ?></h6></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Active Drivers</strong></td>
                                                <td class="text-end"><h6 class="mb-0"><?php echo $totalDrivers; ?></h6></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
