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
                                    <h1 class="mb-10">Drivers Management</h1>
                                    <p class="text-muted">Manage all registered drivers and their details</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="card shadow-sm border-0 mb-30">
                            <div class="card-body">
                                <div class="btn-group" role="group">
                                    <a href="drivers.php" class="btn btn-sm <?php echo ($status === 'all') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        All Drivers
                                    </a>
                                    <a href="drivers.php?status=active" class="btn btn-sm <?php echo ($status === 'active') ? 'btn-success' : 'btn-outline-success'; ?>">
                                        Online
                                    </a>
                                    <a href="drivers.php?status=inactive" class="btn btn-sm <?php echo ($status === 'inactive') ? 'btn-danger' : 'btn-outline-danger'; ?>">
                                        Offline
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Drivers Table -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <?php if (empty($drivers)): ?>
                                    <div class="p-5 text-center text-muted">
                                        <i class="lni lni-car" style="font-size: 48px; opacity: 0.3;"></i>
                                        <p class="mt-3 mb-0">No drivers found</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">ID</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>City</th>
                                                    <th>Status</th>
                                                    <th>Vehicle</th>
                                                    <th class="pe-4">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($drivers as $driver): ?>
                                                    <tr>
                                                        <td class="ps-4"><strong><?php echo htmlspecialchars($driver['driverID'] ?? ''); ?></strong></td>
                                                        <td><?php echo htmlspecialchars($driver['name'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($driver['username'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($driver['email'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($driver['phone'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($driver['city'] ?? ''); ?></td>
                                                        <td>
                                                            <?php 
                                                                $isOnline = ($driver['online'] ?? '') === 'online';
                                                                echo '<span class="badge ' . ($isOnline ? 'bg-success' : 'bg-danger') . '">' 
                                                                    . ($isOnline ? 'Online' : 'Offline') . '</span>';
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($driver['vehicleMake'] . ' ' . ($driver['model'] ?? '')); ?></td>
                                                        <td class="pe-4">
                                                            <a href="driverDetail.php?id=<?php echo urlencode($driver['driverID'] ?? ''); ?>" class="btn btn-sm btn-primary">
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
