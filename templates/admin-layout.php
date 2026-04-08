<?php
/**
 * Admin Layout Template
 * 
 * Special layout for admin portal with full-width dashboard.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include TEMPLATE_PATH . '/partials/head.php'; ?>
    <title><?php echo htmlspecialchars($pageTitle ?? 'Admin'); ?> | <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo baseUrl('/admin/assets/css/admin.css'); ?>">
</head>
<body class="admin-portal">

    <!-- Navigation -->
    <?php include TEMPLATE_PATH . '/partials/admin-navbar.php'; ?>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <?php include TEMPLATE_PATH . '/partials/admin-sidebar.php'; ?>

        <!-- Main Content -->
        <main class="admin-content">
            <!-- Alerts -->
            <?php if (!empty($alert)): ?>
                <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?php echo $alert['message']; ?>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <div class="admin-content-wrapper">
                <div class="page-header">
                    <h1><?php echo htmlspecialchars($pageTitle ?? 'Dashboard'); ?></h1>
                    <?php if (!empty($pageActions)): ?>
                        <div class="page-actions">
                            <?php echo $pageActions; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php echo $content ?? ''; ?>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php include TEMPLATE_PATH . '/partials/footer.php'; ?>

    <!-- Scripts -->
    <?php include TEMPLATE_PATH . '/partials/scripts.php'; ?>
    <script src="<?php echo baseUrl('/admin/assets/js/admin.js'); ?>"></script>

</body>
</html>


