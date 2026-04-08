<?php
/**
 * Sidebar Partial
 * 
 * Sidebar navigation for customer/driver portal.
 */

$user = currentUser();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<aside class="sidebar">
    <div class="sidebar-inner">
        <!-- User Profile Widget -->
        <?php if (isAuth()): ?>
            <div class="user-widget">
                <div class="avatar">
                    <img src="<?php echo baseUrl('/img/default-avatar.png'); ?>" alt="<?php echo htmlspecialchars($user['name']); ?>">
                </div>
                <div class="user-info">
                    <h5><?php echo htmlspecialchars($user['name']); ?></h5>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <?php if (hasRole('customer')): ?>
                <a href="<?php echo baseUrl('/book/dashboard'); ?>" class="nav-item <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="<?php echo baseUrl('/book/bookings'); ?>" class="nav-item <?php echo $currentPage === 'bookings' || $currentPage === 'booking' ? 'active' : ''; ?>">
                    <i class="fas fa-box"></i> My Bookings
                </a>
                <a href="<?php echo baseUrl('/book/quote'); ?>" class="nav-item <?php echo $currentPage === 'quote' ? 'active' : ''; ?>">
                    <i class="fas fa-calculator"></i> Get Quote
                </a>
                <a href="<?php echo baseUrl('/book/invoices'); ?>" class="nav-item <?php echo $currentPage === 'invoices' ? 'active' : ''; ?>">
                    <i class="fas fa-receipt"></i> Invoices
                </a>
            <?php elseif (hasRole('driver')): ?>
                <a href="<?php echo baseUrl('/driver/dashboard'); ?>" class="nav-item <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="<?php echo baseUrl('/driver/available'); ?>" class="nav-item <?php echo $currentPage === 'available' ? 'active' : ''; ?>">
                    <i class="fas fa-list"></i> Available Orders
                </a>
                <a href="<?php echo baseUrl('/driver/accepted'); ?>" class="nav-item <?php echo $currentPage === 'accepted' ? 'active' : ''; ?>">
                    <i class="fas fa-check-circle"></i> My Orders
                </a>
                <a href="<?php echo baseUrl('/driver/earnings'); ?>" class="nav-item <?php echo $currentPage === 'earnings' ? 'active' : ''; ?>">
                    <i class="fas fa-money-bill"></i> Earnings
                </a>
            <?php endif; ?>

            <hr class="my-3">

            <a href="<?php echo baseUrl('/book/profile'); ?>" class="nav-item <?php echo $currentPage === 'profile' ? 'active' : ''; ?>">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="<?php echo baseUrl('/book/settings'); ?>" class="nav-item <?php echo $currentPage === 'settings' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> Settings
            </a>
            <a href="<?php echo baseUrl('/book/help'); ?>" class="nav-item">
                <i class="fas fa-question-circle"></i> Help & Support
            </a>
        </nav>
    </div>
</aside>


