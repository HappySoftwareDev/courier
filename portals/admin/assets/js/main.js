/* Admin Portal Main JavaScript */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar toggle for mobile
    initSidebarToggle();
    
    // Initialize active link highlighting
    updateActiveLink();
    
    // Initialize tooltips
    initTooltips();
});

// Sidebar Toggle for Mobile
function initSidebarToggle() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar-nav-wrapper');
    const overlay = document.querySelector('.overlay');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            if (sidebar) {
                sidebar.classList.toggle('active');
            }
            if (overlay) {
                overlay.classList.toggle('active');
            }
        });
    }
    
    // Close sidebar when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            if (sidebar) {
                sidebar.classList.remove('active');
            }
            overlay.classList.remove('active');
        });
    }
}

// Update active sidebar link
function updateActiveLink() {
    const currentPage = location.pathname.split('/').pop() || 'index.php';
    const links = document.querySelectorAll('.sidebar-nav a');
    
    links.forEach(function(link) {
        const href = link.getAttribute('href') || '';
        if (href === currentPage || href.includes(currentPage)) {
            link.classList.add('active');
            // Also set parent menu as active
            const parent = link.closest('.nav-item-has-children');
            if (parent) {
                const collapse = parent.querySelector('.collapse');
                if (collapse) {
                    collapse.classList.add('show');
                    const toggle = parent.querySelector('[data-bs-toggle="collapse"]');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'true');
                    }
                }
            }
        }
    });
}

// Initialize Bootstrap Tooltips
function initTooltips() {
    try {
        const tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    } catch (e) {
        console.log('Bootstrap not loaded yet');
    }
}

// Close all dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const notificationItem = event.target.closest('.notification-item');
    const messageItem = event.target.closest('.message-item');
    const profileItem = event.target.closest('.profile-item');
    
    if (!notificationItem && !messageItem && !profileItem) {
        const dropdowns = document.querySelectorAll(
            '#notifications-dropdown, #messages-dropdown, #profile-dropdown'
        );
        dropdowns.forEach(function(dropdown) {
            dropdown.style.display = 'none';
        });
    }
});

// Utility function to show toast notifications
function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toastContainer') || createToastContainer();
    const toastEl = document.createElement('div');
    toastEl.className = 'alert alert-' + type + ' alert-dismissible fade show';
    toastEl.setAttribute('role', 'alert');
    toastEl.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    toastContainer.appendChild(toastEl);
    
    // Auto dismiss after 5 seconds
    setTimeout(function() {
        toastEl.remove();
    }, 5000);
}

// Create toast container if it doesn't exist
function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toastContainer';
    container.style.position = 'fixed';
    container.style.top = '20px';
    container.style.right = '20px';
    container.style.zIndex = '9999';
    container.style.minWidth = '300px';
    document.body.appendChild(container);
    return container;
}

// Format currency
function formatCurrency(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(value);
}

// Format date
function formatDate(date) {
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(new Date(date));
}

// Confirm delete action
function confirmDelete(itemName = 'this item') {
    return confirm('Are you sure you want to delete ' + itemName + '? This action cannot be undone.');
}
