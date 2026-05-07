<?php
/**
 * Admin Bookings Management Page
 * View, filter, and manage all bookings in the system
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

// Set variables for layout
$page_title = 'Bookings Management';
$site_name = 'WG ROOS Courier Admin';

// Make sure functions are available
if (!function_exists('getBookings')) {
    require_once '../../../function.php';
}

// Get filter parameter
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

// Build query based on filter
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
    $query .= " AND (Name LIKE ? OR email LIKE ? OR order_id LIKE ?)";
    $searchTerm = "%$search%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
}

$query .= " ORDER BY pick_up_date DESC LIMIT 100";

try {
    global $DB;
    $stmt = $DB->prepare($query);
    $stmt->execute($params);
    $bookings = $stmt->fetchAll();
} catch (Exception $e) {
    error_log('Bookings query error: ' . $e->getMessage());
    $bookings = [];
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
                            <p class="text-muted">Manage and track all customer bookings</p>
                        </div>

                        <!-- Filter and Search Bar -->
                        <div class="card mb-40">
                            <div class="card-body">
                                <form method="GET" action="" class="row align-items-end gap-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Filter by Status</label>
                                        <select name="filter" class="form-select" onchange="this.form.submit()">
                                            <option value="all" <?php echo $filter === 'all' ? 'selected' : ''; ?>>All Bookings</option>
                                            <option value="pending" <?php echo $filter === 'pending' ? 'selected' : ''; ?>>Pending Assignment</option>
                                            <option value="assigned" <?php echo $filter === 'assigned' ? 'selected' : ''; ?>>Assigned to Driver</option>
                                            <option value="completed" <?php echo $filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Search</label>
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search by name, email, or order ID" value="<?php echo htmlspecialchars($search); ?>">
                                            <button class="btn btn-outline-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Bookings Table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Bookings List (<?php echo count($bookings); ?>)</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="bookingsTable">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Pickup Date</th>
                                                <th>Status</th>
                                                <th>Driver</th>
                                                <th>Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bookings as $booking): ?>
                                                <tr>
                                                    <td><strong><?php echo htmlspecialchars($booking['order_id'] ?? ''); ?></strong></td>
                                                    <td><?php echo htmlspecialchars($booking['Name'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['email'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['phone'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['pick_up_date'] ?? ''); ?></td>
                                                    <td>
                                                        <span class="badge 
                                                            <?php 
                                                            if ($booking['status'] === 'completed') {
                                                                echo 'bg-success';
                                                            } elseif ($booking['status'] === 'pending') {
                                                                echo 'bg-warning';
                                                            } elseif ($booking['status'] === 'cancelled') {
                                                                echo 'bg-danger';
                                                            } else {
                                                                echo 'bg-info';
                                                            }
                                                            ?>">
                                                            <?php echo ucfirst($booking['status'] ?? 'unknown'); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if (!empty($booking['assign_driver'])) {
                                                            echo '<span class="badge bg-primary">' . htmlspecialchars($booking['assign_driver']) . '</span>';
                                                        } else {
                                                            echo '<span class="badge bg-secondary">Unassigned</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>$<?php echo number_format($booking['amount'] ?? 0, 2); ?></td>
                                                    <td>
                                                        <a href="./orderDetails.php?id=<?php echo $booking['order_id']; ?>" class="btn btn-sm btn-primary">View</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            
                                            <?php if (empty($bookings)): ?>
                                                <tr>
                                                    <td colspan="9" class="text-center text-muted py-4">
                                                        No bookings found
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
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

    <!-- Scripts -->
    <?php include '../footerscripts.php'; ?>
    
    <script>
        // Initialize DataTables if needed
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#bookingsTable')) {
                $('#bookingsTable').DataTable().destroy();
            }
            $('#bookingsTable').DataTable({
                "pageLength": 25,
                "responsive": true,
                "order": [[ 4, "desc" ]]
            });
        });
    </script>

</body>

</html>