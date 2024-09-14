<?php
//initialize the session
if (!isset($_SESSION)) {
    session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
    //to fully log out a visitor we need to clear the session varialbles
    $_SESSION['MM_Username'] = NULL;
    $_SESSION['MM_UserGroup'] = NULL;
    $_SESSION['PrevUrl'] = NULL;
    unset($_SESSION['MM_Username']);
    unset($_SESSION['MM_UserGroup']);
    unset($_SESSION['PrevUrl']);

    $logoutGoTo = "texi.login.php";
    if ($logoutGoTo) {
        header("Location: $logoutGoTo");
        exit;
    }
}
?>
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

$MM_restrictGoTo = "taxi.login.php";
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
<?php require("function.php"); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117550135-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-117550135-1');
    </script>


    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Book a taxi on your mobile in Zimbabwe | Merchant Couriers</title>
    <meta name="Book our taxi service online or on your mobile phone app in Zimbabwe. We will send a taxi out to pick you up quickly." content="Book online, local taxi, Taxi pickup, transport service, zimbabwe ">
    <meta name="viewport" content="width=device-width">

    <link re="canonical" href="https://www.merchantcouriers.co.zw/taxi.booking.php" />

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sl-slide.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <style>
        form#multiphase>#phase2,
        #phase3 {
            display: none;
        }
    </style>


    <script type="text/javascript">
        var address, name, email, phone, date, date2, time, time2, drop_address, drop_name, drop_phone, drop_date, drop_time, note, transport,
            weight_of_package, package_quantity, insurance, harm, value_of_package;

        var map;
        var geocoder;
        var bounds = new google.maps.LatLngBounds();
        var markersArray = [];

        //var origin1 = new google.maps.LatLng(55.930, -3.118);
        var origin;
        var destination;
        //var destinationB = new google.maps.LatLng(50.087, 14.421);

        var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
        var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

        function _(x) {
            return document.getElementById(x);
        }

        function initialize() {
            var opts = {
                center: new google.maps.LatLng(-17.824858, 31.053028),
                zoom: 10
            };
            map = new google.maps.Map(document.getElementById('map-canvas'), opts);
            geocoder = new google.maps.Geocoder();
        }

        function processPhase1() {
            address = _("autocomplete").value;
            drop_address = _("drop_address").value;
            name = _("name").value;
            email = _("email").value;
            phone = _("phone").value;
            date = _("date").value;
            time = _("time").value;

            var service = new google.maps.DistanceMatrixService(); //initialize the distance service
            service.getDistanceMatrix({
                origins: [address], //set origin, you can specify multiple sources here
                destinations: [drop_address], //set destination, you can specify multiple destinations here
                travelMode: google.maps.TravelMode.DRIVING, //set the travelmode
                unitSystem: google.maps.UnitSystem.METRIC, //The unit system to use when displaying distance
                avoidHighways: false,
                avoidTolls: false
            }, calcDistance); // here calcDistance is the call back function


            if (address == "" || drop_address == "" || name == "" || email == "" || phone == "" || date == "") {
                alert("Please fill in the fields");
            } else if (address.length < 2) {
                _("addstatus").innerHTML = "Please enter a valid address!";
            } else if (name.length < 2) {
                _("namestatus").innerHTML = "Please fill the name field!";
            } else if (email.length < 10) {
                _("emailstatus").innerHTML = "Please enter a valid email!";
            } else if (date.length < 2) {
                _("datestatus").innerHTML = "A date is required!";
            } else if (phone.length < 10) {
                _("phonestatus").innerHTML = "Phone number is seems to be not valid!";
            } else {

                _("phase1").style.display = "none";
                _("phase3").style.display = "block";
                _("display_address").innerHTML = address;
                _("display_pickuptime").innerHTML = time;
                _("display_pickupdate").innerHTML = date;
                _("progressBar").value = 100;
                _("status").innerHTML = "Step 2 of 2";
                _("startAdd").innerHTML = address;
            }
        }

        var quantity_prices = new Array();
        quantity_prices["0"] = 0;
        quantity_prices["1"] = 0.19;
        quantity_prices["2"] = 0.29;
        quantity_prices["3"] = 0.39;
        quantity_prices["4"] = 0.49;
        quantity_prices["5"] = 0.59;

        var car_prices = new Array();
        car_prices["0"] = 0;
        car_prices["Taxi"] = 0.55;
        car_prices["Motorbike"] = 0.00;

        function getQuantityPrice() {
            var packageQuantityPrice = 0;
            var theForm = document.forms["multiphase"];
            var selectedQuantity = theForm.elements["package_quantity"];

            packageQuantityPrice = quantity_prices[selectedQuantity.value];

            return packageQuantityPrice;
        }

        function getCarPrice() {
            var CarPrice = 0;
            var theForm = document.forms["multiphase"];
            var selectedCar = theForm.elements["transport"];

            CarPrice = car_prices[selectedCar.value];

            return CarPrice;
        }

        function inprecise_round(value, decPlaces) {
            return Math.round(value * Math.pow(10, decPlaces)) / Math.pow(10, decPlaces);
        }

        function precise_round(value, decPlaces) {
            var val = value * Math.pow(10, decPlaces);
            var fraction = (Math.round((val - parseInt(val)) * 10) / 10);

            //this line is for consistency with .NET Decimal.Round behavior
            // -342.055 => -342.06
            if (fraction == -0.5) fraction = -0.6;

            val = Math.round(parseInt(val) + fraction) / Math.pow(10, decPlaces);
            return val;
        }

        function calculateTotal() {
            var actaulPrice = getCarPrice() + getQuantityPrice();

            var totDist = parseFloat(_('outputDiv').value);
            var roundTp = totDist + actaulPrice;
            var roundTpp = totDist + actaulPrice;
            _('tp').innerHTML = roundTp.toFixed(2);
            _('tpp').value = roundTpp.toFixed(2);
        }


        function calcDistance(response, status) {
            var totalp = _("totalp").value;
            var totalW = parseFloat(_("totalW").value);
            var totalC = parseFloat(_("totalC").value);
            var totalT = parseFloat(_("totalT").value);
            var totalIn = parseFloat(_("totalIn").value);
            var totalB = parseFloat(_("totalB").value);
            if (status != google.maps.DistanceMatrixStatus.OK) {
                alert('Error was: ' + status);
            } else {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;
                deleteOverlays();

                for (var i = 0; i < origins.length; i++) {
                    var results = response.rows[i].elements;
                    addMarker(origins[i], false);
                    for (var j = 0; j < results.length; j++) {
                        addMarker(destinations[j], true);
                        var str = (results[j].distance.text);
                        _('outputDiv').value = parseFloat(str.replace(/[^\d\.]*/g, '')) * totalp;
                        _('outputDist').value = (results[j].distance.text);
                    }
                }
            }
        }

        function addMarker(location, isDestination) {
            var icon;
            if (isDestination) {
                icon = destinationIcon;
            } else {
                icon = originIcon;
            }
            geocoder.geocode({
                'address': location
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    bounds.extend(results[0].geometry.location);
                    map.fitBounds(bounds);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        icon: icon
                    });
                    markersArray.push(marker);
                } else {
                    alert('Geocode was not successful for the following reason: ' +
                        status);
                }
            });
        }

        function deleteOverlays() {
            for (var i = 0; i < markersArray.length; i++) {
                markersArray[i].setMap(null);
            }
            markersArray = [];
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        function submitForm() {
            transport = _("transport").value;
            note = _("note").value;
            drop_time = _("drop_time").value;
            package_quantity = _("package_quantity").value;
            harm = _("harm").value;

            if (transport.length < 3 && package_quantity.length < 4 || drop_time == "") {
                alert("Please fill in the fields");
                exit;
            } else if (harm.checked == false) {
                _("harmstatus").innerHTML = "Please check the box to agree with our terms!";
                die;
            } else {
                _("phase3").style.display = "block";
                _("multiphase").method = "post";
                _("multiphase").action = "taxi.submit_parser1.php";
                _("multiphase").submit();
            }
        }

        function change_phase1() {
            _("phase1").style.display = "block";
            _("phase2").style.display = "none";
            _("phase3").style.display = "none";
            _("progressBar").value = 0;
        }

        function change_phase2() {
            _("phase1").style.display = "none";
            _("phase2").style.display = "block";
            _("phase3").style.display = "none";
            _("progressBar").value = 50;
        }
    </script>

    <script type="text/javascript">
        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                (document.getElementById('autocomplete')), {
                    types: ['geocode']
                });

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

        }
    </script>

