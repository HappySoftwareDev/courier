<!-- ======== Admin Sidebar Navigation =========== -->
<aside class="sidebar-nav-wrapper" style="background:#fff; min-height: 100vh;">
    <div class="navbar-logo">
        <a href="index.php">
            <img src="<?php 
                $logoPath = 'assets/images/logo.png';
                echo file_exists($logoPath) ? $logoPath : 'placeholder.php?type=logo&w=150&h=56';
            ?>" alt="WG ROOS Admin" height="56">
        </a>
    </div>
    
    <nav class="sidebar-nav" style="background:#262d3f; height: calc(100vh - 80px); overflow-y: auto;">
        <ul>
            <!-- Dashboard -->
            <li class="nav-item nav-item-has-children">
                <a href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_1" aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon"><i class="lni lni-dashboard"></i></span>
                    <span class="text">Dashboard</span>
                </a>
                <ul id="ddmenu_1" class="collapse show dropdown-nav">
                    <li>
                        <a href="index.php" class="active">
                            <i class="lni lni-arrow-right"></i> Home
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Bookings Management -->
            <li class="nav-item nav-item-has-children">
                <a href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_2" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon"><i class="lni lni-package"></i></span>
                    <span class="text">Bookings</span>
                </a>
                <ul id="ddmenu_2" class="collapse dropdown-nav">
                    <li>
                        <a href="pages/bookings.php">
                            <i class="lni lni-arrow-right"></i> All Bookings
                        </a>
                    </li>
                    <li>
                        <a href="pages/bookings.php?filter=pending">
                            <i class="lni lni-arrow-right"></i> Pending
                        </a>
                    </li>
                    <li>
                        <a href="pages/bookings.php?filter=assigned">
                            <i class="lni lni-arrow-right"></i> Assigned
                        </a>
                    </li>
                    <li>
                        <a href="pages/bookings.php?filter=completed">
                            <i class="lni lni-arrow-right"></i> Completed
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Users Management -->
            <li class="nav-item nav-item-has-children">
                <a href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_3" aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon"><i class="lni lni-users"></i></span>
                    <span class="text">Users</span>
                </a>
                <ul id="ddmenu_3" class="collapse dropdown-nav">
                    <li>
                        <a href="pages/users.php">
                            <i class="lni lni-arrow-right"></i> All Users
                        </a>
                    </li>
                    <li>
                        <a href="pages/users.php?type=customers">
                            <i class="lni lni-arrow-right"></i> Customers
                        </a>
                    </li>
                    <li>
                        <a href="pages/users.php?type=partners">
                            <i class="lni lni-arrow-right"></i> Partners
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Drivers Management -->
            <li class="nav-item nav-item-has-children">
                <a href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_4" aria-controls="ddmenu_4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon"><i class="lni lni-car"></i></span>
                    <span class="text">Drivers</span>
                </a>
                <ul id="ddmenu_4" class="collapse dropdown-nav">
                    <li>
                        <a href="pages/drivers.php">
                            <i class="lni lni-arrow-right"></i> All Drivers
                        </a>
                    </li>
                    <li>
                        <a href="pages/drivers.php?status=active">
                            <i class="lni lni-arrow-right"></i> Active
                        </a>
                    </li>
                    <li>
                        <a href="pages/drivers.php?status=inactive">
                            <i class="lni lni-arrow-right"></i> Inactive
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Settings -->
            <li class="nav-item nav-item-has-children">
                <a href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_5" aria-controls="ddmenu_5" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon"><i class="lni lni-cog"></i></span>
                    <span class="text">Settings</span>
                </a>
                <ul id="ddmenu_5" class="collapse dropdown-nav">
                    <li>
                        <a href="pages/site_settings.php">
                            <i class="lni lni-arrow-right"></i> General Settings
                        </a>
                    </li>
                    <li>
                        <a href="pages/site_settings.php?tab=payment">
                            <i class="lni lni-arrow-right"></i> Payment Methods
                        </a>
                    </li>
                    <li>
                        <a href="pages/site_settings.php?tab=api">
                            <i class="lni lni-arrow-right"></i> API Keys
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Reports & Analytics -->
            <li class="nav-item">
                <a href="pages/reports.php">
                    <span class="icon"><i class="lni lni-bar-chart"></i></span>
                    <span class="text">Reports</span>
                </a>
            </li>

            <!-- Commissions -->
            <li class="nav-item">
                <a href="pages/commissions.php">
                    <span class="icon"><i class="lni lni-dollar"></i></span>
                    <span class="text">Commissions</span>
                </a>
            </li>

            <!-- System Management -->
            <li class="nav-item nav-item-has-children">
                <a href="#0" data-bs-toggle="collapse" data-bs-target="#ddmenu_6" aria-controls="ddmenu_6" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon"><i class="lni lni-network"></i></span>
                    <span class="text">System</span>
                </a>
                <ul id="ddmenu_6" class="collapse dropdown-nav">
                    <li>
                        <a href="pages/system_health.php">
                            <i class="lni lni-arrow-right"></i> System Health
                        </a>
                    </li>
                    <li>
                        <a href="pages/activity_logs.php">
                            <i class="lni lni-arrow-right"></i> Activity Logs
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Divider -->
            <span class="divider"><hr /></span>

            <!-- Admin Profile -->
            <li class="nav-item">
                <a href="pages/profile.php">
                    <span class="icon"><i class="lni lni-user"></i></span>
                    <span class="text">My Profile</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <a href="pages/login-security.php?doLogout=true">
                    <span class="icon"><i class="lni lni-arrow-left"></i></span>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<div class="overlay"></div>
<!-- ======== Sidebar Navigation End =========== -->
