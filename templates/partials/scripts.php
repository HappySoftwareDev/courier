<?php
/**
 * Scripts Partial
 * 
 * Common scripts loaded on all pages.
 */
?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Main Application JS -->
<script src="<?php echo baseUrl('/js/app.js'); ?>"></script>

<!-- Form Validation -->
<script>
(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<!-- CSRF Token Setup for AJAX -->
<script>
$(document).ajaxSend(function(event, xhr, settings) {
    var token = $('meta[name="csrf-token"]').attr('content');
    if (token) {
        xhr.setRequestHeader('X-CSRF-Token', token);
    }
});
</script>

<!-- Additional Scripts -->
<?php if (!empty($customScripts)): ?>
    <?php echo $customScripts; ?>
<?php endif; ?>


