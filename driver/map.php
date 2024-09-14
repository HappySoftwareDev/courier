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
    <style>
        #map {
            height: 560px;
        }

        #floating-panel {
            position: absolute;
            top: 70px;
            left: 450px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto', 'sans-serif';
            line-height: 10px;
            padding-left: 15px;
        }

        #addDpanel {
            position: absolute;
            top: 110px;
            left: 1123px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto', 'sans-serif';
            line-height: 20px;
            padding-left: 15px;
        }

        #detailz {
            position: absolute;
            top: 500px;
            left: 0px;
            Width: 100%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #FFF;
            text-align: left;
            float: right;
            font-family: 'Roboto', 'sans-serif';
            line-height: 20px;
            padding-left: 15px;
        }

        #az {
            float: left;
        }
    </style>
    <script src="https://ajax.googleapis.com/libs/jquery/2.0.0/jquery.min.js"></script>
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
            }
            ?>

            <!--logo start-->
            <a href="new_orders.php" class="logo"><?php echo $company_name; ?><span class="lite"> Deliveries</span></a>
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
                        <a class="" href="accepted_orders.php"">
                          <i class=" icon_download"></i>
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
                        <div class="col-lg-12 col-md-12">
                            <b>Start: </b>
                            <select id="start" class="form-control">
                                <?php
                                $user = $_SESSION['MM_Username'];
                                global $Connect;

                                $get = "SELECT * FROM `bookings` where status = 'new' ";

                                $run = mysqli_query($Connect, $get);

                                while ($row_type = mysqli_fetch_array($run)) {
                                    $address = $row_type['pick_up_address'];
                                    $ID = $row_type['order_id'];

                                    echo "<option value='$address'>$address</option>";
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <b>End: </b> <br />
                            <select id="end" class="form-control">
                                <option></option>
                                <?php
                                $user = $_SESSION['MM_Username'];
                                $get = "SELECT * FROM `bookings` where status = 'new'";

                                $run = mysqli_query($Connect, $get);

                                while ($row_type = mysqli_fetch_array($run)) {
                                    $drop_address = $row_type['drop_address'];
                                    $ID = $row_type['order_id'];

                                    echo "<option value='$drop_address'>$drop_address</option>";
                                }

                                ?>
                            </select>


                        </div>
                    </div>
                </div>

                <div class="row">

                </div>
                <!--/.row-->


                <div class="row">

                </div>

                <div class="panel-group m-bot20" id="accordion">


                </div>


                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div id="map"></div>

                    </div>

                </div>

                <script>
                    function initMap() {
                        var directionsService = new google.maps.DirectionsService;
                        var directionsDisplay = new google.maps.DirectionsRenderer;
                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 10,
                            center: {
                                lat: -17.824858,
                                lng: 31.053028
                            }
                        });
                        directionsDisplay.setMap(map);

                        var onChangeHandler = function() {
                            calculateAndDisplayRoute(directionsService, directionsDisplay);
                        };
                        document.getElementById('start').addEventListener('change', onChangeHandler);
                        document.getElementById('end').addEventListener('change', onChangeHandler);
                    }

                    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
                        directionsService.route({
                            origin: document.getElementById('start').value,
                            destination: document.getElementById('end').value,
                            travelMode: 'DRIVING'
                        }, function(response, status) {
                            if (status === 'OK') {
                                directionsDisplay.setDirections(response);
                            } else {
                                window.alert('Directions request failed due to ' + status);
                            }
                        });
                    }
                </script>

                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAASD--ei5pvGlTxWLBswb4z4q_4J2vQS4&libraries=places&callback=initMap"></script>



                <script src="https://www.gstatic.com/firebasejs/4.1.2/firebase.js"></script>
                <script>
                    // Initialize Firebase
                    var config = {
                        apiKey: "AIzaSyCHyMgct5EYcxtr8DpVgeICWEHsaz0y6r8",
                        authDomain: "mre-localhost-1494982496654.firebaseapp.com",
                        databaseURL: "https://mre-localhost-1494982496654.firebaseio.com",
                        projectId: "mre-localhost-1494982496654",
                        storageBucket: "mre-localhost-1494982496654.appspot.com",
                        messagingSenderId: "560569853708"
                    };
                    firebase.initializeApp(config);
                </script>
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
    <<script src="js/fullcalendar.min.js">
        </script> <!-- Full Google Calendar - Calendar -->
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
                $('#mapp').vectorMap({
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
