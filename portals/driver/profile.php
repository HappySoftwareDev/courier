<?php
require_once '../../config/bootstrap.php';
require_once 'signin-security.php';

$page_title = 'My Profile';
$site_name = 'WG ROOS Courier';

// Get driver info from session
$driverUsername = $_SESSION['MM_Username'] ?? '';
$driverId = $_SESSION['driver_id'] ?? '';

$driverInfo = [
    'name' => $_SESSION['driver_name'] ?? 'Driver',
    'email' => '',
    'phone' => '',
    'city' => '',
    'vehicle_make' => '',
    'vehicle_model' => '',
    'vehicle_reg' => '',
];

// Fetch driver details
try {
    global $DB;
    
    $stmt = $DB->prepare("SELECT * FROM `driver` WHERE username = ? OR driverID = ? LIMIT 1");
    $stmt->execute([$driverUsername, $driverId]);
    $driver = $stmt->fetch();
    
    if ($driver) {
        $driverInfo['name'] = $driver['name'] ?? $driverInfo['name'];
        $driverInfo['email'] = $driver['email'] ?? '';
        $driverInfo['phone'] = $driver['phone'] ?? '';
        $driverInfo['city'] = $driver['city'] ?? '';
        $driverInfo['vehicle_make'] = $driver['vehicleMake'] ?? '';
        $driverInfo['vehicle_model'] = $driver['model'] ?? '';
        $driverInfo['vehicle_reg'] = $driver['RegNo'] ?? '';
    }
} catch (Exception $e) {
    error_log('Driver profile fetch error: ' . $e->getMessage());
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
                            <h1 class="mb-10">My Profile</h1>
                            <p class="text-muted">View and manage your profile information</p>
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
                                <h5 class="card-title"><?php echo htmlspecialchars($driverInfo['name']); ?></h5>
                                <p class="text-muted small"><?php echo htmlspecialchars($driverInfo['city'] ?? 'City not specified'); ?></p>
                                <div class="mt-3">
                                    <a href="edit-profile.php" class="btn btn-sm btn-primary w-100 mb-2">
                                        <i class="lni lni-pencil"></i> Edit Profile
                                    </a>
                                    <a href="signin.php?logout=true" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="lni lni-exit"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="col-lg-8">
                        <!-- Personal Information -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="mb-0"><i class="lni lni-user"></i> Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Full Name</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($driverInfo['name']); ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Username</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($driverUsername); ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Email Address</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($driverInfo['email']); ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Phone Number</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($driverInfo['phone']); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">City</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($driverInfo['city']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Information -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="mb-0"><i class="lni lni-car"></i> Vehicle Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Vehicle Make</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($driverInfo['vehicle_make']); ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Vehicle Model</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($driverInfo['vehicle_model']); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">Registration Number</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($driverInfo['vehicle_reg']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

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
