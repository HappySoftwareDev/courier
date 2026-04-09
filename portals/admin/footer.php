<?php 
// Safe site settings loading - without admin redirects
// These variables should already be set by pages that include this footer
// If not, set safe defaults
if (!isset($site_name)) {
    $site_name = 'WG ROOS Courier';
}
if (!isset($web_url)) {
    $web_url = 'https://example.com';
}
?>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 order-last order-md-first">
                <div class="copyright text-center text-md-start">
                    <p class="text-sm">
                        &copy; 2026 
                        <a href="<?php echo $web_url ?>" rel="nofollow" target="_blank">
                            <?php echo $site_name ?> Admin Panel
                        </a>
                        All rights reserved.
                    </p>
                </div>
            </div>
            <!-- end col-->
            <div class="col-md-6">
                <div class="terms d-flex justify-content-center justify-content-md-end">
                    <a href="../../shared/terms.html" class="text-sm">Terms & Conditions</a>
                    <a href="../../shared/privacy.html" class="text-sm ml-15">Privacy & Policy</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</footer>
