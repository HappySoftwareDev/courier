<?php
/**
 * Admin Drivers Management Page
 * View, filter, and manage all drivers in the system
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

// Set variables for layout
$page_title = 'Drivers Management';
$site_name = 'WG ROOS Courier Admin';

// Make sure functions are available
if (!function_exists('getCountAllDrivers')) {
    require_once '../../../function.php';
}

// Get filter and search parameters
$status = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';

// Build query based on filter
$query = "SELECT * FROM `driver` WHERE 1=1";
$params = [];

if ($status === 'active') {
    $query .= " AND status = 'active'";
} elseif ($status === 'inactive') {
    $query .= " AND status = 'inactive'";
} elseif ($status === 'suspended') {
    $query .= " AND status = 'suspended'";
}

if (!empty($search)) {
    $query .= " AND (username LIKE ? OR Name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $searchTerm = "%$search%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

$query .= " ORDER BY created_at DESC LIMIT 100";

$drivers = [];
try {
    global $DB;
    $stmt = $DB->prepare($query);
    $stmt->execute($params);
    $drivers = $stmt->fetchAll();
} catch (Exception $e) {
    error_log('Drivers query error: ' . $e->getMessage());
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
                            <p class="text-muted">Manage and monitor all drivers on the platform</p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="row gap-3 mb-40">
                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-primary">
                                                <i class="lni lni-car"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Total Drivers</h6>
                                                <h3 class="mb-0"><?php echo count($drivers); ?></h3>
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
                                                <h6 class="text-muted mb-1">Active</h6>
                                                <h3 class="mb-0"><?php echo count(array_filter($drivers, fn($d) => ($d['status'] ?? '') === 'active')); ?></h3>
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
                                                <i class="lni lni-crown"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Premium</h6>
                                                <h3 class="mb-0"><?php echo count(array_filter($drivers, fn($d) => ($d['plan'] ?? '') === 'premium')); ?></h3>
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
                                                <i class="lni lni-alert"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Suspended</h6>
                                                <h3 class="mb-0"><?php echo count(array_filter($drivers, fn($d) => ($d['status'] ?? '') === 'suspended')); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter and Search Bar -->
                        <div class="card mb-40">
                            <div class="card-body">
                                <form method="GET" action="" class="row align-items-end gap-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Filter by Status</label>
                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                            <option value="all" <?php echo $status === 'all' ? 'selected' : ''; ?>>All Drivers</option>
                                            <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                                            <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                            <option value="suspended" <?php echo $status === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Search</label>
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="<?php echo htmlspecialchars($search); ?>">
                                            <button class="btn btn-outline-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="addDriver.php" class="btn btn-success w-100">
                                            <i class="lni lni-plus"></i> Add Driver
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Drivers Table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Drivers List (<?php echo count($drivers); ?>)</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="driversTable">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Plan</th>
                                                <th>Rating</th>
                                                <th>Joined</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($drivers)): ?>
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">
                                                        <p class="text-muted">No drivers found</p>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($drivers as $driver): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($driver['Name'] ?? ''); ?></strong>
                                                            <br>
                                                            <small class="text-muted">@<?php echo htmlspecialchars($driver['username'] ?? ''); ?></small>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($driver['email'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($driver['phone'] ?? ''); ?></td>
                                                        <td>
                                                            <span class="badge 
                                                                <?php 
                                                                if (($driver['status'] ?? '') === 'active') {
                                                                    echo 'bg-success';
                                                                } elseif (($driver['status'] ?? '') === 'suspended') {
                                                                    echo 'bg-danger';
                                                                } else {
                                                                    echo 'bg-secondary';
                                                                }
                                                                ?>">
                                                                <?php echo htmlspecialchars($driver['status'] ?? 'unknown'); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                <?php echo htmlspecialchars(ucfirst($driver['plan'] ?? 'basic')); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <?php 
                                                                $rating = $driver['rating'] ?? 0;
                                                                for ($i = 0; $i < 5; $i++):
                                                                    if ($i < floor($rating)):
                                                                        echo '<i class="lni lni-star-fill text-warning"></i>';
                                                                    else:
                                                                        echo '<i class="lni lni-star text-muted"></i>';
                                                                    endif;
                                                                endfor;
                                                                ?>
                                                                <small>(<?php echo number_format($rating, 1); ?>)</small>
                                                            </div>
                                                        </td>
                                                        <td><?php echo htmlspecialchars(date('M d, Y', strtotime($driver['created_at'] ?? 'now'))); ?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                    Actions
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="driverDetail.php?id=<?php echo htmlspecialchars($driver['ID'] ?? ''); ?>">View Details</a></li>
                                                                    <li><a class="dropdown-item" href="driverDetail.php?id=<?php echo htmlspecialchars($driver['ID'] ?? ''); ?>&edit=1">Edit</a></li>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li><a class="dropdown-item text-danger" href="javascript:confirmDelete('<?php echo htmlspecialchars($driver['ID'] ?? ''); ?>')">Delete</a></li>
                                                                </ul>
                                                            </div>
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
            if (document.getElementById('driversTable')) {
                new DataTable('#driversTable', {
                    responsive: true,
                    pageLength: 25,
                    order: [[6, 'desc']]
                });
            }
        });

        function confirmDelete(driverId) {
            if (confirm('Are you sure you want to delete this driver? This action cannot be undone.')) {
                window.location.href = 'driverDetail.php?id=' + driverId + '&delete=1';
            }
        }
    </script>

</body>

</html>
