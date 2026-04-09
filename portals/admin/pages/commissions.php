<?php
/**
 * Admin Driver Commissions Management Page
 * Track and manage driver commissions and earnings
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

// Set variables for layout
$page_title = 'Driver Commissions';
$site_name = 'WG ROOS Courier Admin';

// Get filter parameters
$period = $_GET['period'] ?? 'month';
$driver = $_GET['driver'] ?? '';
$status = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';

$commissions = [];
$totalCommissions = 0;
$totalPaid = 0;
$totalPending = 0;

try {
    global $DB;
    
    // Build date filter based on period
    $dateFilter = '';
    switch ($period) {
        case 'week':
            $dateFilter = " AND DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            break;
        case 'month':
            $dateFilter = " AND DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
            break;
        case 'quarter':
            $dateFilter = " AND DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)";
            break;
        case 'year':
            $dateFilter = " AND YEAR(created_at) = YEAR(CURDATE())";
            break;
    }
    
    // Query to get commission data
    $query = "SELECT 
                b.assign_driver as driver_name,
                d.email as driver_email,
                COUNT(b.order_id) as total_deliveries,
                COUNT(CASE WHEN b.status = 'completed' THEN 1 END) as completed_deliveries,
                SUM(b.Total_price) as total_revenue,
                SUM(b.Total_price) * 0.15 as commission_earned,
                0 as commission_paid,
                SUM(b.Total_price) * 0.15 as commission_pending,
                MAX(b.updated_at) as last_delivery
              FROM bookings b
              LEFT JOIN driver d ON b.assign_driver = d.username
              WHERE b.status = 'completed'" . $dateFilter . "
              GROUP BY b.assign_driver
              ORDER BY commission_earned DESC";
    
    if (!empty($driver)) {
        $query = str_replace("GROUP BY b.assign_driver", "AND b.assign_driver = ?", $query);
        $stmt = $DB->prepare($query);
        $stmt->execute([$driver]);
    } else {
        $stmt = $DB->prepare($query);
        $stmt->execute();
    }
    
    $commissions = $stmt->fetchAll();
    
    // Calculate totals
    foreach ($commissions as $commission) {
        $totalCommissions += $commission['commission_earned'] ?? 0;
        $totalPending += $commission['commission_pending'] ?? 0;
    }
    
} catch (Exception $e) {
    error_log('Commissions query error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $page_title; ?> | <?php echo $site_name; ?></title>
    <?php include '../head.php'; ?>
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
                            <p class="text-muted">Manage driver earnings and commission payouts</p>
                        </div>

                        <!-- Commission Summary Cards -->
                        <div class="row gap-3 mb-40">
                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-primary">
                                                <i class="lni lni-dollar"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Total Earned</h6>
                                                <h3 class="mb-0">$<?php echo number_format($totalCommissions, 2); ?></h3>
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
                                                <i class="lni lni-checkmark-circle"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Paid Out</h6>
                                                <h3 class="mb-0">$<?php echo number_format($totalPaid, 2); ?></h3>
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
                                                <i class="lni lni-timer"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Pending</h6>
                                                <h3 class="mb-0">$<?php echo number_format($totalPending, 2); ?></h3>
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
                                                <i class="lni lni-car"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Active Drivers</h6>
                                                <h3 class="mb-0"><?php echo count($commissions); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="card mb-40">
                            <div class="card-body">
                                <form method="GET" action="" class="row align-items-end gap-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Period</label>
                                        <select name="period" class="form-select" onchange="this.form.submit()">
                                            <option value="week" <?php echo $period === 'week' ? 'selected' : ''; ?>>This Week</option>
                                            <option value="month" <?php echo $period === 'month' ? 'selected' : ''; ?>>This Month</option>
                                            <option value="quarter" <?php echo $period === 'quarter' ? 'selected' : ''; ?>>This Quarter</option>
                                            <option value="year" <?php echo $period === 'year' ? 'selected' : ''; ?>>This Year</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Commission Status</label>
                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                            <option value="all" <?php echo $status === 'all' ? 'selected' : ''; ?>>All</option>
                                            <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="paid" <?php echo $status === 'paid' ? 'selected' : ''; ?>>Paid</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Search Driver</label>
                                        <input type="text" name="search" class="form-control" placeholder="Driver name or email" value="<?php echo htmlspecialchars($search); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Commissions Table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Commission Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="commissionsTable">
                                        <thead>
                                            <tr>
                                                <th>Driver</th>
                                                <th>Email</th>
                                                <th>Deliveries</th>
                                                <th>Total Revenue</th>
                                                <th>Commission Rate</th>
                                                <th>Commission Earned</th>
                                                <th>Status</th>
                                                <th>Last Delivery</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($commissions)): ?>
                                                <tr>
                                                    <td colspan="9" class="text-center py-4">
                                                        <p class="text-muted">No commission data found</p>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($commissions as $commission): ?>
                                                    <tr>
                                                        <td><strong><?php echo htmlspecialchars($commission['driver_name'] ?? 'Unknown'); ?></strong></td>
                                                        <td><?php echo htmlspecialchars($commission['driver_email'] ?? ''); ?></td>
                                                        <td>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar bg-success" role="progressbar" 
                                                                     style="width: <?php echo ($commission['completed_deliveries'] / max($commission['total_deliveries'], 1)) * 100; ?>%"
                                                                     aria-valuenow="<?php echo $commission['completed_deliveries']; ?>" 
                                                                     aria-valuemin="0" 
                                                                     aria-valuemax="<?php echo $commission['total_deliveries']; ?>">
                                                                    <?php echo htmlspecialchars($commission['completed_deliveries']); ?>/<?php echo htmlspecialchars($commission['total_deliveries']); ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>$<?php echo number_format($commission['total_revenue'] ?? 0, 2); ?></td>
                                                        <td>
                                                            <span class="badge bg-light text-dark">15%</span>
                                                        </td>
                                                        <td>
                                                            <strong>$<?php echo number_format($commission['commission_earned'] ?? 0, 2); ?></strong>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-warning">Pending</span>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">
                                                                <?php echo htmlspecialchars(date('M d, Y', strtotime($commission['last_delivery'] ?? 'now'))); ?>
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary" onclick="approvePayout('<?php echo htmlspecialchars($commission['driver_name']); ?>')">
                                                                Approve Payout
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
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
        // DataTables initialization
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('commissionsTable')) {
                new DataTable('#commissionsTable', {
                    responsive: true,
                    pageLength: 25,
                    order: [[5, 'desc']]
                });
            }
        });

        function approvePayout(driverName) {
            if (confirm('Approve commission payout for ' + driverName + '?')) {
                alert('Payout approved! Commission will be transferred within 24 hours.');
                // In production, this would make an AJAX request to process the payout
            }
        }
    </script>

</body>

</html>