</head>

<body>

    <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a id="logo" class="pull-left" href="index.php"></a>
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">

                        <li class="active"><a href="index.php">Home</a></li>



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
                        <li class="login"><a href="driver/index.php"><i class="icon-taxi">Driver Login</i></a></li>
                        <li><a href="invite-email.php"><i class="icon-share"></i> Share</a></li>


                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </header>
    <!-- /header -->


    <section class="title">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <h1>Book A Taxi</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li><a href="#">Pages</a> <span class="divider">/</span></li>
                        <li class="active">Booking Taxi</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->


    <section class="container">

        <div class="row contact">
            <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">

                <?php
                $get = "SELECT * FROM `prizelist` WHERE company_name='merchant'";

                $run = mysqli_query($Connect, $get);

                while ($row_type = mysqli_fetch_array($run)) {
                    $ID = $row_type['ID'];
                    $Price_per_km = $row_type['Price_per_km'];
                    $Car_per_km = $row_type['Car_per_km'];
                    $taxi_per_km = $row_type['taxi_price_km'];
                    $weight = $row_type['Weight'];
                    $Insurance = $row_type['Insurance'];
                    $Base_price = $row_type['Base_price'];
                    $Cost_per_item = $row_type['Cost_per_item'];
                }


                ?>


                <fieldset class="registration-form">

                    <h3 id="status">Step 1 of 2...</h3>
                    <progress id="progressBar" class="progress-bar-warning" value="0" max="100" style="width:100%;"></progress>


                    <form action="<?php echo $editFormAction; ?>" method="POST" id="multiphase" onsubmit="showLocation();calcRoute(); return false" name="bookingform">
                        <div id="phase1">
                            <input id="totalp" value="<?php echo $taxi_per_km; ?>" type="hidden">
                            <input id="totalW" value="<?php echo $weight; ?>" type="hidden">
                            <input id="totalC" value="<?php echo $Car_per_km; ?>" type="hidden">
                            <input id="totalT" value="<?php echo $Cost_per_item; ?>" type="hidden">
                            <input id="totalIn" value="<?php echo $Insurance; ?>" type="hidden">
                            <input id="totalB" value="<?php echo $Base_price; ?>" type="hidden">
                            <h2>Enter Pick Up Details!</h2>

                            Pick Up Address
                            <input id="autocomplete" class="input-block-level" placeholder="Enter your address" type="text" name="address" onFocus="geolocate()">
                            <span style="color:red" id="addstatus"></span>
                            Name
                            <input type="text" class="input-block-level" placeholder="Full Name" id="name" name="name">
                            <span style="color:red" id="namestatus"></span>
                            E-mail
                            <input type="email" class="input-block-level" placeholder="email address" id="email" name="email">
                            <span style="color:red" id="emailstatus"></span>
                            Phone Number
                            <input type="tel" class="input-block-level" placeholder="Phone Number" value="+263" id="phone" name="phone">
                            <span style="color:red" id="phonestatus"></span>
                            Enter Pick Up Date
                            <input type="date" class="input-block-level" id="date" name="date">
                            <span style="color:red" id="datestatus"></span>
                            Drop Off Address
                            <input type="text" class="input-block-level" placeholder="Destination" id="drop_address" name="drop_address" onFocus="geolocate()">
                            <span style="color:red" id="addstatus2"></span>

                            <button class="btn btn-success btn-large btn-block" onclick="processPhase1()">Next Step</button>

                        </div>

                        <div id="phase3">
                            <div align="center">
                                <h4>Pick Up Details</h4>
                                Address:<span class="glyphicon glyphicon-map-marker"></span><span id="display_address" style="text-transform: uppercase"></span><br>
                                <span style=" font-size: medium;"> Date: </span> <span class="icon-calendar"></span> <span id="display_pickupdate" style="text-transform: uppercase;"></span>
                                <span style=" font-size: medium;"> Time: </span> <span class="icon-time"></span> <span id="display_pickuptime" style="text-transform: uppercase;"></span>
                                <span><a href="#" onclick="change_phase1()" style="color:orange;">Change</a></span><br /><br />
                            </div>
                            <h2> Enter more details</h2>

                            <select name="time" id="time" class="input-block-level">
                                <option>Pick Up Time</option>
                                <option>6:00 am - to - 7:00 am</option>
                                <option>7:00 am - to - 8:00 am</option>
                                <option>8:00 am - to - 9:00 am</option>
                                <option>9:00 am - to - 10:00 am</option>
                                <option>10:00 am to - 11:00 am</option>
                                <option>11:00 am - to - 12:00 pm</option>
                                <option>12:00 pm - to - 1:00 pm</option>
                                <option>1:00 pm - to - 2:00 pm</option>
                                <option>2:00 pm - to - 3:00 pm</option>
                                <option>3:00 pm - to - 4:00 pm</option>
                                <option>4:00 pm - to - 5:00 pm</option>
                                <option>5:00 pm - to - 6:00 pm</option>
                                <option>6:00 pm - to - 7:00 pm</option>
                            </select>
                            <span style="color:red"></span>

                            <select name="drop_time" id="drop_time" class="input-block-level">
                                <option>Drop off Time</option>
                                <option>6:00 am - to - 7:00 am</option>
                                <option>7:00 am - to - 8:00 am</option>
                                <option>8:00 am - to - 9:00 am</option>
                                <option>9:00 am - to - 10:00 am</option>
                                <option>10:00 am to - 11:00 am</option>
                                <option>11:00 am - to - 12:00 pm</option>
                                <option>12:00 pm - to - 1:00 pm</option>
                                <option>1:00 pm - to - 2:00 pm</option>
                                <option>2:00 pm - to - 3:00 pm</option>
                                <option>3:00 pm - to - 4:00 pm</option>
                                <option>4:00 pm - to - 5:00 pm</option>
                                <option>5:00 pm - to - 6:00 pm</option>
                                <option>6:00 pm - to - 7:00 pm</option>
                            </select>
                            <span style="color:red" id="timestatus2"></span>

                            <label>How Many People</label>
                            <select class="input-block-level" name="package_quantity" id="package_quantity" onchange="calculateTotal()">
                                <option value="0"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <span style="color:red" id="quantity"></span>
                            Transport
                            <select name="transport" id="transport" required="required" class="input-block-level" onchange="calculateTotal()">
                                <option value="0"></option>
                                <option value="Taxi">Taxi </option>
                            </select>
                            <span style="color:red" id="transport"></span>
                            <input type="hidden" placeholder="Order Number" name="order_number" class="form-control" value="<?php echo $a = rand(10000, 99999); ?>" required />
                            <input type="hidden" name="delivery_type" class="form-control" value="Taxi" required />
                            <label>Add a note for the driver</label>
                            <textarea rows="6" class="input-block-level" placeholder="Add a note for the driver" id="note" name="note">please be on time</textarea>
                            <span style="color:red" id="msg"></span>
                            <input type="hidden" id="outputDiv">
                            <input type="hidden" id="outputDist" name="distance">
                            <input type="hidden" id="tpp" name="Total_price">
                            <b style="font-size:18px;">Total price:$</b><span id="tp" style="font-size:18px;"></span>
                            <br /><br />
                            <div style="background-color:#193b50; color:#fff;" class="btn btn-default btn-file">
                                <input type="checkbox" class="input-checkbox" name="harm" id="harm" value="nothing harmful" required="required"> I hereby acknowledge that I have read and understood your <a href="terms.php"> terms and conditions</a> as provided.
                            </div><br /><br />
                            <span id="harmstatus" style="color:red"></span>
                            <input type="submit" class="btn btn-success btn-large btn-block" onclick="submitForm()" value="Book a Taxi">

                        </div>
                        <input type="hidden" name="MM_insert" value="bookingform">
                    </form>
                </fieldset>
            </div>
        </div>
    </section>

    <script>
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

        var placeSearch, autocomplete, drop_address;

        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'Harare',
            administrative_area_level_1: 'short_name',
            country: 'Zimbabwe',
            postal_code: '00263'
        };

        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                (document.getElementById('autocomplete')), {
                    types: ['geocode']
                });

            drop_address = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                (document.getElementById('drop_address')), {
                    types: ['geocode']
                });

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }


        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            var place = drop_address.getPlace();

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAASD--ei5pvGlTxWLBswb4z4q_4J2vQS4&libraries=places&callback=initAutocomplete" async defer></script>

    <div id="map-canvas"></div>
    <script src="http://static.jsbin.com/js/render/edit.js?4.0.4"></script>
    <script>
        jsbinShowEdit && jsbinShowEdit({
            "static": "http://static.jsbin.com",
            "root": "http://jsbin.com"
        });
    </script>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-1656750-34', 'auto');
        ga('require', 'linkid', 'linkid.js');
        ga('require', 'displayfeatures');
        ga('send', 'pageview');
    </script>
    <!-- /#registration-page -->

    <section id="bottom" class="main">
        <!--Container-->
        <div class="container">

            <!--row-fluids-->
            <div class="row-fluid">

                <!--Contact Form-->
                <div class="span3">
                    <h4>ADDRESS</h4>
                    <ul class="unstyled address">
                        <li>
                            <i class="icon-home"></i><strong>Address:</strong> Harare <br>Zimbabwe
                        </li>
                        <li>
                            <i class="icon-envelope"></i>
                            <strong>Email: </strong> admin@merchantcouriers.co.zw
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong> www.merchantcouriers.co.zw
                        </li>
                        <li>
                            <i class="icon-phone"></i>
                            <strong>Mobile No:</strong> +263772467352
                        </li>
                    </ul>
                </div>
                <!--End Contact Form-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>OUR COMPANY</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="about-us.php">About Us</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="terms.php">Terms of Use</a></li>
                            <li><a href="privacy.php">Privacy Policy</a></li>
                            <li><a href="#">Copyright</a></li>
                    </div>
                </div>
                <!--Important Links-->

                <!--Archives-->
                <div id="archives" class="span3">
                    <h4>SERVICES LOCATIONS</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="#">Harare, Zimbabwe</a></li>
                        </ul>
                    </div>
                </div>
                <!--End Archives-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>Other Pages</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="blog.php">News & Updates</a></li>
                            <li><a href="#">We're Hiring</a></li>
                        </ul>
                    </div>
                </div>
                <!--Important Links-->

    </section>
    <!--/bottom-->

    <!--Footer-->
    <footer id="footer">
        <div class="container">
            <div class="row-fluid">
                <div class="span5 cp">
                    &copy; <?php echo date("Y"); ?> <a target="_blank" href="https://merchantcouriers.co.zw/" title="Merchant Courers">Merchant Couriers</a>. All Rights Reserved.
                </div>
                <!--/Copyright-->

                <div class="span6">
                    <ul class="social pull-right">
                        <li><a href="https://www.facebook.com/sharer.php?u=https://merchantcouriers.co.zw" target="_blank"><i class="icon-facebook"></i></a></li>
                        <li><a href="https://twitter.com/share?url=https://merchantcouriers.co.zw&amp;text=merchant%20couriers&amp;hashtags=merchantcouriers" target="_blank"><i class="icon-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https://merchantcouriers.co.zw" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <li><a href="https://plus.google.com/share?url=https://merchantcouriers.co.zw" target="_blank"><i class="icon-google-plus"></i></a></li>
                        <li><a href="#"><i class="icon-instagram"></i></a></li>
                        <li><a href="whatsapp://send?abid=username&text=HeyThere!"><img src="images/whatsapp.png" width="28px" alt="" /></a></li>
                    </ul>
                </div>

                <div class="span1">
                    <a id="gototop" class="gototop pull-right" href="#"><i class="icon-angle-up"></i></a>
                </div>
                <!--/Goto Top-->
            </div>
        </div>
    </footer>
    <!--/Footer-->

    <!--  Login form -->
    <div class="modal hide fade in" id="loginForm" aria-hidden="false">
        <div class="modal-header">
            <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
            <h4>Login Form</h4>
        </div>
        <!--Modal Body-->
        <div class="modal-body">
            <form class="form-inline" action="<?php echo $loginFormAction; ?>" method="POST" id="form-login">
                <input type="text" class="input-small" name="email" placeholder="Email">
                <input type="password" class="input-small" name="password" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox"> Remember me
                </label>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
            <a href="#">Forgot your password?</a>
            <p>Don't have an account? <a href="registration.php">register</a> </p>
        </div>
        <!--/Modal Body-->
    </div>
    <!--  /Login form -->

    <script src="js/vendor/jquery-1.9.1.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5abf88e04b401e45400e3b3b/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>
