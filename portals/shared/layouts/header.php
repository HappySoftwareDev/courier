<?php
/**
 * Unified Header Template for All Portals
 * Used by Admin, Driver, and Booking portals
 * @package app.wgroos.com
 * @subpackage Shared Layouts
 */

// Get current portal from session
$portal = isset($_SESSION['portal']) ? $_SESSION['portal'] : 'booking';
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'guest';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

// Determine portal display name
$portal_names = [
    'admin' => 'Admin Dashboard',
    'driver' => 'Driver Portal',
    'booking' => 'Booking System'
];
$portal_display = isset($portal_names[$portal]) ? $portal_names[$portal] : 'Dashboard';

// Determine portal base path
$portal_base = "../../portals/{$portal}/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($portal_display); ?> - WGROOS</title>
    
    <!-- Favicon -->
    <link rel="icon" href="../../mc.favicon" type="image/x-icon">
    
    <!-- Shared CSS Files -->
    <link rel="stylesheet" href="../../portals/shared/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../portals/shared/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../portals/shared/css/animate.min.css">
    <link rel="stylesheet" href="../../portals/shared/css/style.css">
    
    <!-- Portal-specific CSS -->
    <link rel="stylesheet" href="../../css/default.css">
    <link rel="stylesheet" href="../../css/responsive.css">
    
    <?php if (file_exists("../../portals/{$portal}/assets/css/custom.css")) { ?>
    <link rel="stylesheet" href="../../portals/<?php echo htmlspecialchars($portal); ?>/assets/css/custom.css">
    <?php } ?>
</head>
<body class="portal-<?php echo htmlspecialchars($portal); ?>">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="../../portals/<?php echo htmlspecialchars($portal); ?>/index.php">
                <img src="../../img/logo.png" alt="WGROOS" height="40" class="d-inline-block align-text-top">
                <span class="ms-2 d-none d-md-inline"><?php echo htmlspecialchars($portal_display); ?></span>
            </a>
            
            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Portal-specific menu items will be included here -->
                    <li class="nav-item">
                        <a class="nav-link" href="../../portals/<?php echo htmlspecialchars($portal); ?>/index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    
                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> 
                            <?php echo htmlspecialchars(substr($user_name, 0, 20)); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li>
                                <a class="dropdown-item" href="../../portals/<?php echo htmlspecialchars($portal); ?>/profile.php">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../../portals/<?php echo htmlspecialchars($portal); ?>/settings.php">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="../../portals/includes/logout.php">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Alert Container for system messages -->
    <div class="container-fluid mt-3">
        <div id="alert-container"></div>
    </div>
    
    <!-- Main Content Container -->
    <main class="container-fluid mt-4">
