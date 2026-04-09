<!-- Admin Portal Footer Scripts -->

<!-- jQuery from CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Admin Custom JS -->
<script src="assets/js/main.js"></script>

<!-- DataTables for table functionality -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Charts library (optional) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<!-- Firebase for notifications -->
<script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-messaging.js"></script>

<script>
    // Initialize tooltips and popovers
    document.addEventListener('DOMContentLoaded', function() {
        // Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Sidebar navigation active link
        var current_page = location.pathname.split('/').pop();
        if (current_page === '') {
            current_page = 'index.php';
        }
        
        var links = document.querySelectorAll('.sidebar-nav a');
        links.forEach(function(link) {
            var href = link.getAttribute('href');
            if (href === current_page || href.includes(current_page)) {
                link.classList.add('active');
            }
        });
    });
</script>
