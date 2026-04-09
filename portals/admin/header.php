<!-- ########## Header Start ########## -->
<header class="header">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="lni lni-menu-hamburger"></i>
                    </button>
                    <form class="ml-40" method="get" action="search.php">
                        <div class="search-box">
                            <input type="text" class="search-field" placeholder="Search..." name="q" required>
                            <button type="submit"><i class="lni lni-search-alt"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right d-flex justify-content-end align-items-center">
                    <!-- Notifications -->
                    <div class="notification-item">
                        <button class="notification-icon" onclick="toggleNotifications()">
                            <i class="lni lni-bell"></i>
                            <span class="notification-counter">3</span>
                        </button>
                        <div id="notifications-dropdown" class="notification-dropdown" style="display:none;">
                            <div class="notification-header">
                                <h5>Notifications</h5>
                            </div>
                            <ul class="notification-list">
                                <li>
                                    <a href="#">
                                        <div class="notification-content">
                                            <p>New booking received</p>
                                            <span>5 mins ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="notification-content">
                                            <p>Driver registration pending</p>
                                            <span>20 mins ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="notification-content">
                                            <p>Payment received</p>
                                            <span>1 hour ago</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="message-item">
                        <button class="message-icon" onclick="toggleMessages()">
                            <i class="lni lni-message"></i>
                            <span class="message-counter">2</span>
                        </button>
                        <div id="messages-dropdown" class="message-dropdown" style="display:none;">
                            <div class="message-header">
                                <h5>Messages</h5>
                            </div>
                            <ul class="message-list">
                                <li>
                                    <a href="#">
                                        <div class="message-content">
                                            <strong>Admin User</strong>
                                            <p>Hello, how are things?</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="message-content">
                                            <strong>System</strong>
                                            <p>Daily report is ready</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="profile-item">
                        <button class="profile-btn" onclick="toggleProfile()">
                            <img src="<?php 
                                $avatarPath = 'assets/images/avatar.png';
                                echo file_exists($avatarPath) ? $avatarPath : 'placeholder.php?type=avatar&w=30&h=30';
                            ?>" alt="Admin" class="profile-avatar">
                            <span class="profile-name"><?php echo $_SESSION['user_name'] ?? 'Admin'; ?></span>
                            <i class="lni lni-chevron-down"></i>
                        </button>
                        <div id="profile-dropdown" class="profile-dropdown" style="display:none;">
                            <a href="profile.php" class="profile-dropdown-item">
                                <i class="lni lni-user"></i> My Profile
                            </a>
                            <a href="settings.php" class="profile-dropdown-item">
                                <i class="lni lni-cog"></i> Settings
                            </a>
                            <hr>
                            <a href="signin-security.php?doLogout=true" class="profile-dropdown-item">
                                <i class="lni lni-arrow-left"></i> Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ########## Header End ########## -->

<script>
    // Toggle notification dropdown
    function toggleNotifications() {
        var dropdown = document.getElementById('notifications-dropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        // Close other dropdowns
        document.getElementById('messages-dropdown').style.display = 'none';
        document.getElementById('profile-dropdown').style.display = 'none';
    }
    
    // Toggle messages dropdown
    function toggleMessages() {
        var dropdown = document.getElementById('messages-dropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        // Close other dropdowns
        document.getElementById('notifications-dropdown').style.display = 'none';
        document.getElementById('profile-dropdown').style.display = 'none';
    }
    
    // Toggle profile dropdown
    function toggleProfile() {
        var dropdown = document.getElementById('profile-dropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        // Close other dropdowns
        document.getElementById('notifications-dropdown').style.display = 'none';
        document.getElementById('messages-dropdown').style.display = 'none';
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.notification-item') && 
            !event.target.closest('.message-item') && 
            !event.target.closest('.profile-item')) {
            document.getElementById('notifications-dropdown').style.display = 'none';
            document.getElementById('messages-dropdown').style.display = 'none';
            document.getElementById('profile-dropdown').style.display = 'none';
        }
    });
    
    // Sidebar toggle
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        var sidebar = document.querySelector('.sidebar-nav-wrapper');
        sidebar.classList.toggle('active');
    });
</script>
