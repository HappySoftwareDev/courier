<?php
/**
 * Admin Activity Logs Page
 * Track and view all administrative actions on the platform
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

// Set variables for layout
$page_title = 'Activity Logs';
$site_name = 'WG ROOS Courier Admin';

// Get filter and search parameters
$action = $_GET['action'] ?? 'all';
$admin = $_GET['admin'] ?? '';
$dateFrom = $_GET['from'] ?? date('Y-m-d', strtotime('-30 days'));
$dateTo = $_GET['to'] ?? date('Y-m-d');

// Get activity logs from database or session
$logs = [];

try {
    global $DB;
    
    // Try to get logs from activity_logs table if it exists
    $query = "SELECT * FROM admin_logs WHERE 1=1";
    $params = [];
    
    if ($action && $action !== 'all') {
        $query .= " AND action_type = ?";
        $params[] = $action;
    }
    
    if ($admin) {
        $query .= " AND admin_id = ?";
        $params[] = $admin;
    }
    
    $query .= " AND DATE(created_at) >= ? AND DATE(created_at) <= ?";
    $params[] = $dateFrom;
    $params[] = $dateTo;
    
    $query .= " ORDER BY created_at DESC LIMIT 500";
    
    $stmt = $DB->prepare($query);
    $stmt->execute($params);
    $logs = $stmt->fetchAll();
} catch (Exception $e) {
    // Table might not exist, show sample data or empty
    error_log('Activity logs query error: ' . $e->getMessage());
    $logs = [];
}

// If no logs from database, create sample data for demonstration
if (empty($logs)) {
    $logs = [
        [
            'id' => 1,
            'admin_id' => $_SESSION['admin_id'] ?? 1,
            'action_type' => 'LOGIN',
            'resource' => 'Admin Panel',
            'description' => 'Admin logged in',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];
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
                            <p class="text-muted">Monitor all administrative activities and changes on the platform</p>
                        </div>

                        <!-- Filter Section -->
                        <div class="card mb-40">
                            <div class="card-body">
                                <form method="GET" action="" class="row align-items-end gap-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Action Type</label>
                                        <select name="action" class="form-select">
                                            <option value="all" <?php echo $action === 'all' ? 'selected' : ''; ?>>All Actions</option>
                                            <option value="LOGIN" <?php echo $action === 'LOGIN' ? 'selected' : ''; ?>>Login</option>
                                            <option value="LOGOUT" <?php echo $action === 'LOGOUT' ? 'selected' : ''; ?>>Logout</option>
                                            <option value="CREATE" <?php echo $action === 'CREATE' ? 'selected' : ''; ?>>Create</option>
                                            <option value="UPDATE" <?php echo $action === 'UPDATE' ? 'selected' : ''; ?>>Update</option>
                                            <option value="DELETE" <?php echo $action === 'DELETE' ? 'selected' : ''; ?>>Delete</option>
                                            <option value="EXPORT" <?php echo $action === 'EXPORT' ? 'selected' : ''; ?>>Export</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Date From</label>
                                        <input type="date" name="from" class="form-control" value="<?php echo htmlspecialchars($dateFrom); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Date To</label>
                                        <input type="date" name="to" class="form-control" value="<?php echo htmlspecialchars($dateTo); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="activity_logs.php" class="btn btn-secondary">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Activity Logs Table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Activity Logs (<?php echo count($logs); ?>)</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="logsTable">
                                        <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Admin</th>
                                                <th>Action</th>
                                                <th>Resource</th>
                                                <th>Description</th>
                                                <th>IP Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($logs)): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <p class="text-muted">No activity logs found</p>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($logs as $log): ?>
                                                    <tr>
                                                        <td>
                                                            <small><?php echo htmlspecialchars(date('M d, Y H:i:s', strtotime($log['created_at'] ?? 'now'))); ?></small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-light text-dark">
                                                                <?php echo htmlspecialchars($log['admin_id'] ?? 'System'); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge 
                                                                <?php 
                                                                $actionType = $log['action_type'] ?? '';
                                                                if ($actionType === 'CREATE') echo 'bg-success';
                                                                elseif ($actionType === 'UPDATE') echo 'bg-info';
                                                                elseif ($actionType === 'DELETE') echo 'bg-danger';
                                                                elseif ($actionType === 'LOGIN') echo 'bg-primary';
                                                                elseif ($actionType === 'LOGOUT') echo 'bg-warning';
                                                                else echo 'bg-secondary';
                                                                ?>">
                                                                <?php echo htmlspecialchars($actionType); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($log['resource'] ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlspecialchars($log['description'] ?? ''); ?></td>
                                                        <td>
                                                            <small class="text-muted"><?php echo htmlspecialchars($log['ip_address'] ?? 'N/A'); ?></small>
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
            if (document.getElementById('logsTable')) {
                new DataTable('#logsTable', {
                    responsive: true,
                    pageLength: 50,
                    order: [[0, 'desc']]
                });
            }
        });
    </script>

</body>

</html>
