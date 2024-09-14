<?php
if (!isset($_SESSION)) {
    session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
    // For security, start by assuming the visitor is NOT authorized.
    $isValid = False;

    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
    if (!empty($UserName)) {
        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
        // Parse the strings into arrays.
        $arrUsers = Explode(",", $strUsers);
        $arrGroups = Explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Or, you may restrict access to only certain users based on their username.
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        if (($strUsers == "") && true) {
            $isValid = true;
        }
    }
    return $isValid;
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit;
}
?>
<?php require("../function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Driver - Merchant Couriers</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- full calendar css-->
    <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
    <link href="assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
    <!-- easy pie chart-->
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/fullcalendar.css">
    <link href="css/widgets.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/xcharts.min.css" rel=" stylesheet">
    <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <!-- =======================================================
        Theme Name: NiceAdmin
        Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        Author: BootstrapMade
        Author URL: https://bootstrapmade.com
    ======================================================= -->
</head>

<body>
    <!-- container section start -->
    <section id="container" class="">


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
            <a href="new_orders.php" class="logo"><?php echo $company_name; ?><span class="lite"> <?php echo $srv; ?></span></a>
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

        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu">
                    <li class="active">
                        <a class="" href="new_orders.php">
                            <i class="icon_house_alt"></i>
                            <span>New Orders</span>
                        </a>
                    </li>
                    <li>
                        <a class="" href="accepted_orders.php">
                            <i class="icon_download"></i>
                            <span>Accepted Orders</span>

                        </a>

                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="icon_clock"></i>
                            <span>Archived Orders</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="AllOrders.php">All</a></li>
                            <li><a class="" href="completedOrders.php">Completed Orders</a></li>
                            <li><a class="" href="afterPick.php">Live Orders</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="" href="profile.php">
                            <i class="icon_profile"></i>
                            <span>My Account</span>
                        </a>
                    </li>
                    <li>
                        <a class="" href="map.php">
                            <i class="fa fa-map-marker"></i>
                            <span>map</span>
                        </a>
                    </li>
                    <li>
                        <a class="" href="message.php">
                            <i class="icon_mail"></i>
                            <span>Messages</span>

                        </a>

                    </li>
                    <li>
                        <a href="index.php"><i class="icon_key_alt"></i> Log Out</a>
                    </li>

                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="new_orders.php">Home</a></li>
                            <li><i class="fa fa-laptop"></i>Completed Orders</li>
                        </ol>
                    </div>
                </div>

                <?php
                if (isset($_POST['onway'])) {
                    $to1 = "bamhara1@gmail.com";
                    $to2 = $_POST['email'];

                    $from = $_POST['driveremail'];
                    $message = "Driver is on the way";
                    $headers = "From: $from\n";
                    mail($to1, '', $message, $headers);
                    mail($to2, '', $message, $headers);
                }

                ?>

                <?php

                if (isset($_GET['orderD'])) {

                    $MrE = $_GET['orderD'];

                    $get = "SELECT * FROM `bookings` where order_id= '$MrE' ";

                    $run = mysqli_query($Connect, $get);

                    while ($row_type = mysqli_fetch_array($run)) {
                        $ID = $row_type['order_id'];
                        $Date = $row_type['Date'];
                        $email_fro = $row_type['email'];
                        $address = $row_type['pick_up_address'];
                        $drop_address = $row_type['drop_address'];
                        $name = $row_type['Name'];
                        $phone = $row_type['phone'];
                        $pick_up_date = $row_type['pick_up_date'];
                        $drop_date = $row_type['drop_date'];
                        $Drop_name = $row_type['Drop_name'];
                        $Total_price = $row_type['Total_price'];
                        $drop_phone = $row_type['drop_phone'];
                        $weight_of_package = $row_type['weight'];
                        $package_quantity = $row_type['quantity'];
                        $insurance = $row_type['insurance'];
                        $value_of_package = $row_type['value'];
                        $type_of_transport = $row_type['type_of_transport'];
                        $note = $row_type['drivers_note'];
                        $time = $row_type['pick_up_time'];
                        $drop_time = $row_type['drop_time'];
                        $status = $row_type['status'];

                        $details = "<tr>
                <td>$ID</td>
				<td>$name</td>
				<td>$address</td>
				<td>$drop_address</td>
				<td><a class='btn btn-info' href='' title='Bootstrap 3 themes generator'><span class='fa fa-file-o'></span> Info</a></td>
            </tr>";

                        $MC = "<ul class='list-group'>
                   <li class='list-group-item'><h3>From</h3></li>
			       <li class='list-group-item'><b>Name:</b> $name<br></li>
                   <li class='list-group-item'><b>Phone:</b> $phone<br/></li>
                   <li class='list-group-item'><b>Email:</b> $email_fro <br/></li>

				   <li class='list-group-item'><h3>Deliver To</h3></li>
				   <li class='list-group-item'><b>Name:</b> $Drop_name<br></li>
                   <li class='list-group-item'><b>Phone:</b> $drop_phone<br/></li>

				  <li class='list-group-item'> <h3>Pick Up Address</h3></li>
                   <li class='list-group-item'><b>Address:</b> $address <br/></li>
                   <li class='list-group-item'><b>Pick Up Date:</b> $pick_up_date <br/></li>
                   <li class='list-group-item'><b>Pick Up Time:</b> $time <br/><br/></li>

				   <li class='list-group-item'><h3>Delivery Address</h3></li>
                   <li class='list-group-item'><b>Address:</b> $drop_address <br/></li>
                   <li class='list-group-item'><b>Delivery Date:</b> $drop_date <br/></li>
                   <li class='list-group-item'><b>Delivery Time:</b> $drop_time <br/><br/></li>

				   <li class='list-group-item'><h3>Package Details</h3></li>
				  <li class='list-group-item'> <b>Weight:</b> $weight_of_package<br></li>
                   <li class='list-group-item'><b>Quantity:</b> $package_quantity<br/></li>
                   <li class='list-group-item'><b>Prefered Type Of Transport:</b> $type_of_transport <br/><br/></li>
                  <li class='list-group-item'> <b>Note:</b> $note <br/>

				   </ul>
				   ";

                        $ClientD = "    $address<br>
                                Phone: $phone<br/>
                                Email: $email_fro";
                    }
                }


                ?>





                <!-- project team & activity start -->

                <?php $date = date("Y-m-d");
                $time = date("H:m");
                $datetime = $date . "T" . $time;

                $user = $_SESSION['MM_Username'];

                $get = "SELECT * FROM `driver` where username = '$user' LIMIT 1 ";

                $run = mysqli_query($Connect, $get);

                while ($row_type = mysqli_fetch_array($run)) {
                    $driverID = $row_type['driverID'];
                    $username = $row_type['username'];
                    $email = $row_type['email'];
                    $drivername = $row_type['name'];
                }
                ?>



                <form method="POST" action="<?php echo $editFormAction; ?>" name="acceptForm">
                    <input type="hidden" class="form-control" name="status" value="<?php echo $username; ?>">
                    <input type="hidden" class="form-control" name="status_up_date" value="<?php echo $datetime; ?>">
                    <input type="hidden" class="form-control" name="driveremail" value="<?php echo $email; ?>">
                    <input type="hidden" class="form-control" name="name" value="<?php echo $drivername; ?>">
                    <input type="hidden" class="form-control" name="clientEmail" value="<?php echo $email_fro; ?>">
                    <input type="hidden" class="form-control" name="order_id" value="<?php echo $ID; ?>">
                    <input type="hidden" name="MM_ontheway" value="acceptForm">

                </form>


                <div class="row">

                </div>
                <!--/.row-->


                <div class="row">

                </div>

                <div class="panel-group m-bot20" id="accordion">
                    <?php getCompletedBookingsToDriver(); ?>
                    <div class='btn-group'>

                    </div>
                </div>
                <!--collapse end-->


                <!-- project team & activity start -->


                </div><br><br>


                <!-- project team & activity end -->

            </section>
            <div class="text-right">

            </div>
        </section>
        <!--main content end-->
    </section>
    <!-- container section start -->

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui-1.10.4.min.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js"></script>
    <!-- jQuery full calendar -->
    <script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
    <script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js"></script>
    <script src="assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
    <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/xcharts.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/gdp-data.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/sparklines.js"></script>
    <script src="js/charts.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script>
        //knob
        $(function() {
            $(".knob").knob({
                'draw': function() {
                    $(this.i).val(this.cv + '%')
                }
            })
        });

        //carousel
        $(document).ready(function() {
            $("#owl-slider").owlCarousel({
                navigation: true,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true

            });
        });

        //custom select box

        $(function() {
            $('select.styled').customSelect();
        });

        /* ---------- Map ---------- */
        $(function() {
            $('#map').vectorMap({
                map: 'world_mill_en',
                series: {
                    regions: [{
                        values: gdpData,
                        scale: ['#000', '#000'],
                        normalizeFunction: 'polynomial'
                    }]
                },
                backgroundColor: '#eef3f7',
                onLabelShow: function(e, el, code) {
                    el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
                }
            });
        });
    </script>

</body>

</html>
