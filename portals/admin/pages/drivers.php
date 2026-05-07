<?php
/**
 * Admin Drivers Management Page
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

$page_title = 'Drivers Management';
$site_name = 'WG ROOS Courier Admin';

$status = $_GET['status'] ?? 'all';

// Build query
$query = "SELECT * FROM `driver`";
$params = [];

if ($status === 'active') {
    $query .= " WHERE online = 'online'";
} elseif ($status === 'inactive') {
    $query .= " WHERE online != 'online'";
}

$query .= " ORDER BY driverID DESC LIMIT 100";

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
        .badge-online {
            background: #d4edda;
            color: #155724;
        }
        .badge-offline {
            background: #f8d7da;
            color: #721c24;
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
                            <h1 style="font-size: 32px; font-weight: bold; margin: 0;">Drivers Management</h1>
                            <p style="color: #666; margin: 5px 0 0 0;">Manage all registered drivers and their details</p>
                        </div>

                        <!-- Drivers Table -->
                        <div class="table-container">
                            <?php if (empty($drivers)): ?>
                                <div style="padding: 40px; text-align: center; color: #999;">
                                    <p>No drivers found</p>
                                </div>
                            <?php else: ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>Status</th>
                                            <th>Vehicle</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($drivers as $driver): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($driver['driverID'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($driver['name'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($driver['username'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($driver['email'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($driver['phone'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($driver['city'] ?? ''); ?></td>
                                                <td>
                                                    <?php 
                                                        $isOnline = ($driver['online'] ?? '') === 'online';
                                                        echo '<span class="badge ' . ($isOnline ? 'badge-online' : 'badge-offline') . '">' 
                                                            . ($isOnline ? 'Online' : 'Offline') . '</span>';
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($driver['vehicleMake'] . ' ' . ($driver['model'] ?? '')); ?></td>
                                                <td>
                                                    <a href="driverDetail.php?id=<?php echo urlencode($driver['driverID'] ?? ''); ?>" style="color: #667eea; text-decoration: none;">View</a>
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
