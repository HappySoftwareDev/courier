<?php 
// Start the session before any other output
if (!isset($_SESSION)) {
    session_start();
}

error_reporting(0);

require_once '../config/bootstrap.php';
require_once '../function.php';

?>

<!-- header.php - Driver Portal Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" alt="WGRoos Driver" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="accepted_orders.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

                if ($type_of_service == "Taxi") {
                    $srv = "Taxi";
                }
                if ($type_of_service == "Parcel Delivery") {
                    $srv = "Deliveries";
                }
                if ($type_of_service == "Freight Delivery") {
                    $srv = "Freight & Log";
                }
                if ($type_of_service == "Tow Truck") {
                    $srv = "Towing";
                }
            }
            ?>

            <!--logo start-->
            <a href="new_orders.php" class="logo"><?php echo $site_name; ?></a>
            <!--logo end-->

            <div class="top-nav notification-row">
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">

                    <!-- task notificatoin end -->
                    <!-- inbox notificatoin start-->

                    <!-- inbox notificatoin end -->
                    <!-- alert notification start-->

                    <!-- alert notification end-->
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">

                            </span>
                            <span class="username"><?php getDriversNameOnApp(); ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li class="eborder-top">
                                <a href="profile.php"><i class="icon_profile"></i> My Profile</a>
                            </li>
                            <li>
                                <a href="massage.php"><i class="icon_mail_alt"></i> My Inbox</a>
                            </li>

                            <li>
                                <a href="index.php"><i class="icon_key_alt"></i> Log Out</a>
                            </li>

                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
        </header>
        <!--header end-->
        
        <?php
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


