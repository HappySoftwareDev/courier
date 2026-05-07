<?php
/**
 * Admin Bookings Management Page
 * View and manage all bookings
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

$page_title = 'Bookings Management';
$site_name = 'WG ROOS Courier Admin';

// Get filter and search parameters
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

// Build query
$query = "SELECT * FROM `bookings` WHERE 1=1";
$params = [];

if ($filter === 'pending') {
    $query .= " AND (assign_driver IS NULL OR assign_driver = '')";
} elseif ($filter === 'assigned') {
    $query .= " AND assign_driver IS NOT NULL AND assign_driver != ''";
} elseif ($filter === 'completed') {
    $query .= " AND status = 'completed'";
}

if (!empty($search)) {
    $query .= " AND (Name LIKE ? OR email LIKE ?)";
    $searchTerm = "%$search%";
    $params = array_merge($params, [$searchTerm, $searchTerm]);
}

$query .= " ORDER BY date DESC LIMIT 100";

$bookings = [];
try {
    global $DB;
    $stmt = $DB->prepare($query);
    $stmt->execute($params);
    $bookings = $stmt->fetchAll();
} catch (Exception $e) {
    error_log('Bookings query error: ' . $e->getMessage());
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
                                    <h1 class="mb-10">Bookings Management</h1>
                                    <p class="text-muted">View and manage all customer bookings</p>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Bar -->
                        <div class="card shadow-sm border-0 mb-30">
                            <div class="card-body">
                                <div class="btn-group" role="group">
                                    <a href="bookings.php" class="btn btn-sm <?php echo ($filter === 'all') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        All Bookings (<?php echo count($bookings); ?>)
                                    </a>
                                    <a href="bookings.php?filter=pending" class="btn btn-sm <?php echo ($filter === 'pending') ? 'btn-warning' : 'btn-outline-warning'; ?>">
                                        Pending
                                    </a>
                                    <a href="bookings.php?filter=assigned" class="btn btn-sm <?php echo ($filter === 'assigned') ? 'btn-info' : 'btn-outline-info'; ?>">
                                        Assigned
                                    </a>
                                    <a href="bookings.php?filter=completed" class="btn btn-sm <?php echo ($filter === 'completed') ? 'btn-success' : 'btn-outline-success'; ?>">
                                        Completed
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Bookings Table -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <?php if (empty($bookings)): ?>
                                    <div class="p-5 text-center text-muted">
                                        <i class="lni lni-inbox" style="font-size: 48px; opacity: 0.3;"></i>
                                        <p class="mt-3 mb-0">No bookings found</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Email</th>
                                                    <th>Pickup</th>
                                                    <th>Dropoff</th>
                                                    <th>Driver</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th class="pe-4">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($bookings as $booking): ?>
                                                    <tr>
                                                        <td class="ps-4"><strong><?php echo htmlspecialchars($booking['id'] ?? $booking['order_id'] ?? ''); ?></strong></td>
                                                        <td><?php echo htmlspecialchars($booking['Name'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($booking['email'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars(substr($booking['pick_up_location'] ?? '', 0, 30)); ?></td>
                                                        <td><?php echo htmlspecialchars(substr($booking['drop_off_location'] ?? '', 0, 30)); ?></td>
                                                        <td><?php echo htmlspecialchars($booking['assign_driver'] ?? 'Unassigned'); ?></td>
                                                        <td>
                                                            <?php 
                                                                $status = $booking['status'] ?? 'pending';
                                                                if ($status === 'completed') {
                                                                    echo '<span class="badge bg-success">Completed</span>';
                                                                } elseif (!empty($booking['assign_driver'])) {
                                                                    echo '<span class="badge bg-info">Assigned</span>';
                                                                } else {
                                                                    echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($booking['date'] ?? $booking['pick_up_date'] ?? ''); ?></td>
                                                        <td class="pe-4">
                                                            <a href="bookingDetail.php?id=<?php echo urlencode($booking['id'] ?? $booking['order_id'] ?? ''); ?>" class="btn btn-sm btn-primary">
                                                                <i class="lni lni-eye"></i> View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
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
