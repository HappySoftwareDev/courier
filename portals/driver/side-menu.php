<!-- side-menu.php - Driver Portal Sidebar Navigation -->
<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current page for active link highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="index.php">
                <img src="assets/images/favicon.png" alt="WGRoos Driver" height="36" class="navbar-brand-image">
            </a>
        </h1>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="index.php" aria-current="page">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="lni lni-dashboard"></i>
                        </span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'new_orders.php' ? 'active' : ''; ?>" href="new_orders.php" aria-current="page">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="lni lni-bell"></i>
                        </span>
                        <span class="nav-link-title">New Orders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'accepted_orders.php' ? 'active' : ''; ?>" href="accepted_orders.php" aria-current="page">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="lni lni-check-mark-circle"></i>
                        </span>
                        <span class="nav-link-title">Active Orders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'completedOrders.php' ? 'active' : ''; ?>" href="completedOrders.php" aria-current="page">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="lni lni-checkmark-circle"></i>
                        </span>
                        <span class="nav-link-title">Completed Orders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'message.php' ? 'active' : ''; ?>" href="message.php" aria-current="page">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="lni lni-envelope"></i>
                        </span>
                        <span class="nav-link-title">Messages</span>
                    </a>
                </li>

                <li class="nav-item border-top mt-3 pt-3">
                    <a class="nav-link <?php echo $current_page == 'profile.php' ? 'active' : ''; ?>" href="profile.php" aria-current="page">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="lni lni-user"></i>
                        </span>
                        <span class="nav-link-title">My Profile</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?logout=true" aria-current="page">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="lni lni-exit"></i>
                        </span>
                        <span class="nav-link-title">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</aside>

