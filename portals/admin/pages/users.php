<?php
/**
 * Admin Users Management Page
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

$page_title = 'Users Management';
$site_name = 'WG ROOS Courier Admin';

$type = $_GET['type'] ?? 'all';

// Get users
$query = "SELECT * FROM `users` ORDER BY Userid DESC LIMIT 100";
$users = [];

try {
    global $DB;
    $stmt = $DB->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll();
} catch (Exception $e) {
    error_log('Users query error: ' . $e->getMessage());
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
                                    <h1 class="mb-10">Users Management</h1>
                                    <p class="text-muted">Manage all registered users and customers</p>
                                </div>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <?php if (empty($users)): ?>
                                    <div class="p-5 text-center text-muted">
                                        <i class="lni lni-users" style="font-size: 48px; opacity: 0.3;"></i>
                                        <p class="mt-3 mb-0">No users found</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Registration Date</th>
                                                    <th class="pe-4">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($users as $user): ?>
                                                    <tr>
                                                        <td class="ps-4"><strong><?php echo htmlspecialchars($user['Userid'] ?? ''); ?></strong></td>
                                                        <td><?php echo htmlspecialchars($user['Name'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($user['phone'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($user['date'] ?? ''); ?></td>
                                                        <td class="pe-4">
                                                            <a href="userDetail.php?id=<?php echo urlencode($user['Userid'] ?? ''); ?>" class="btn btn-sm btn-primary">
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
