<?php
/**
 * Footer Partial
 */
?>
<footer class="footer mt-5 py-4 bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h5><?php echo APP_NAME; ?></h5>
                <p class="text-muted">
                    Fast, reliable, and affordable courier and logistics services.
                </p>
                <ul class="list-unstyled social-links">
                    <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="<?php echo baseUrl('/about'); ?>">About Us</a></li>
                    <li><a href="<?php echo baseUrl('/services'); ?>">Services</a></li>
                    <li><a href="<?php echo baseUrl('/pricing'); ?>">Pricing</a></li>
                    <li><a href="<?php echo baseUrl('/contact'); ?>">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Support</h6>
                <ul class="list-unstyled">
                    <li><a href="<?php echo baseUrl('/help'); ?>">Help Center</a></li>
                    <li><a href="<?php echo baseUrl('/faq'); ?>">FAQ</a></li>
                    <li><a href="<?php echo baseUrl('/status'); ?>">System Status</a></li>
                    <li><a href="<?php echo baseUrl('/contact'); ?>">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Legal</h6>
                <ul class="list-unstyled">
                    <li><a href="<?php echo baseUrl('/terms'); ?>">Terms of Service</a></li>
                    <li><a href="<?php echo baseUrl('/privacy'); ?>">Privacy Policy</a></li>
                    <li><a href="<?php echo baseUrl('/cookies'); ?>">Cookie Policy</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    &copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted mb-0">
                    Contact: <?php echo APP_PHONE; ?> | <?php echo APP_EMAIL; ?>
                </p>
            </div>
        </div>
    </div>
</footer>


