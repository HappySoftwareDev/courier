<?php
/**
 * Admin Reports & Analytics Dashboard
 * Comprehensive reporting and analytics for the courier platform
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

// Set variables for layout
$page_title = 'Reports & Analytics';
$site_name = 'WG ROOS Courier Admin';

// Make sure functions are available
if (!function_exists('getCountTotalSales')) {
    require_once '../../../function.php';
}

// Get selected report type and date range
$reportType = $_GET['type'] ?? 'overview';
$dateFrom = $_GET['from'] ?? date('Y-m-01');
$dateTo = $_GET['to'] ?? date('Y-m-d');

// Initialize data arrays
$reportData = [];
$chartData = [];

try {
    global $DB;
    
    // Build date condition
    $dateCondition = " AND DATE(created_at) >= ? AND DATE(created_at) <= ?";
    $dateParams = [$dateFrom, $dateTo];
    
    // 1. Sales Overview
    $salesQuery = "SELECT 
                    COUNT(*) as total_bookings, 
                    SUM(Total_price) as total_revenue,
                    AVG(Total_price) as avg_booking_value,
                    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_bookings,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_bookings
                   FROM bookings
                   WHERE 1=1" . $dateCondition;
    
    $stmt = $DB->prepare($salesQuery);
    $stmt->execute($dateParams);
    $reportData['sales'] = $stmt->fetch();
    
    // 2. Revenue by Status
    $revenueByStatusQuery = "SELECT 
                            status, 
                            COUNT(*) as count, 
                            SUM(Total_price) as revenue
                           FROM bookings
                           WHERE 1=1" . $dateCondition . "
                           GROUP BY status";
    
    $stmt = $DB->prepare($revenueByStatusQuery);
    $stmt->execute($dateParams);
    $reportData['revenueByStatus'] = $stmt->fetchAll();
    
    // 3. Top Routes (by number of bookings)
    $topRoutesQuery = "SELECT 
                      pickup_location, 
                      delivery_location,
                      COUNT(*) as bookings,
                      SUM(Total_price) as revenue
                     FROM bookings
                     WHERE 1=1" . $dateCondition . "
                     GROUP BY pickup_location, delivery_location
                     ORDER BY bookings DESC
                     LIMIT 10";
    
    $stmt = $DB->prepare($topRoutesQuery);
    $stmt->execute($dateParams);
    $reportData['topRoutes'] = $stmt->fetchAll();
    
    // 4. Driver Performance
    $driverPerformanceQuery = "SELECT 
                             b.assign_driver,
                             COUNT(*) as completed_deliveries,
                             SUM(CASE WHEN b.status = 'completed' THEN 1 ELSE 0 END) as successful_deliveries,
                             AVG(CASE WHEN b.status = 'completed' THEN 1 ELSE 0 END) * 100 as success_rate,
                             SUM(b.Total_price) as total_revenue
                            FROM bookings b
                            WHERE b.assign_driver IS NOT NULL AND b.assign_driver != ''" . $dateCondition . "
                            GROUP BY b.assign_driver
                            ORDER BY completed_deliveries DESC
                            LIMIT 10";
    
    $stmt = $DB->prepare($driverPerformanceQuery);
    $stmt->execute($dateParams);
    $reportData['driverPerformance'] = $stmt->fetchAll();
    
    // 5. Customer Metrics
    $customerMetricsQuery = "SELECT 
                           COUNT(DISTINCT username) as total_customers,
                           COUNT(DISTINCT CASE WHEN status = 'completed' THEN username END) as active_customers,
                           COUNT(*) as total_bookings
                          FROM bookings
                          WHERE 1=1" . $dateCondition;
    
    $stmt = $DB->prepare($customerMetricsQuery);
    $stmt->execute($dateParams);
    $reportData['customers'] = $stmt->fetch();
    
    // 6. Daily Revenue Trend (for chart)
    $dailyTrendQuery = "SELECT 
                       DATE(created_at) as date,
                       COUNT(*) as bookings,
                       SUM(Total_price) as revenue
                      FROM bookings
                      WHERE 1=1" . $dateCondition . "
                      GROUP BY DATE(created_at)
                      ORDER BY date ASC";
    
    $stmt = $DB->prepare($dailyTrendQuery);
    $stmt->execute($dateParams);
    $reportData['dailyTrend'] = $stmt->fetchAll();
    
    // 7. Vehicle Type Distribution
    $vehicleTypeQuery = "SELECT 
                       vehicle_type,
                       COUNT(*) as count,
                       SUM(Total_price) as revenue
                      FROM bookings
                      WHERE 1=1" . $dateCondition . "
                      GROUP BY vehicle_type
                      ORDER BY count DESC";
    
    $stmt = $DB->prepare($vehicleTypeQuery);
    $stmt->execute($dateParams);
    $reportData['vehicleTypes'] = $stmt->fetchAll();
    
} catch (Exception $e) {
    error_log('Reports query error: ' . $e->getMessage());
}

// Prepare chart data
if (!empty($reportData['dailyTrend'])) {
    $dates = [];
    $revenues = [];
    foreach ($reportData['dailyTrend'] as $day) {
        $dates[] = $day['date'];
        $revenues[] = $day['revenue'];
    }
    $chartData['dailyTrend'] = [
        'dates' => json_encode($dates),
        'revenues' => json_encode($revenues)
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $page_title; ?> | <?php echo $site_name; ?></title>
    <?php include '../head.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>

<body class="admin-portal">

    <div class="page-container">
        
        <!-- Sidebar Navigation -->
        <?php include '../sidebar-nav-menu.php'; ?>
        
        <!-- Main Content Wrapper -->
        <div class="main-content">
            
            <!-- Header -->
            <?php include '../header.php'; ?>
            
            <!-- Main Content Area -->
            <main class="main-wrapper">
                <section class="section">
                    <div class="container-fluid">
                        
                        <!-- Page Header -->
                        <div class="page-header mb-40">
                            <h1><?php echo $page_title; ?></h1>
                            <p class="text-muted">Analytics and performance metrics for your courier platform</p>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="card mb-40">
                            <div class="card-body">
                                <form method="GET" action="" class="row align-items-end gap-3">
                                    <div class="col-md-3">
                                        <label class="form-label">From Date</label>
                                        <input type="date" name="from" class="form-control" value="<?php echo htmlspecialchars($dateFrom); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">To Date</label>
                                        <input type="date" name="to" class="form-control" value="<?php echo htmlspecialchars($dateTo); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Filter Report</button>
                                        <a href="reports.php" class="btn btn-secondary">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- KPI Cards -->
                        <div class="row gap-3 mb-40">
                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-primary">
                                                <i class="lni lni-package"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Total Bookings</h6>
                                                <h3 class="mb-0"><?php echo htmlspecialchars($reportData['sales']['total_bookings'] ?? 0); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-success">
                                                <i class="lni lni-money-location"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Total Revenue</h6>
                                                <h3 class="mb-0">$<?php echo number_format($reportData['sales']['total_revenue'] ?? 0, 2); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-info">
                                                <i class="lni lni-checkmark-circle"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Completed</h6>
                                                <h3 class="mb-0"><?php echo htmlspecialchars($reportData['sales']['completed_bookings'] ?? 0); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-warning">
                                                <i class="lni lni-users"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Active Customers</h6>
                                                <h3 class="mb-0"><?php echo htmlspecialchars($reportData['customers']['active_customers'] ?? 0); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Trend Chart -->
                        <?php if (!empty($reportData['dailyTrend'])): ?>
                        <div class="card mb-40">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Revenue Trend</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart" height="80"></canvas>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="row gap-3 mb-40">
                            <!-- Revenue by Status -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Bookings by Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Count</th>
                                                        <th>Revenue</th>
                                                        <th>%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $totalBookings = $reportData['sales']['total_bookings'] ?? 1;
                                                    foreach ($reportData['revenueByStatus'] ?? [] as $status): 
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <span class="badge 
                                                                    <?php 
                                                                    if ($status['status'] === 'completed') echo 'bg-success';
                                                                    elseif ($status['status'] === 'pending') echo 'bg-warning';
                                                                    elseif ($status['status'] === 'cancelled') echo 'bg-danger';
                                                                    else echo 'bg-info';
                                                                    ?>">
                                                                    <?php echo htmlspecialchars($status['status']); ?>
                                                                </span>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($status['count']); ?></td>
                                                            <td>$<?php echo number_format($status['revenue'] ?? 0, 2); ?></td>
                                                            <td><?php echo round(($status['count'] / $totalBookings) * 100, 1); ?>%</td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Type Distribution -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Vehicle Type Distribution</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Vehicle Type</th>
                                                        <th>Bookings</th>
                                                        <th>Revenue</th>
                                                        <th>%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    foreach ($reportData['vehicleTypes'] ?? [] as $vtype):
                                                    ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($vtype['vehicle_type'] ?? 'Unknown'); ?></td>
                                                            <td><?php echo htmlspecialchars($vtype['count']); ?></td>
                                                            <td>$<?php echo number_format($vtype['revenue'] ?? 0, 2); ?></td>
                                                            <td><?php echo round(($vtype['count'] / $totalBookings) * 100, 1); ?>%</td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Top Routes -->
                        <div class="card mb-40">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Top Routes</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Pickup Location</th>
                                                <th>Delivery Location</th>
                                                <th>Bookings</th>
                                                <th>Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reportData['topRoutes'] ?? [] as $route): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($route['pickup_location'] ?? 'N/A'); ?></td>
                                                    <td><?php echo htmlspecialchars($route['delivery_location'] ?? 'N/A'); ?></td>
                                                    <td><?php echo htmlspecialchars($route['bookings']); ?></td>
                                                    <td>$<?php echo number_format($route['revenue'] ?? 0, 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Driver Performance -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Top Performing Drivers</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Driver</th>
                                                <th>Completed Deliveries</th>
                                                <th>Success Rate</th>
                                                <th>Total Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reportData['driverPerformance'] ?? [] as $driver): ?>
                                                <tr>
                                                    <td><strong><?php echo htmlspecialchars($driver['assign_driver'] ?? 'Unknown'); ?></strong></td>
                                                    <td><?php echo htmlspecialchars($driver['successful_deliveries'] ?? 0); ?></td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-success" role="progressbar" 
                                                                 style="width: <?php echo number_format($driver['success_rate'] ?? 0, 0); ?>%"
                                                                 aria-valuenow="<?php echo number_format($driver['success_rate'] ?? 0, 0); ?>" 
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                                <?php echo number_format($driver['success_rate'] ?? 0, 1); ?>%
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>$<?php echo number_format($driver['total_revenue'] ?? 0, 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </main>

        </div>

    </div>

    <!-- Footer -->
    <?php include '../footer.php'; ?>

    <!-- Footer Scripts -->
    <?php include '../footerscripts.php'; ?>

    <script>
        // Revenue Trend Chart
        <?php if (!empty($chartData['dailyTrend'])): ?>
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo $chartData['dailyTrend']['dates']; ?>,
                    datasets: [{
                        label: 'Daily Revenue',
                        data: <?php echo $chartData['dailyTrend']['revenues']; ?>,
                        borderColor: '#3366cc',
                        backgroundColor: 'rgba(51, 102, 204, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
        <?php endif; ?>
    </script>

</body>

</html>
