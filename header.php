 <?php 
    $aData = json_decode(file_get_contents("admin/pages/website.json"));
	$aLogoData = json_decode(file_get_contents("admin/pages/logo.json"));
	$site_name = !empty($aData->site_name) ? $aData->site_name : "";
	$web_url = !empty($aData->url) ? $aData->url : "";
	$logo = !empty($aLogoData->logo->name) ? $aLogoData->logo->name : "";
	$bus_address = !empty($aData->bus_address) ? $aData->bus_address : "";
	$bus_phone = !empty($aData->bus_phone) ? $aData->bus_phone : "";
	$bus_email = !empty($aData->bus_email) ? $aData->bus_email : "";
	$firebase_config = !empty($aData->firebase_config) ? $aData->firebase_config : "";
	$firebase_push_key = !empty($aData->firebase_push_key) ? $aData->firebase_push_key : "";
	$recapcha_key = !empty($aData->recapcha_key) ? $aData->recapcha_key : "";
?>
 <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <!--<a id="logo" class="pull-left" href="index.php"></a> -->
				<a href="index.php" id="logo_" class="pull-left"><img  src="admin/pages/custom_files/<?php echo $logo; ?>" width="250" /></a>
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">

                        <li><a href="index.php">Home</a></li>



                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Book Delivery <i class="icon-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="book/parcel_delivery.php">Parcel Delivery</a></li>
                                <li><a href="book/freight.booking.php">Send Freight</a></li>
                                <li><a href="book/furniture_go.php">Move Furniture</a></li>
                                <li><a href="freight.reg.php">New Customer? Register.</a></li>
                                <li class="divider"></li>
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Use</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign-UP <i class="icon-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="driver_registration.php">Driver Sign-Up</a></li>
                                <li><a href="freight.reg.php">Customer Sign-Up</a></li>
                                <li class="divider"></li>
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Use</a></li>
                            </ul>
                        </li>
						<li><a href="contact-us.php">Contact-Us</a></li>
                        <li class="login"><a href="driver/index.php"><i class="icon-taxi">Driver Login</i></a></li>
                        <?php if (isset($_SESSION['Userid'])) : ?>
                            <li><a href="logout.php">logout</a></li>
                        <?php else : ?>
                            <li><a href="book/">login</a></li>
                        <?php endif; ?>

                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </header>
    <!-- /header -->