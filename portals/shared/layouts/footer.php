<?php
/**
 * Unified Footer Template for All Portals
 * Used by Admin, Driver, and Booking portals
 * @package app.wgroos.com
 * @subpackage Shared Layouts
 */

$current_year = date('Y');
$portal = isset($_SESSION['portal']) ? $_SESSION['portal'] : 'booking';
?>
    </main><!-- End Main Content -->
    
    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Company Info -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>WGROOS</h5>
                    <p class="small text-muted">
                        Logistics and Transportation Solutions
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li><a href="../../index.php" class="text-decoration-none text-muted">Home</a></li>
                        <li><a href="../../contact.php" class="text-decoration-none text-muted">Contact Us</a></li>
                        <li><a href="../../privacy.php" class="text-decoration-none text-muted">Privacy Policy</a></li>
                        <li><a href="../../terms.php" class="text-decoration-none text-muted">Terms of Service</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-md-4">
                    <h6>Contact Information</h6>
                    <p class="small text-muted">
                        <i class="fas fa-envelope"></i> support@wgroos.com<br>
                        <i class="fas fa-phone"></i> +27 XX XXX XXXX
                    </p>
                </div>
            </div>
            
            <!-- Copyright -->
            <hr class="border-secondary">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="small text-muted mb-0">
                        &copy; <?php echo htmlspecialchars($current_year); ?> WGROOS. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Shared JavaScript Files -->
    <script src="../../portals/shared/js/jquery.min.js"></script>
    <script src="../../portals/shared/js/bootstrap.bundle.min.js"></script>
    <script src="../../portals/shared/js/fontawesome.min.js"></script>
    
    <!-- Shared App Logic -->
    <script src="../../portals/shared/js/app.js"></script>
    
    <!-- Portal-specific scripts -->
    <script src="../../js/init.js"></script>
    
    <?php if (file_exists("../../portals/{$portal}/assets/js/custom.js")) { ?>
    <script src="../../portals/<?php echo htmlspecialchars($portal); ?>/assets/js/custom.js"></script>
    <?php } ?>
</body>
</html>
