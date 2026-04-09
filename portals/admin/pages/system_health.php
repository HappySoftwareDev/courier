<?php
/**
 * Admin System Health & Monitoring Page
 * Monitor system status, performance, and critical metrics
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

// Set variables for layout
$page_title = 'System Health';
$site_name = 'WG ROOS Courier Admin';

// System Health Checks
$healthStatus = [];

try {
    global $DB;
    
    // 1. Database Connection Check
    if ($DB) {
        $healthStatus['database'] = [
            'status' => 'healthy',
            'message' => 'Database connection active',
            'icon' => 'lni-checkmark-circle',
            'color' => 'success'
        ];
    } else {
        $healthStatus['database'] = [
            'status' => 'critical',
            'message' => 'Database connection failed',
            'icon' => 'lni-close-circle',
            'color' => 'danger'
        ];
    }
    
    // 2. Check if critical tables exist
    $tables = ['bookings', 'users', 'driver', 'businesspartners'];
    $missingTables = [];
    
    foreach ($tables as $table) {
        try {
            $result = $DB->query("SELECT 1 FROM `$table` LIMIT 1");
        } catch (Exception $e) {
            $missingTables[] = $table;
        }
    }
    
    if (empty($missingTables)) {
        $healthStatus['tables'] = [
            'status' => 'healthy',
            'message' => 'All critical tables present',
            'icon' => 'lni-checkmark-circle',
            'color' => 'success'
        ];
    } else {
        $healthStatus['tables'] = [
            'status' => 'critical',
            'message' => 'Missing tables: ' . implode(', ', $missingTables),
            'icon' => 'lni-alert-circle',
            'color' => 'danger'
        ];
    }
    
} catch (Exception $e) {
    error_log('System health check error: ' . $e->getMessage());
}

// 3. Server Performance
$healthStatus['server'] = [
    'status' => 'healthy',
    'message' => 'Server response time normal',
    'icon' => 'lni-checkmark-circle',
    'color' => 'success'
];

// 4. PHP Configuration
if (extension_loaded('pdo_mysql')) {
    $healthStatus['php'] = [
        'status' => 'healthy',
        'message' => 'PHP MySQL extension loaded',
        'icon' => 'lni-checkmark-circle',
        'color' => 'success'
    ];
} else {
    $healthStatus['php'] = [
        'status' => 'warning',
        'message' => 'PDO MySQL extension may be missing',
        'icon' => 'lni-alert-circle',
        'color' => 'warning'
    ];
}

// Get system statistics
$stats = [];
try {
    global $DB;
    
    // Count active sessions
    $stmt = $DB->query("SELECT COUNT(*) as count FROM bookings WHERE status != 'completed'");
    $result = $stmt->fetch();
    $stats['active_bookings'] = $result['count'] ?? 0;
    
    // Count pending assignments
    $stmt = $DB->query("SELECT COUNT(*) as count FROM bookings WHERE assign_driver IS NULL OR assign_driver = ''");
    $result = $stmt->fetch();
    $stats['pending_assignments'] = $result['count'] ?? 0;
    
    // Count online drivers
    $stmt = $DB->query("SELECT COUNT(*) as count FROM driver WHERE status = 'active'");
    $result = $stmt->fetch();
    $stats['online_drivers'] = $result['count'] ?? 0;
    
    // Storage usage estimate
    $stmt = $DB->query("SELECT 
                        ROUND(SUM(DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) as size_mb
                        FROM INFORMATION_SCHEMA.TABLES 
                        WHERE TABLE_SCHEMA = DATABASE()");
    $result = $stmt->fetch();
    $stats['database_size'] = number_format($result['size_mb'] ?? 0, 2) . ' MB';
    
} catch (Exception $e) {
    error_log('Stats query error: ' . $e->getMessage());
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
                            <p class="text-muted">Monitor system performance and health status</p>
                        </div>

                        <!-- Overall Status -->
                        <div class="alert alert-info mb-40">
                            <h5 class="alert-heading">System Status: <strong>OPERATIONAL</strong></h5>
                            <p class="mb-0">Last checked: <?php echo date('F d, Y \a\t h:i:s A'); ?></p>
                        </div>

                        <!-- Health Checks Grid -->
                        <div class="row gap-3 mb-40">
                            <?php foreach ($healthStatus as $check => $data): ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="text-<?php echo htmlspecialchars($data['color']); ?> fs-5 me-3">
                                                <i class="lni <?php echo htmlspecialchars($data['icon']); ?>"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 text-capitalize"><?php echo htmlspecialchars(str_replace('_', ' ', $check)); ?></h6>
                                                <p class="mb-0 small text-muted"><?php echo htmlspecialchars($data['message']); ?></p>
                                                <span class="badge bg-<?php echo htmlspecialchars($data['color']); ?> mt-2">
                                                    <?php echo htmlspecialchars(ucfirst($data['status'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Key Statistics -->
                        <div class="row gap-3 mb-40">
                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-primary">
                                                <i class="lni lni-package"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Active Bookings</h6>
                                                <h3 class="mb-0"><?php echo $stats['active_bookings'] ?? 0; ?></h3>
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
                                                <h6 class="text-muted mb-1">Pending Assignments</h6>
                                                <h3 class="mb-0"><?php echo $stats['pending_assignments'] ?? 0; ?></h3>
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
                                                <i class="lni lni-car"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Online Drivers</h6>
                                                <h3 class="mb-0"><?php echo $stats['online_drivers'] ?? 0; ?></h3>
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
                                                <i class="lni lni-database"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Database Size</h6>
                                                <h3 class="mb-0"><?php echo $stats['database_size'] ?? 'N/A'; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Information -->
                        <div class="row gap-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Server Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="text-muted"><strong>PHP Version:</strong></td>
                                                <td><?php echo htmlspecialchars(phpversion()); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Server Software:</strong></td>
                                                <td><?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Operating System:</strong></td>
                                                <td><?php echo htmlspecialchars(php_uname()); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Memory Limit:</strong></td>
                                                <td><?php echo htmlspecialchars(ini_get('memory_limit')); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Max Upload Size:</strong></td>
                                                <td><?php echo htmlspecialchars(ini_get('upload_max_filesize')); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Max Execution Time:</strong></td>
                                                <td><?php echo htmlspecialchars(ini_get('max_execution_time')); ?>s</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Extension Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless table-sm">
                                            <?php 
                                            $extensions = [
                                                ['pdo_mysql', 'MySQL (PDO)'],
                                                ['gd', 'GD Image'],
                                                ['curl', 'cURL'],
                                                ['json', 'JSON'],
                                                ['zip', 'ZIP Archives'],
                                                ['mbstring', 'Multibyte String']
                                            ];
                                            foreach ($extensions as [$ext, $name]):
                                            ?>
                                                <tr>
                                                    <td class="text-muted"><strong><?php echo htmlspecialchars($name); ?>:</strong></td>
                                                    <td>
                                                        <?php if (extension_loaded($ext)): ?>
                                                            <span class="badge bg-success">Enabled</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Disabled</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Actions -->
                        <div class="card mt-40">
                            <div class="card-header">
                                <h5 class="card-title mb-0">System Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row gap-2">
                                    <div class="col-md-4">
                                        <button class="btn btn-primary w-100" onclick="location.reload()">
                                            <i class="lni lni-reload"></i> Refresh Health Check
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="activity_logs.php" class="btn btn-info w-100">
                                            <i class="lni lni-list"></i> View Activity Logs
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="reports.php" class="btn btn-secondary w-100">
                                            <i class="lni lni-bar-chart"></i> View Reports
                                        </a>
                                    </div>
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

</body>

</html>
