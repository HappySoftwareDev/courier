<?php 
    $aData = json_decode(file_get_contents("../admin/pages/website.json"));
	$site_name = !empty($aData->site_name) ? $aData->site_name : "";
	$web_url = !empty($aData->url) ? $aData->url : "";
	$logo = !empty($aData->logo->name) ? $aData->logo->name : "";
	$bus_address = !empty($aData->bus_address) ? $aData->bus_address : "";
	$bus_phone = !empty($aData->bus_phone) ? $aData->bus_phone : "";
	$bus_email = !empty($aData->bus_email) ? $aData->bus_email : "";
?>
<header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <?php
            $user = $_SESSION['MM_Username'];
            $get = "SELECT * FROM `driver` where username = '$user' ";

            $run = mysqli_query($Connect, $get);

            while ($row_type = mysqli_fetch_array($run)) {
                $ID = $row_type['driverID'];
                $Name = $row_type['name'];
                $company_name = $row_type['company_name'];
                $phone = $row_type['phone'];
                $email = $row_type['email'];
                $address = $row_type['address'];
                $vehicleMake = $row_type['vehicleMake'];
                $model = $row_type['model'];
                $year = $row_type['year'];
                $engineCapacity = $row_type['engineCapacity'];
                $dob = $row_type['DOB'];
                $occupation = $row_type['occupation'];
                //$documents = $row_type['documents'];
                $status = $row_type['online'];
                $profileImage = $row_type['profileImage'];
                $type_of_service = $row_type['type_of_service'];

                $srv = "";

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

        $run_driver = mysqli_query($Connect, $get_driver);

        while ($row_type = mysqli_fetch_array($run_driver)) {
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
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu">
                    <?php echo $show; ?>

                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->