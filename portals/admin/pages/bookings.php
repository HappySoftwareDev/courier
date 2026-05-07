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
    <style>
        body {
            background: #f8f9fa;
        }
        .table-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e9ecef;
        }
        .table td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        .badge-assigned {
            background: #d1ecf1;
            color: #0c5460;
        }
        .badge-completed {
            background: #d4edda;
            color: #155724;
        }
        .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .filter-bar a {
            display: inline-block;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 4px;
            text-decoration: none;
            background: #f8f9fa;
            color: #333;
            transition: all 0.2s;
        }
        .filter-bar a.active {
            background: #667eea;
            color: white;
        }
        .filter-bar a:hover {
            background: #667eea;
            color: white;
        }
    </style>
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
                    <div class="container-fluid" style="padding: 30px;">
                        
                        <!-- Page Title -->
                        <div style="margin-bottom: 30px;">
                            <h1 style="font-size: 32px; font-weight: bold; margin: 0;">Bookings Management</h1>
                            <p style="color: #666; margin: 5px 0 0 0;">View and manage all customer bookings</p>
                        </div>

                        <!-- Filter Bar -->
                        <div class="filter-bar">
                            <a href="bookings.php" class="<?php echo ($filter === 'all') ? 'active' : ''; ?>">All Bookings (<?php echo count($bookings); ?>)</a>
                            <a href="bookings.php?filter=pending" class="<?php echo ($filter === 'pending') ? 'active' : ''; ?>">Pending</a>
                            <a href="bookings.php?filter=assigned" class="<?php echo ($filter === 'assigned') ? 'active' : ''; ?>">Assigned</a>
                            <a href="bookings.php?filter=completed" class="<?php echo ($filter === 'completed') ? 'active' : ''; ?>">Completed</a>
                        </div>

                        <!-- Bookings Table -->
                        <div class="table-container">
                            <?php if (empty($bookings)): ?>
                                <div style="padding: 40px; text-align: center; color: #999;">
                                    <p>No bookings found</p>
                                </div>
                            <?php else: ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Pickup</th>
                                            <th>Dropoff</th>
                                            <th>Driver</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($booking['id'] ?? $booking['order_id'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($booking['Name'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($booking['email'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars(substr($booking['pick_up_location'] ?? '', 0, 30)); ?></td>
                                                <td><?php echo htmlspecialchars(substr($booking['drop_off_location'] ?? '', 0, 30)); ?></td>
                                                <td><?php echo htmlspecialchars($booking['assign_driver'] ?? 'Unassigned'); ?></td>
                                                <td>
                                                    <?php 
                                                        $status = $booking['status'] ?? 'pending';
                                                        if ($status === 'completed') {
                                                            echo '<span class="badge badge-completed">Completed</span>';
                                                        } elseif (!empty($booking['assign_driver'])) {
                                                            echo '<span class="badge badge-assigned">Assigned</span>';
                                                        } else {
                                                            echo '<span class="badge badge-pending">Pending</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($booking['date'] ?? $booking['pick_up_date'] ?? ''); ?></td>
                                                <td>
                                                    <a href="bookingDetail.php?id=<?php echo urlencode($booking['id'] ?? $booking['order_id'] ?? ''); ?>" style="color: #667eea; text-decoration: none;">View</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
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
