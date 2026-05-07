<?php
/**
 * Admin Profile Page - Modern Version
 */

require_once '../../../config/bootstrap.php';
require_once '../signin-security.php';

// Set variables
$page_title = 'My Profile';
$site_name = 'WG ROOS Courier Admin';

// Get user info from session
$username = $_SESSION['CC_Username'] ?? '';
$admin_name = $_SESSION['user_name'] ?? 'Admin User';

try {
    global $DB;
    
    // Fetch user data
    $query = "SELECT * FROM `businesspartners` WHERE email = ? LIMIT 1";
    $stmt = $DB->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch();
} catch (Exception $e) {
    error_log('Profile query error: ' . $e->getMessage());
    $user = [];
}

$message = '';
$error = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $name = trim($_POST['businessName'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['businessLocation'] ?? '');
    
    if (empty($name)) {
        $error = 'Business name cannot be empty';
    } else {
        try {
            $update_query = "UPDATE `businesspartners` SET businessName = ?, phone = ?, address = ?, businessLocation = ? WHERE email = ?";
            $stmt = $DB->prepare($update_query);
            $stmt->execute([$name, $phone, $address, $city, $username]);
            
            $message = 'Profile updated successfully';
            
            // Update session
            $_SESSION['user_name'] = $name;
            
            // Refresh user data
            $query = "SELECT * FROM `businesspartners` WHERE email = ? LIMIT 1";
            $stmt = $DB->prepare($query);
            $stmt->execute([$username]);
            $user = $stmt->fetch();
        } catch (Exception $e) {
            $error = 'Error updating profile: ' . $e->getMessage();
        }
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'All password fields are required';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match';
    } elseif (strlen($new_password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        try {
            // Verify old password
            if (!password_verify($old_password, $user['password'] ?? '')) {
                $error = 'Current password is incorrect';
            } else {
                // Update password
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update_query = "UPDATE `businesspartners` SET password = ? WHERE email = ?";
                $stmt = $DB->prepare($update_query);
                $stmt->execute([$hashed_password, $username]);
                
                $message = 'Password changed successfully';
            }
        } catch (Exception $e) {
            $error = 'Error changing password: ' . $e->getMessage();
        }
    }
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
                            <p class="text-muted">Manage your admin account settings</p>
                        </div>

                        <!-- Messages -->
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?php echo htmlspecialchars($message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <!-- Profile Card -->
                            <div class="col-lg-4 mb-40">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img src="../assets/images/avatar.png" alt="<?php echo htmlspecialchars($admin_name); ?>" class="rounded-circle mb-3" width="100">
                                        <h5><?php echo htmlspecialchars($admin_name); ?></h5>
                                        <p class="text-muted"><?php echo htmlspecialchars($username); ?></p>
                                        <p class="text-muted small">Admin User</p>
                                        <hr>
                                        <p class="text-muted small">
                                            Member since<br>
                                            <?php echo date('Y-m-d', strtotime($user['created_at'] ?? 'now')); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Profile Form -->
                            <div class="col-lg-8">
                                <div class="card mb-40">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Update Profile Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="">
                                            <input type="hidden" name="action" value="update_profile">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Business Name</label>
                                                <input type="text" class="form-control" name="businessName" value="<?php echo htmlspecialchars($user['businessName'] ?? ''); ?>" required>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Phone</label>
                                                        <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">City</label>
                                                        <input type="text" class="form-control" name="businessLocation" value="<?php echo htmlspecialchars($user['businessLocation'] ?? ''); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Change Password Form -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="">
                                            <input type="hidden" name="action" value="change_password">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Current Password</label>
                                                <input type="password" class="form-control" name="old_password" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input type="password" class="form-control" name="new_password" placeholder="Min 6 characters" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Confirm New Password</label>
                                                <input type="password" class="form-control" name="confirm_password" required>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </form>
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

    <!-- Scripts -->
    <?php include '../footerscripts.php'; ?>

</body>

</html>
        $user = $_SESSION['MM_Username'];
        $get = "SELECT * FROM `admin` where Email = '$user' ";

        $stmt = $DB->prepare( $get);

        foreach ($results as $1) {
            $ID = $row_type['ID'];
            $Name = $row_type['Name'];
            $Email = $row_type['Email'];
            $phone = $row_type['phone'];
            $pass = $row_type['Password'];
        }
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Manage Your Account</h1>
                        <div class="col-lg-6">
                            <form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" role="form" name="AdminUpdate" required>
                                <fieldset>
                                    <div class="form-group">

                                        <label>First name</label>
                                        <input class="form-control" name="Name" type="text" value="<?php echo $Name; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" name="email" type="email" value="<?php echo $Email; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input class="form-control" name="phone" type="tel" value="<?php echo $phone; ?>" required>
                                        <input class="form-control" name="ID" type="hidden" value="<?php echo $ID; ?>">
                                    </div><br />
                                    <h4>UPDATE PASSWORD</h4>
                                    <div class="form-group">
                                        <input class="form-control" name="password" type="text" value="<?php echo $pass; ?>" required>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Update">
                                </fieldset>
                                <input type="hidden" name="MM_insert" value="addDriver">
                                <input type="hidden" name="MM_update" value="AdminUpdate">
                            </form>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>

