<?php 
// Start the session before any other output
if (!isset($_SESSION)) {
    session_start();
}

error_reporting(0);

require_once '../../config/bootstrap.php';
require_once '../../function.php';

$driver_name = $_SESSION['driver_name'] ?? $_SESSION['CC_Username'] ?? 'Driver';
?>

<!-- header.php - Driver Portal Top Navigation -->
<header class="page-header d-print-none sticky-top bg-white border-bottom-lg border-bottom border-light">
    <div class="container-xl">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page brand -->
                <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal" href=".">
                    <h2 class="mb-0"><?php echo htmlspecialchars($driver_name); ?> - Driver Portal</h2>
                </div>
            </div>
            <!-- Page title actions -->
            <div class="col-auto d-print-none flex-grow-1 flex-sm-grow-0">
                <div class="btn-list flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-icon btn-outline-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="lni lni-user"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="profile.php"><i class="lni lni-user"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="message.php"><i class="lni lni-envelope"></i> Messages</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?logout=true"><i class="lni lni-exit"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
        $user = $_SESSION['MM_Username'];

        $get_driver = "SELECT * FROM driver WHERE username='$user' ";

        $stmt = $DB->prepare( $get_driver);

        foreach ($results as $1) {
            $ID = $row_type['driverID'];
            $company_name = $row_type['company_name'];
            $online = $row_type['online'];
            $mode_of_transport = $row_type['mode_of_transport'];
            $username = $row_type['username'];
            $type_of_service = $row_type['type_of_service'];

            $link = "afterPick.php";

            if ($type_of_service == "Taxi") {
                $link = "taxi.afterPick.php";
            }
			
			$ex="1";
			//$expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));
			if ($ex == "1") {
                    $show = "
		    <li class='active'>
                      <a class='' href='new_orders.php'>
                          <i class='icon_house_alt'></i>
                          <span>New Orders</span>
                      </a>
                  </li>
				   <li>
                      <a class=''  href='accepted_orders.php'>
                          <i class='icon_download'></i>
                          <span>Accepted Orders</span>

                      </a>

                  </li>
                  <li class='sub-menu'>
                      <a href='javascript:;' class=''>
                          <i class='icon_clock'></i>
                          <span>Archived Orders</span>
                          <span class='menu-arrow arrow_carrot-right'></span>
                      </a>
                      <ul class='sub'>
                          <li><a class='' href='AllOrders.php'>All</a></li>
                          <li><a class='' href='completedOrders.php'>Completed Orders</a></li>
                          <li><a class='' href='$link'>Live Orders</a></li>
                      </ul>
                  </li>
                  <li>
                      <a class='' href='profile.php'>
                          <i class='icon_profile'></i>
                          <span>My Account</span>
                      </a>
                  </li>
				  <li>
                      <a class='' href='map.php'>
                          <i class='fa fa-map-marker'></i>
                          <span>map</span>
                      </a>
                  </li>
                  
                  <li>
                      <a class='' href='message.php'>
                          <i class='icon_mail'></i>
                          <span>Messages</span>

                      </a>

                  </li>
                   <li>
                     <a href='index.php'><i class='icon_key_alt'></i> Log Out</a>
                   </li>
		    ";
                } else {
                    $show = "<div style='color:red'><h2>Failed to load the menu please contact support!<h2></div>";
                }

        }
        ?>
<div id="sidebar" class="nav-collapse" style="position: relative; z-index: 9999; background-color: #fff; margin-top: 60px;">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" style="padding: 50px; list-style: none;">
        <?php echo $show; ?>
    </ul>
    <!-- sidebar menu end-->
</div>


