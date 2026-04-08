<?php
/**
 * Navigation Bar Partial
 * 
 * Main navigation bar for customer portal.
 */

$user = currentUser();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="<?php echo baseUrl(); ?>">
            <img src="<?php echo baseUrl('/img/logo.png'); ?>" alt="<?php echo APP_NAME; ?>" height="40">
            <span class="ms-2"><?php echo APP_NAME; ?></span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isAuth()): ?>
                    <!-- Authenticated User Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('/book/bookings'); ?>">
                            <i class="fas fa-box"></i> My Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('/book/invoices'); ?>">
                            <i class="fas fa-receipt"></i> Invoices
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($user['name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="<?php echo baseUrl('/book/profile'); ?>">
                                <i class="fas fa-user-circle"></i> Profile
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo baseUrl('/book/settings'); ?>">
                                <i class="fas fa-cog"></i> Settings
                            </a></li>
                            <?php if (hasRole('admin')): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo baseUrl('/admin/dashboard'); ?>">
                                    <i class="fas fa-lock"></i> Admin Panel
                                </a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo baseUrl('/book/logout'); ?>">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Guest Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('/book/signin'); ?>">
                            <i class="fas fa-sign-in-alt"></i> Sign In
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white ms-2" href="<?php echo baseUrl('/book/signup'); ?>">
                            <i class="fas fa-user-plus"></i> Sign Up
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


