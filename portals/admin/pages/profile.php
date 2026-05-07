<?php
/**
 * Admin Profile Page
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

$page_title = 'My Profile';
$site_name = 'WG ROOS Courier Admin';

// Get user info from session
$username = $_SESSION['CC_Username'] ?? '';
$admin_name = $_SESSION['user_name'] ?? 'Admin User';
$admin_id = $_SESSION['admin_id'] ?? '';

$adminInfo = [
    'email' => $username,
    'name' => $admin_name,
    'phone' => '',
    'address' => '',
];

// Fetch admin details
try {
    global $DB;
    
    $stmt = $DB->prepare("SELECT * FROM `admin` WHERE Email = ? OR AdminID = ? LIMIT 1");
    $stmt->execute([$username, $admin_id]);
    $admin = $stmt->fetch();
    
    if ($admin) {
        $adminInfo['name'] = $admin['name'] ?? $admin_name;
        $adminInfo['email'] = $admin['Email'] ?? $username;
        $adminInfo['phone'] = $admin['phone'] ?? '';
        $adminInfo['address'] = $admin['address'] ?? '';
    }
} catch (Exception $e) {
    error_log('Admin profile fetch error: ' . $e->getMessage());
}

$message = '';
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
                                    <h1 class="mb-10">My Profile</h1>
                                    <p class="text-muted">View and manage your admin account information</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Content -->
                        <div class="row g-4">
                            <!-- Profile Card -->
                            <div class="col-lg-4">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <img src="assets/images/avatar.png" alt="Profile" class="rounded-circle" width="100" height="100" onerror="this.src='https://via.placeholder.com/100'">
                                        </div>
                                        <h5 class="card-title"><?php echo htmlspecialchars($adminInfo['name']); ?></h5>
                                        <p class="text-muted small">Administrator</p>
                                        <div class="mt-3">
                                            <a href="settings_management.php" class="btn btn-sm btn-primary w-100 mb-2">
                                                <i class="lni lni-cog"></i> Settings
                                            </a>
                                            <a href="login.php?logout=true" class="btn btn-sm btn-outline-danger w-100">
                                                <i class="lni lni-exit"></i> Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Details -->
                            <div class="col-lg-8">
                                <?php if (!empty($message)): ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <?php echo htmlspecialchars($message); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>

                                <!-- Admin Information -->
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-light border-bottom">
                                        <h5 class="mb-0"><i class="lni lni-user"></i> Admin Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small">Admin Name</label>
                                                <p class="mb-0"><?php echo htmlspecialchars($adminInfo['name']); ?></p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small">Email Address</label>
                                                <p class="mb-0"><?php echo htmlspecialchars($adminInfo['email']); ?></p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small">Phone Number</label>
                                                <p class="mb-0"><?php echo htmlspecialchars($adminInfo['phone']); ?></p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-muted small">Role</label>
                                                <p class="mb-0"><span class="badge bg-primary">Administrator</span></p>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted small">Address</label>
                                                <p class="mb-0"><?php echo htmlspecialchars($adminInfo['address']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Actions -->
                                <div class="card shadow-sm border-0 mt-4">
                                    <div class="card-header bg-light border-bottom">
                                        <h5 class="mb-0"><i class="lni lni-shield"></i> Security</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">Manage your account security settings</p>
                                        <a href="settings_management.php" class="btn btn-sm btn-primary">
                                            <i class="lni lni-lock"></i> Change Password
                                        </a>
                                    </div>
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

    <?php include '../footerscripts.php'; ?>

</body>
</html>
