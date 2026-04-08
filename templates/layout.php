<?php
/**
 * Main Layout Template
 * 
 * Unified layout for all application portals.
 * Variables passed to this template:
 * - $pageTitle: Page title
 * - $content: Main content
 * - $breadcrumbs: Array of breadcrumbs
 * - $alert: Array with 'type' and 'message'
 * - $user: Current user array
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include TEMPLATE_PATH . '/partials/head.php'; ?>
    <title><?php echo htmlspecialchars($pageTitle ?? 'Dashboard'); ?> | <?php echo APP_NAME; ?></title>
</head>
<body class="<?php echo isset($user['role']) ? $user['role'] . '-portal' : 'public-portal'; ?>">

    <!-- Navigation -->
    <?php include TEMPLATE_PATH . '/partials/navbar.php'; ?>

    <div class="wrapper">
        <!-- Sidebar -->
        <?php if (isset($showSidebar) && $showSidebar): ?>
            <?php include TEMPLATE_PATH . '/partials/sidebar.php'; ?>
        <?php endif; ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Breadcrumbs -->
            <?php if (!empty($breadcrumbs)): ?>
                <?php include TEMPLATE_PATH . '/partials/breadcrumb.php'; ?>
            <?php endif; ?>

            <!-- Alerts -->
            <?php if (!empty($alert)): ?>
                <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?php echo $alert['message']; ?>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <div class="content-wrapper">
                <?php echo $content ?? ''; ?>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php include TEMPLATE_PATH . '/partials/footer.php'; ?>

    <!-- Scripts -->
    <?php include TEMPLATE_PATH . '/partials/scripts.php'; ?>

</body>
</html>


