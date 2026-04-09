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
                  Powered by
                  <a href="<?php echo $web_url ?>" rel="nofollow" target="_blank">
                    <?php echo $site_name ?> 
                  </a>
                </p>
              </div>
            </div>
            <!-- end col-->
            <div class="col-md-6">
              <div class="terms d-flex justify-content-center justify-content-md-end">
                <a href="../terms.html" class="text-sm">Term & Conditions</a>
                <a href="../privacy.html" class="text-sm ml-15">Privacy & Policy</a>
            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
</footer>

