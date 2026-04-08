<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}
// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//$response = array();

include ("../admin/pages/site_settings.php");

require_once '../config/bootstrap.php';
require_once '../function.php';


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
        <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title>Driver - <?php echo $site_name ?></title>
    
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


        <?php include 'side-menu.php'; ?>

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
                                global $DB;

                                $get = "SELECT * FROM `bookings` where status = 'new' ";

                                $stmt = $DB->prepare( $get);

                                foreach ($results as $1) {
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

                                $stmt = $DB->prepare( $get);

                                foreach ($results as $1) {
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

    <?php include 'footer_scripts.php'; ?>

</body>

</html>


