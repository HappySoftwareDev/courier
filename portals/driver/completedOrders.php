<?php
require_once '../../config/bootstrap.php';
require_once 'signin-security.php';

$page_title = 'Completed Orders';
$site_name = 'WG ROOS Courier';

// Get driver username from session
$driverUsername = $_SESSION['MM_Username'] ?? '';

// Fetch completed orders for this driver
$completedOrders = [];
try {
    global $DB;
    
    $stmt = $DB->prepare("SELECT * FROM `bookings` WHERE assign_driver = ? AND status = 'completed' ORDER BY date DESC LIMIT 100");
    $stmt->execute([$driverUsername]);
    $completedOrders = $stmt->fetchAll();
} catch (Exception $e) {
    error_log('Driver completed orders error: ' . $e->getMessage());
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
<body class="driver-portal">
    
    <!-- Navigation -->
    <?php include 'header.php'; ?>
    
    <main class="main-wrapper">
        <section class="section">
            <div class="container-fluid">
                
                <!-- Page Header -->
                <div class="page-header mb-40">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1 class="mb-10">Completed Orders</h1>
                            <p class="text-muted">View your delivery history and completed jobs</p>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <?php if (empty($completedOrders)): ?>
                            <div class="p-5 text-center text-muted">
                                <i class="lni lni-check-mark-circle" style="font-size: 48px; opacity: 0.3;"></i>
                                <p class="mt-3 mb-0">No completed orders yet</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Order ID</th>
                                            <th>Customer</th>
                                            <th>Pickup Location</th>
                                            <th>Dropoff Location</th>
                                            <th>Completed Date</th>
                                            <th>Amount</th>
                                            <th class="pe-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($completedOrders as $order): ?>
                                            <tr>
                                                <td class="ps-4"><strong><?php echo htmlspecialchars($order['id'] ?? $order['order_id'] ?? ''); ?></strong></td>
                                                <td><?php echo htmlspecialchars($order['Name'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars(substr($order['pick_up_location'] ?? '', 0, 40)); ?></td>
                                                <td><?php echo htmlspecialchars(substr($order['drop_off_location'] ?? '', 0, 40)); ?></td>
                                                <td><?php echo htmlspecialchars($order['date'] ?? ''); ?></td>
                                                <td><strong><?php echo htmlspecialchars($order['Total_price'] ?? '0.00'); ?></strong></td>
                                                <td class="pe-4">
                                                    <a href="acceptedOrdersDetails.php?id=<?php echo urlencode($order['id'] ?? $order['order_id'] ?? ''); ?>" class="btn btn-sm btn-primary">
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
    <?php include 'footer.php'; ?>
    <?php include 'footer_scripts.php'; ?>

</body>
</html>
