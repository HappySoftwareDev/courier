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
                            <h1 style="font-size: 32px; font-weight: bold; margin: 0;">Users Management</h1>
                            <p style="color: #666; margin: 5px 0 0 0;">Manage all registered users and customers</p>
                        </div>

                        <!-- Users Table -->
                        <div class="table-container">
                            <?php if (empty($users)): ?>
                                <div style="padding: 40px; text-align: center; color: #999;">
                                    <p>No users found</p>
                                </div>
                            <?php else: ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Registration Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['Userid'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($user['Name'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($user['phone'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($user['date'] ?? ''); ?></td>
                                                <td>
                                                    <a href="userDetail.php?id=<?php echo urlencode($user['Userid'] ?? ''); ?>" style="color: #667eea; text-decoration: none;">View</a>
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
